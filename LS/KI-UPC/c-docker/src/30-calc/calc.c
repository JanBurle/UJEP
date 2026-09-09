// Simple expression calculator

// Grammar:
//   expr    = term   { ('+' | '-') term }
//   term    = factor { ('*' | '/') factor }
//   factor  = ['+' | '-'] factor | primary
//   primary = NUMBER | '(' expr ')'

#include <ctype.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>

typedef char const* str;
typedef double num;

// == parser state ==

static str src; // full input line (for error reporting)
static str pos; // current position in input
static int err; // non-zero after first error

// == error reporting ==

static num fail(str msg) {
    if (!err) {
        int col = (int) (pos - src) + 1;
        fprintf(stderr, "  %s\n", src);
        fprintf(stderr, "  %*s^\n", col - 1, "");
        fprintf(stderr, "  error at column %d: %s\n", col, msg);
        err = 1;
    }

    return 0;
}

// == lexer helpers ==

static void skip_ws(void) {
    while (isspace(*pos))
        pos++;
}

static char peek(void) {
    skip_ws();
    return *pos;
}

static char get(void) {
    skip_ws();
    return *pos++;
}

// == recursive descent parser ==

static num parse_expr(void);

static num parse_primary(void) {
    char c = peek();

    // parenthesised sub-expression
    if (c == '(') {
        get();
        num val = parse_expr();
        if (peek() != ')')
            return fail("expected ')'");
        get();
        return val;
    }

    // number: optional sign already handled by parse_factor;
    if (isdigit(c) || c == '.') {
        char* end;
        num val = strtod(pos, &end);
        if (end == pos)
            return fail("expected a number");
        pos = end;
        return val;
    }

    return fail("unexpected character");
}

static num parse_factor(void) {
    char c = peek();

    // unary + / -
    if (c == '+') {
        get();
        return +parse_factor();
    }

    if (c == '-') {
        get();
        return -parse_factor();
    }

    return parse_primary();
}

static num parse_term(void) {
    num val = parse_factor();

    for (;;) {
        char c = peek();
        if (c == '*') {
            get();
            val *= parse_factor();
        } else if (c == '/') {
            get();
            num rhs = parse_factor();
            if (rhs == 0.0 && !err)
                return fail("division by zero");
            val /= rhs;
        } else {
            break;
        }
    }

    return val;
}

static num parse_expr(void) {
    num val = parse_term();

    for (;;) {
        char c = peek();
        if (c == '+') {
            get();
            val += parse_term();
        } else if (c == '-') {
            get();
            val -= parse_term();
        } else
            break;
    }

    return val;
}

// == driver ==

static void evaluate(str line) {
    src = line;
    pos = line;
    err = 0;

    num result = parse_expr();

    if (err)
        return;

    // anything left (besides whitespace) is unexpected
    skip_ws();
    if (*pos) {
        fail("unexpected token");
        return;
    }

    printf("  = %g\n", result);
}

int main(void) {
    char line[1024];

    printf("Calculator – enter an expression, or an empty line to quit.\n");

    for (;;) {
        printf("> ");
        fflush(stdout);

        if (!fgets(line, sizeof(line), stdin))
            break;

        // strip trailing whitespace
        for (size_t len = strlen(line); len-- && isspace(line[len]);)
            line[len] = '\0';

        // empty line → quit
        if (!line[0])
            break;

        evaluate(line);
    }

    return 0;
}
