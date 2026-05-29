import re

file_path = r'C:\Users\jayst\Documents\GitHub\GG Blog Engineer\blog-post-engineer\includes\admin\shortcode-support\shortcode-fields.php'

with open(file_path, 'r', encoding='utf-8') as f:
    content = f.read()

# Replace all occurrences of misplaced section closes
# The bug is that `),` (3 tabs) appears BEFORE `)` (4 tabs)
# It should be `)` (5 tabs) BEFORE `),` (3 tabs)
new_content, count = re.subn(r'\t{3}\),\r?\n\t{4}\)', "\t\t\t\t\t)\n\t\t\t),", content)

print(f"Fixed {count} occurrences of swapped brackets.")

with open(file_path, 'w', encoding='utf-8') as f:
    f.write(new_content)
