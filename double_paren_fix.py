import re

file_path = r'C:\Users\jayst\Documents\GitHub\GG Blog Engineer\blog-post-engineer\includes\admin\shortcode-support\shortcode-fields.php'

with open(file_path, 'r', encoding='utf-8') as f:
    lines = f.readlines()

fixed_lines = []

for i, line in enumerate(lines):
    if line.startswith("\t\t\t),") or line.startswith("			),"):
        # find prev1 and prev2
        idx = i - 1
        prev1 = ''
        prev2 = ''
        
        while idx >= 0 and not lines[idx].strip():
            idx -= 1
        if idx >= 0:
            prev1 = lines[idx].strip()
            idx -= 1
            while idx >= 0 and not lines[idx].strip():
                idx -= 1
            if idx >= 0:
                prev2 = lines[idx].strip()
        
        if prev1 == ')' and prev2 == ')':
            fixed_lines.append("\t\t\t\t\t)\n")
            print(f"Inserted ) before line {i+1}")
            
    fixed_lines.append(line)

with open(file_path, 'w', encoding='utf-8') as f:
    f.writelines(fixed_lines)

print("Double-parenthesis fix applied.")
