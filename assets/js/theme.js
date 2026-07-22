/**
 * Ghodaghodi View Theme JS
 */
document.addEventListener('DOMContentLoaded', function () {
    var menuToggle = document.getElementById('mobile-menu-toggle');
    var mobileMenu = document.getElementById('mobile-menu');

    if (menuToggle && mobileMenu) {
        menuToggle.addEventListener('click', function () {
            mobileMenu.classList.toggle('hidden');
        });
    }
});
