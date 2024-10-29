import csv
import re

# Step 1: Download the text file (manually or using wget)
# wget -O gutenberg.txt "http://www.gutenberg.org/files/1342/1342-0.txt"

# Step 2: Read the text file
with open('C:\\cygwin64\\home\\jan\\GH\\UJEP\\KI-RDBS\\Docker\\texts\\RUR.txt', 'r', encoding='utf-8') as file:
    content = file.read()

# Step 3: Split content by blank lines
content = re.sub(r'\n\n+', '\n\n', content)
entries = content.split('\n\n')

def sanitize(entry):
    entry = re.sub(r'\s+', ' ', entry)
    entry = entry.replace('\n', ' ')
    return entry.strip()

# Step 4: Write the entries to a CSV file
with open('C:\\cygwin64\\home\\jan\\GH\\UJEP\\KI-RDBS\\Docker\\texts\\RUR.csv', 'w', newline='', encoding='utf-8') as csvfile:
    writer = csv.writer(csvfile)
    writer.writerow(['id', 'content'])  # Write header
    for idx, entry in enumerate(entries, start=1):
        writer.writerow([idx, sanitize(entry)])

print("Conversion to CSV completed.")
