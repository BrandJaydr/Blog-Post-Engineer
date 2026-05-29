import re

file_path = r'C:\Users\jayst\Documents\GitHub\GG Blog Engineer\blog-post-engineer\includes\admin\shortcode-support\shortcode-fields.php'

with open(file_path, 'r', encoding='utf-8') as f:
    lines = f.readlines()

sections_to_fix_all = ['pagination']
sections_to_fix_nonfirst = ['meta', 'query', 'filter', 'slider', 'social_sharing', 'style_manager']

fixed_lines = []
in_target_section = False
current_section = ""
in_function_1 = True

for i, line in enumerate(lines):
    if "function bdp_post_slider_lite_shortcode_fields" in line:
        in_function_1 = False
        
    # Check if we are opening a target section
    m = re.search(r"^\s*'(" + "|".join(sections_to_fix_all + sections_to_fix_nonfirst) + r")'\s*=>\s*array\(", line)
    if m:
        current_section = m.group(1)
        if current_section in sections_to_fix_all or (current_section in sections_to_fix_nonfirst and not in_function_1):
            in_target_section = True
        fixed_lines.append(line)
        continue
    
    if in_target_section:
        if line.startswith("\t\t\t),") or line.startswith("			),"):
            fixed_lines.append("\t\t\t\t\t)\n")
            in_target_section = False
            
    fixed_lines.append(line)

with open(file_path, 'w', encoding='utf-8') as f:
    f.writelines(fixed_lines)

print("Exact targeted fix applied.")
