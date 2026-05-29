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
            prev_line = fixed_lines[-1].replace('\n', '').replace('\r', '')
            
            # Count leading tabs
            tabs = 0
            for char in prev_line:
                if char == '\t':
                    tabs += 1
                else:
                    break
            
            # If the previous line is `)`, check its indentation
            if prev_line.strip() == ')':
                if tabs > 5:
                    fixed_lines.append("\t\t\t\t\t)\n")
                    print(f"Inserted ) in section {current_section} (prev line had {tabs} tabs)")
            elif prev_line.strip() == ')' or prev_line.strip() == '),':
                 # Wait, sometimes it ends with `),`
                 if tabs > 5:
                    fixed_lines.append("\t\t\t\t\t)\n")
                    print(f"Inserted ) in section {current_section} (prev line had {tabs} tabs, ended with {prev_line.strip()})")
            
            in_target_section = False
            
    fixed_lines.append(line)

with open(file_path, 'w', encoding='utf-8') as f:
    f.writelines(fixed_lines)

print("Smart heuristic fix applied.")
