/* ==========================================================================
   CarTur - JavaScript minimalista
   ========================================================================== */

(function () {
    'use strict';

    /* --- Menú móvil --- */
    const toggle = document.querySelector('.navbar__toggle');
    const menu = document.querySelector('.navbar__menu');

    if (toggle && menu) {
        toggle.addEventListener('click', function () {
            const isOpen = menu.style.display === 'flex';
            if (isOpen) {
                menu.style.cssText = '';
            } else {
                menu.style.cssText = `
                    display: flex;
                    flex-direction: column;
                    position: absolute;
                    top: 100%;
                    right: 20px;
                    background: #0a0a0a;
                    border: 1px solid #262626;
                    padding: 20px;
                    min-width: 200px;
                    gap: 20px;
                `;
            }
        });
    }

    /* --- Smooth scroll con offset --- */
    document.querySelectorAll('a[href^="#"]').forEach(function (link) {
        link.addEventListener('click', function (e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#' || targetId.length <= 1) return;
            const target = document.querySelector(targetId);
            if (!target) return;
            e.preventDefault();
            const offset = 80;
            const pos = target.getBoundingClientRect().top + window.pageYOffset - offset;
            window.scrollTo({ top: pos, behavior: 'smooth' });
        });
    });

    /* --- Asegura que la marca activa sea visible en la barra horizontal --- */
    const brandBar = document.querySelector('.brand-bar');
    if (brandBar) {
        const activeLink = brandBar.querySelector('.brand-bar__link.is-active');
        if (activeLink) {
            setTimeout(function () {
                activeLink.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest',
                    inline: 'center',
                });
            }, 100);
        }
    }

    /* --- Fade-in al hacer scroll --- */
    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.section__head, .brand-header').forEach(function (el) {
        observer.observe(el);
    });

})();
