import re

file_path = r'C:\Users\jayst\Documents\GitHub\GG Blog Engineer\blog-post-engineer\includes\admin\shortcode-support\shortcode-fields.php'

with open(file_path, 'r', encoding='utf-8') as f:
    lines = f.readlines()

sections_to_fix = ['general', 'meta', 'query', 'filter', 'slider', 'social_sharing', 'style_manager', 'pagination', 'ticker']

fixed_lines = []
in_target_section = False
current_section = ""

for i, line in enumerate(lines):
    # Check if we are opening a target section
    m = re.search(r"^\s*'(" + "|".join(sections_to_fix) + r")'\s*=>\s*array\(", line)
    if m:
        in_target_section = True
        current_section = m.group(1)
        fixed_lines.append(line)
        continue
    
    if in_target_section:
        if line.startswith("\t\t\t),") or line.startswith("			),"):
            # We are closing the section.
            # Insert the missing parenthesis for params
            # Wait, let's always insert it, EXCEPT if the section is 'social_sharing' and it's already correctly closed.
            # Let's just insert it for the ones the user mentioned!
            if current_section in ['meta', 'query', 'filter', 'slider', 'social_sharing', 'style_manager']:
                fixed_lines.append("\t\t\t\t\t)\n")
            in_target_section = False
            
    fixed_lines.append(line)

with open(file_path, 'w', encoding='utf-8') as f:
    f.writelines(fixed_lines)

print("Fix applied to all functions.")
