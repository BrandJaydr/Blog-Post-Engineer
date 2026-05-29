import os
import subprocess

file_path = r'C:\Users\jayst\Documents\GitHub\GG Blog Engineer\blog-post-engineer\includes\admin\shortcode-support\shortcode-fields.php'

with open(file_path, 'r', encoding='utf-8') as f:
    lines = f.readlines()

func1_lines = []
in_func1 = False
for line in lines:
    if "function bdp_post_lite_shortcode_fields" in line:
        in_func1 = True
    if in_func1:
        func1_lines.append(line)
        if line.startswith("}"):
            break

# prepend <?php
func1_content = "<?php\n" + "".join(func1_lines)

with open("test.php", "w", encoding="utf-8") as f:
    f.write(func1_content)

print(f"test.php created with {len(func1_lines)} lines.")
