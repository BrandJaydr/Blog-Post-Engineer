import subprocess
import re

with open("test.php", "r", encoding="utf-8") as f:
    original_lines = f.readlines()

sections = ['general', 'meta', 'query', 'pagination', 'social_sharing', 'filter', 'style_manager']

for section_to_test in sections:
    lines = list(original_lines)
    in_section = False
    for i in range(len(lines)):
        m = re.search(r"^\s*'(" + "|".join(sections) + r")'\s*=>\s*array\(", lines[i])
        if m:
            if m.group(1) == section_to_test:
                in_section = True
            else:
                in_section = False
        
        if in_section:
            lines[i] = "// " + lines[i]
            if lines[i].startswith("// \t\t\t),") or lines[i].startswith("// 			),"):
                in_section = False

    with open("test_modified.php", "w", encoding="utf-8") as f:
        f.writelines(lines)
        
    result = subprocess.run(["php", "-l", "test_modified.php"], capture_output=True, text=True)
    if result.returncode == 0:
        print(f"Commenting out {section_to_test} FIXED the syntax error!")
    else:
        print(f"Commenting out {section_to_test} did not fix it.")
