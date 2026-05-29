with open('test.php', 'r', encoding='utf-8') as f:
    lines = f.readlines()
in_pag = False
pag_lines = []
for line in lines:
    if "'pagination' => array(" in line:
        in_pag = True
    if in_pag:
        pag_lines.append(line)
        if line.startswith("\t\t\t),"):
            break

depth = 0
for i, line in enumerate(pag_lines):
    # print(f"{i+1}: {line.rstrip()}")
    line_no_str = line.split('//')[0].replace("'pagination'", "''").replace("'type'", "''")
    # this is too hacky. Let's just print the whole thing and I'll read it
    
for i, line in enumerate(pag_lines):
    print(f"{i+1}: {line.rstrip()}")
