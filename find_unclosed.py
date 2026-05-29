import re
import json

file_path = r'C:\Users\jayst\Documents\GitHub\GG Blog Engineer\blog-post-engineer\includes\admin\shortcode-support\shortcode-fields.php'

with open(file_path, 'r', encoding='utf-8') as f:
    lines = f.readlines()

output = []
for i, line in enumerate(lines):
    if re.search(r"'(meta|query|filter|slider|social_sharing|style_manager)'\s*=>\s*array\(", line):
        # find the end of this array
        # we know it ends with `),` and is missing a `)` before it for `params`
        # let's find the `params` inside this section
        for j in range(i, len(lines)):
            if "'params'" in lines[j] and "=> array(" in lines[j]:
                # found params
                break
        
        # now find the closing `),` for the section.
        # It's at a specific indentation level. The `section => array(` is usually indented 2 tabs (or 8 spaces).
        indent = len(line) - len(line.lstrip())
        for j in range(i + 1, len(lines)):
            if lines[j].startswith(line[:indent] + "),"):
                # we found the closing of the section.
                # let's see if the line before it is a `)` closing the params array
                prev_line = lines[j-1].strip()
                if prev_line != ")":
                    output.append({
                        "section": line.strip(),
                        "start_line": i+1,
                        "close_line": j+1,
                        "close_str": lines[j].rstrip(),
                        "prev_line": lines[j-1].rstrip()
                    })
                break

print(json.dumps(output, indent=2))
