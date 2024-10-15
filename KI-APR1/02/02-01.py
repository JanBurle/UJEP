# Napište program, který se uživatele zeptá na jméno, věk, bydliště (atd.)
# a pak vypíše text: Dobrý den, ..., Vaším domovem je ...
# a za rok Vám bude ... let.

jméno    = input('Jak se jmenujete? ')      # type: str
bydliště = input('Kde bydlíte? ')           # str
věk      = int(input('Kolik je Vám let? ')) # int

print(f'Dobrý den, pane/paní {jméno},')
print(f'bydlíte v městě {bydliště}')
print(f'a za rok Vám bude {věk + 1} let.')
