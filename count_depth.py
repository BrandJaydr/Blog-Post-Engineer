import re

file_path = r'C:\Users\jayst\Documents\GitHub\GG Blog Engineer\blog-post-engineer\includes\admin\shortcode-support\shortcode-fields.php'

with open(file_path, 'r', encoding='utf-8') as f:
    lines = f.readlines()

depth = 0
for i in range(653): # function 1 ends around 653
    line = lines[i].split('//')[0] # remove comments
    
    # We must be careful about strings. Let's just strip strings first.
    # Replace all single and double quoted strings with ''
    # Actually, a simple regex is better:
    line_no_strings = re.sub(r"'[^']*'", "''", line)
    line_no_strings = re.sub(r'"[^"]*"', '""', line_no_strings)
    
    opens = line_no_strings.count('array(')
    closes1 = line_no_strings.count(')')
    closes2 = line_no_strings.count('],') # sometimes php uses []
    
    depth += opens
    depth -= closes1
    depth -= closes2
    
print(f"Depth at end of function 1: {depth}")
