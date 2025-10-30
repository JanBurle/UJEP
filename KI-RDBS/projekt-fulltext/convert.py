import csv
import re

with open('./texts/RUR.txt', 'r', encoding='utf-8') as file:
    content = file.read()

# split by blank lines
content = re.sub(r'\n\n+','\n\n', content)
entries = content.split('\n\n')

def sanitize(entry):
    entry = re.sub(r'\s+', ' ', entry)
    entry = entry.replace('\n', ' ')
    return entry.strip()

with open('./texts/RUR.csv', 'w', newline='', encoding='utf-8') as csvfile:
    writer = csv.writer(csvfile)
    for idx, entry in enumerate(entries, start=1):
        writer.writerow([idx, sanitize(entry)])

print("Conversion to CSV completed.")
