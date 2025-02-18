const search = document.querySelector('.input-group input'),
    radioButtons = document.querySelectorAll('.radio-inputs input[name="column"]'),
    table_rows = document.querySelectorAll('tbody tr'),
    table_headings = document.querySelectorAll('thead th');

search.addEventListener('input', filterTable);
radioButtons.forEach(radio => radio.addEventListener('change', filterTable));

function filterTable() {
    const selectedColumnIndex = getSelectedColumnIndex();

    table_rows.forEach((row, i) => {
        let table_data = row.cells[selectedColumnIndex].textContent.toLowerCase(),
            search_data = search.value.toLowerCase();

        row.classList.toggle('hide', table_data.indexOf(search_data) < 0);
        row.style.setProperty('--delay', i / 25 + 's');
    });

    document.querySelectorAll('tbody tr:not(.hide)').forEach((visible_row, i) => {
        visible_row.style.backgroundColor = (i % 2 == 0) ? 'transparent' : '#0000000b';
    });
}

function getSelectedColumnIndex() {
    const selectedRadio = document.querySelector('.radio-inputs input[name="column"]:checked');
    return parseInt(selectedRadio.value);
}
