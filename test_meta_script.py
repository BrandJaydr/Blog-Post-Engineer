import subprocess

with open('test.php', 'r', encoding='utf-8') as f:
    lines = f.readlines()
in_meta = False
for i in range(len(lines)):
    if "'meta' => array(" in lines[i]:
        in_meta = True
    if in_meta:
        lines[i] = '// ' + lines[i]
        if lines[i].startswith('// \t\t\t),'):
            in_meta = False
with open('test_meta.php', 'w', encoding='utf-8') as f:
    f.writelines(lines)

print(subprocess.run(['php', '-l', 'test_meta.php'], capture_output=True, text=True).stdout)
