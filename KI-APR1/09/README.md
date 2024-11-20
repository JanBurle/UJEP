# 09 –

PB2

**Úkol HW2.7: Trefa do kulatého terče**

Napište program, který vystřelí náhodně do čtverce. V tomto čtverci je umístěna kružnice s daným středem a poloměrem. Program zahlásí výstřel, pokud souřadnice náhodného výstřelu jsou uvnitř kružnice (terč).

**HW3.6 - Fibonacciho posloupnost**

Napište program, který vypíše na obrazovku Fibonacciho posloupnost od hodnoty 0 do hodnoty zadané uživatelem (generace králíků).

PB3 plt

PB5

**OS5.1 - Předkladový slovník**

Napište program, který obsahuje slovník, kde klíčem je české slovo a hodnotou je jeho anglický předklad. Následně využijte slovník pro překlad následující věty: "Pes na kole jel a stekal na postaka.".

```
slovnik_z_cj_do_aj = {"pes": "dog","na": "on","stekal": "barked","postaka": "postman",}
veta_cz = "Pes na kole jel a stekal na postaka."
veta_cz = veta_cz.lower().replace(".", "")
veta_en = ""
for slovo in veta_cz.split():
    if slovo in slovnik_z_cj_do_aj: #.keys()
        veta_en += slovnik_z_cj_do_aj[slovo] + " "
    else:
        veta_en += slovo + " "
veta_en
```

**OS5.2 - Hromadný předkladač**

Napište program, který přeloží větu do třech různých jazyků pomocí tří překladových slovníků. Neopakujte kód a zapřemýšlejte se nad tím, jak lze situaci vyřešit pomocí FOR cyklu.

```
slovnik_z_cj_do_aj = {"pes": "dog","na": "on","stekal": "barked","postaka": "postman",}
slovnik_z_cj_do_nj = {"pes": "Hund","na": "an","stekal": "geflossen","postaka": "genügend",}
slovnik_z_cj_do_fj = {"pes": "koira","na": "päällä","stekal": "hän haukkui","postaka": "tarpeeksi",}

slovniky = [slovnik_z_cj_do_aj, slovnik_z_cj_do_nj, slovnik_z_cj_do_fj, ]

veta_cz = input("zadej vetu: ")
veta_cz = veta_cz.lower().replace(".", "")

for slovnik in slovniky:
    prelozena_veta = ""
    for slovo in veta_cz.split():
        if slovo in slovnik: #.keys()
            prelozena_veta += slovnik[slovo] + " "
        else:
            prelozena_veta += slovo + " "
    print(prelozena_veta)
```

**OS5.5 - Modelování entit pomocí slovníků**

Napište program, který obsahuje seznam klientů a jejich akciové portfolio. Každý klient v seznamu klientů bude reprezentován slovníkem s následujícími atributy: jméno, emailový kontakt a držené akcie. O klientech víte následující informace:

1. Jiří Guláš má email gulas@gmail.cz a vlastní 50 akcií Applu, 100 akcií IBM a 70 akcií Microsoftu.
2. Richard Polívka má email polivka@gmail.cz a vlastní 30 akcií Tesly, 50 akcií IBM a 20 akcií Microsoftu.

Napište následně malý skript, který vypíše jména těch uživatelů ze seznamu klientů, které drží alespoň nějaké akcie firmy Apple.

```
klienti = [
    {
        'jmeno': 'Jiri Guláš',
        'kontakt': 'gulas@gmail.cz',
        'akcie': {
            'APL': 50,
            'IBM': 100,
            'MSC': 70,
        },
    },
    {
        'jmeno': 'Richard Polívka',
        'kontakt': 'polivka@gmail.cz',
        'akcie': {
            'TSL': 30,
            'IBM': 50,
            'MSC': 20,
        },
    },
]

for klient in klienti:
    if "APL" in klient["akcie"]:
        print(klient['jmeno'])
```

**HW5.3 - Průměrná známka**

Napište funkci, která vrátí průměrnou známku třídy. Známky třídy budou vloženy jako slovník, kde klíčem je jméno studenta a hodnotou je seznam jeho známek.

**OS6.2: Vyhledání pozice slova**

Napište funkci, která vrátí index prvku, který vyhledáváte. Nepoužívejte předpřipravenou funkci index nad seznamem.

```
př.: get_index([g,f,a,f,h], a) -> 2
```

```
def vrat_index_prvku(prvky: list, hledany_prvek: any) -> int:
    for idx in range(len(prvky)):
        if prvky[idx] == hledany_prvek:
            return idx

print(vrat_index_prvku([1,2,3,4,5,6], 4))
```
