with open('test.php', 'r', encoding='utf-8') as f:
    lines = f.readlines()
in_meta = False
meta_lines = []
for line in lines:
    if "'meta' => array(" in line:
        in_meta = True
    if in_meta:
        meta_lines.append(line)
        if line.startswith("\t\t\t),"):
            break

depth = 0
for i, line in enumerate(meta_lines):
    print(f"{i+1}: {line.rstrip()}")
    depth += line.count('array(')
    depth -= line.count(')')
    depth -= line.count('],')
print(f'Final depth for meta: {depth}')
