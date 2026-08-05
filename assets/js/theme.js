document.addEventListener('DOMContentLoaded', function () {
    var menuToggle = document.getElementById('mobile-menu-toggle');
    var mobileMenu = document.getElementById('mobile-menu');

    if (menuToggle && mobileMenu) {
        menuToggle.addEventListener('click', function () {
            mobileMenu.classList.toggle('hidden');
        });
    }

    var header = document.getElementById('header');
    if (header) {
        var onScroll = function () {
            header.classList.toggle('scrolled', window.scrollY > 80);
        };
        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });
    }

    var slider = document.getElementById('hero-slider');
    if (!slider) return;

    var slides = slider.querySelectorAll('.hero-slide');
    var dots = slider.querySelectorAll('.hero-slider-dot');
    if (slides.length < 2) return;

    var current = 0;
    var interval;

    function goTo(index) {
        slides.forEach(function (s, i) {
            s.classList.toggle('active', i === index);
        });
        dots.forEach(function (d, i) {
            d.classList.toggle('active', i === index);
        });
        current = index;
    }

    function nextSlide() {
        goTo((current + 1) % slides.length);
    }

    function startAuto() {
        stopAuto();
        interval = setInterval(nextSlide, 5000);
    }

    function stopAuto() {
        if (interval) {
            clearInterval(interval);
            interval = null;
        }
    }

    dots.forEach(function (dot) {
        dot.addEventListener('click', function () {
            goTo(parseInt(this.getAttribute('data-index')));
            startAuto();
        });
    });

    slider.addEventListener('mouseenter', stopAuto);
    slider.addEventListener('mouseleave', startAuto);

    startAuto();
});

document.addEventListener('DOMContentLoaded', function () {
    var copyButtons = document.querySelectorAll('.ghodaghodi-copy-link');

    copyButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            var url = button.getAttribute('data-url');

            function copied() {
                var label = button.getAttribute('data-copied') || 'Copied!';
                var original = button.innerHTML;
                button.innerHTML = '<i class="fa-solid fa-check"></i>';
                button.setAttribute('data-copied', label);
                setTimeout(function () {
                    button.innerHTML = original;
                }, 2000);
            }

            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(url).then(copied);
            } else {
                var textarea = document.createElement('textarea');
                textarea.value = url;
                textarea.style.position = 'fixed';
                textarea.style.opacity = '0';
                document.body.appendChild(textarea);
                textarea.select();
                try {
                    document.execCommand('copy');
                    copied();
                } catch (err) {
                    window.prompt('Copy link:', url);
                }
                document.body.removeChild(textarea);
            }
        });
    });
});
