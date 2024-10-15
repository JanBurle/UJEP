# Automat na vodu a vodku se zeptá zákazníka na jméno a pozdraví jej jménem.
# Nejdříve se zeptá se na věk: mladým pogratuluje k jejich mládí
# a starším k jejich moudrosti.
# Dále se zeptá, zda si zákazník žádá vodu nebo vodku.
# Starším prodá vodu i vodku, mladým ale jen vodu.

jméno = input('Jak se jmenujete? ')
print(f'Dobrý den, pane/paní {jméno},')

věk = int(input('Kolik je Vám let? ')) # int

AGE = 18            # hranice dospělosti
mladistvý = věk<AGE # bool
print(f'Gratuluji k {"Vašemu mládí" if mladistvý else "Vaší moudrosti"}!')

volba = input('Přejete si vodu nebo vodku? ')
chciVodu = 'vodu' == volba # bool, True: vodu, False: vodku

# texty
dámVodu    = 'Zde je voda.'
dámVodku   = 'Zde je vodka.'
nedámVodku = 'Zde je voda místo vodky.'

# hotovo, rozhodnuto
výdej = (dámVodu if chciVodu else nedámVodku) if mladistvý else (dámVodu if chciVodu else dámVodku)
print('Děkuji za důvěru.', výdej)
