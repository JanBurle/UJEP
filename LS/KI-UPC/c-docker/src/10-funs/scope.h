#pragma once

extern int global_counter; /* >>> */

void set_global_counter(int value);
void inc_global_counter(void);

int get_file_private_state(void);
void set_file_private_state(int value);

int call_count_demo(void);
