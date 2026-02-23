import random

def random_choice(strings):
    # Odfiltrujeme prázdné řetězce
    filtered = [s for s in strings if s != ""]

    # Pokud po filtraci nic nezbylo, vyhodíme výjimku
    if not filtered:
        raise ValueError("Seznam je prázdný nebo obsahuje pouze prázdné řetězce.")

    return random.choice(filtered)

# Test:
# print(random_choice(["", "Frodo", "Sam", "", "Pipin"]))

import math

def similar_lists(a, b):
    # Kontrola délky a prázdnosti
    if len(a) != len(b) or (not a and not b):
        raise ValueError("Seznamy mají různou délku nebo jsou oba prázdné.")

    # Porovnání prvků po prvcích
    for x, y in zip(a, b):
        if not math.isclose(x, y, rel_tol=1e-4): # tolerance cca 0.01%
            return False

    return True

# Test:
# print(similar_lists([1, -2.0], [1.00024, -1.99976]))

def ciferny_soucet(n):
    return sum(int(cifra) for cifra in str(n))

vysledky = []
for cislo in range(1, 1993): # range do 1993 zahrne i 1992
    if cislo % 6 == 0 and ciferny_soucet(cislo) % 7 == 0:
        vysledky.append(str(cislo))

with open("six_seven.txt", "w", encoding="utf-8") as f:
    # Seskupení po 10 prvcích
    for i in range(0, len(vysledky), 10):
        radek = " ".join(vysledky[i:i+10])
        f.write(radek + "\n")

def group_by(strings):
    groups = {}
    for s in strings:
        length = len(s)
        if length not in groups:
            groups[length] = s
        else:
            # Přidáme k existujícímu řetězci (v ukázce je "Bilbo, Frodo",
            # takže pro pořadí dle ukázky by se muselo řadit, ale zadání to nevyžaduje striktně)
            current_elements = groups[length].split(", ")
            current_elements.append(s)
            # Volitelně: seřadíme prvky abecedně, aby to odpovídalo ukázce
            current_elements.sort()
            groups[length] = ", ".join(current_elements)

    return groups

# Test:
# print(group_by(["Frodo", "Bilbo", "Boromir", "Faramir"]))

