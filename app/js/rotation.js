function getRandomColor() {
    const letters = '0123456789ABCDEF';
    let color = '#';
    for (let i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

function animateBarkane() {
    const barkaneDiv = document.getElementById('barkane-animation');
    if (!barkaneDiv) return;
    const letters = barkaneDiv.innerText.split(' ');
    barkaneDiv.innerHTML = '';
    letters.forEach(letter => {
        const span = document.createElement('span');
        span.innerText = letter;
        if (letter.toUpperCase() === 'A') {
            span.classList.add('rotating');
        }
        barkaneDiv.appendChild(span);
    });
    const updateAnimation = () => {
        const spans = barkaneDiv.querySelectorAll('span');
        spans.forEach(span => {
            span.style.color = getRandomColor();
            span.style.fontSize = `${Math.floor(Math.random() * 15) + 30}px`;
        });
    };
    setInterval(updateAnimation, 800);
}

document.addEventListener('DOMContentLoaded', () => {
    animateBarkane();
});
