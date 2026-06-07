from pathlib import Path

from docx import Document


DOCX = Path("word/Квалификационная работа - главы 3.1-3.3 обновлены v2.docx")

doc = Document(DOCX)

for paragraph in doc.paragraphs:
    text = paragraph.text
    if text.startswith("3. Программная реализация веб-приложения аренды зарядных устройств"):
        paragraph.text = text.replace(
            "3. Программная реализация веб-приложения аренды зарядных устройств",
            "3. Программная реализация веб-приложения для ведения реестра оборудования",
        )
    if text.startswith("3.1 Архитектура веб-приложения аренды зарядных устройств"):
        paragraph.text = text.replace(
            "3.1 Архитектура веб-приложения аренды зарядных устройств",
            "3.1 Архитектура веб-приложения для ведения реестра оборудования",
        )

doc.save(DOCX)
print(DOCX)
