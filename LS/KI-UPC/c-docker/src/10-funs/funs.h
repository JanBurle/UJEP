#pragma once

int add(int a, int b);
int max(int a, int b);

void inc_by_value(int x);
void inc_by_pointer(int* x);

int factorial(int n);
double avg_dynamic(const int* values, int n);

typedef struct {
    int x;
    int y;
} Point;

Point create_point(int x, int y);
Point add_points(Point p1, Point p2);
