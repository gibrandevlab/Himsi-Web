document.addEventListener('DOMContentLoaded', function () {
    const slider = document.querySelector('.slider');
    const nextButton = document.querySelector('.slider-nav.next');
    const prevButton = document.querySelector('.slider-nav.prev');

    if (!slider || !nextButton || !prevButton) {
        console.error('Elemen slider atau tombol navigasi tidak ditemukan.');
        return;
    }

    // Menghitung lebar item slider
    const itemElement = document.querySelector('.proker-item');
    if (!itemElement) {
        console.error('Elemen .proker-item tidak ditemukan.');
        return;
    }

    const itemWidth = itemElement.offsetWidth + parseInt(window.getComputedStyle(itemElement).marginRight, 20);
    console.log('Item Width:', itemWidth);

    // Menangani klik tombol next
    nextButton.addEventListener('click', function () {
        slider.scrollBy({ left: itemWidth, behavior: 'smooth' });
    });

    // Menangani klik tombol prev
    prevButton.addEventListener('click', function () {
        slider.scrollBy({ left: -itemWidth, behavior: 'smooth' });
    });
});




    function smoothScroll(target, duration) {
        const targetElement = document.querySelector(target);
        if (!targetElement) return;

        const targetPosition = targetElement.getBoundingClientRect().top;
        const startPosition = window.pageYOffset;
        const distance = targetPosition - startPosition;
        const startTime = performance.now();

        function scroll(currentTime) {
            const timeElapsed = currentTime - startTime;
            const progress = Math.min(timeElapsed / duration, 1);
            const ease = easeInOutQuad(progress);

            window.scrollTo(0, startPosition + distance * ease);

            if (timeElapsed < duration) {
                requestAnimationFrame(scroll);
            }
        }

        function easeInOutQuad(t) {
            return t < 0.5 ? 2 * t * t : -1 + (4 - 2 * t) * t;
        }

        requestAnimationFrame(scroll);
    }

    document.querySelectorAll('.scroll-link').forEach(link => {
        link.addEventListener('click', (event) => {
            event.preventDefault();

            const target = link.getAttribute('href');
            smoothScroll(target, 1000);
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const elements = document.querySelectorAll('.container-count .count-value');

        elements.forEach(function(element) {
            const target = parseInt(element.textContent, 10);
            const duration = 1000;
            let start = null;

            function animate(currentTime) {
                if (start === null) {
                    start = currentTime;
                }
                const elapsed = currentTime - start;
                const progress = Math.min(elapsed / duration, 1);
                const value = Math.floor(progress * target);
                element.textContent = value.toLocaleString();
                if (progress < 1) {
                    window.requestAnimationFrame(animate);
                }
            }

            window.requestAnimationFrame(animate);
        });
    });


