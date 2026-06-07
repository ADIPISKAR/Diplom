from pathlib import Path
from docx import Document
p = Path('word/Квалификационная работа - главы 3.1-3.3 обновлены.docx')
doc = Document(p)
lines = [para.text.strip() for para in doc.paragraphs if para.text.strip()]
for i,t in enumerate(lines):
    if t.startswith('3.1 '):
        print('FOUND', i+1, t)
start = [i for i,t in enumerate(lines) if t.startswith('3.1 ')][-1]
end = next(i for i,t in enumerate(lines[start:], start) if t.startswith('4. Описание'))
print('---SECTION---')
for i, line in enumerate(lines[start:end], start+1):
    print(f'{i}: {line}')
