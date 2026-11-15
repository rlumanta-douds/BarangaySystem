const menuToggle = document.getElementById('menuToggle');
const sidebar = document.getElementById('sidebar');

if (menuToggle && sidebar) {
    menuToggle.addEventListener('click', () => {
        sidebar.classList.toggle('open');
    });
}

document.querySelectorAll('[data-confirm]').forEach((button) => {
    button.addEventListener('click', (event) => {
        const message = button.dataset.confirm || 'Are you sure?';

        if (!window.confirm(message)) {
            event.preventDefault();
        }
    });
});

document.querySelectorAll('[data-search]').forEach((input) => {
    input.addEventListener('input', () => {
        const table = document.querySelector(input.dataset.search);

        if (!table) return;

        const query = input.value.toLowerCase();

        table.querySelectorAll('tbody tr').forEach((row) => {
            row.hidden = !row.innerText.toLowerCase().includes(query);
        });
    });
});

