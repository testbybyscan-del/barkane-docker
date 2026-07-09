document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');

    form.addEventListener('submit', (e) => {
        const inputs = form.querySelectorAll('input[type="date"], input[type="text"]');
        let formValid = true;

        inputs.forEach(input => {
            input.style.border = '1px solid #ccc';
            if (!input.value.trim()) {
                formValid = false;
                input.style.border = '2px solid red';
            }
        });

        if (!formValid) {
            alert('Пожалуйста, укажите диапазон дат! Для получения более точной информации о мероприятиях заполните все поля перед отправкой.');
            e.preventDefault();
        }
    });
});
