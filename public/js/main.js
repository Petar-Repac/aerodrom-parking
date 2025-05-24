/**
 * Template Name: Valera
 * Template URL: https://bootstrapmade.com/valera-free-bootstrap-theme/
 * Updated: Mar 17 2024 with Bootstrap v5.3.3
 * Author: BootstrapMade.com
 * License: https://bootstrapmade.com/license/
 */
import Swiper from '../vendor/swiper/swiper-bundle.js'

(function() {
    "use strict";

    /**
     * Easy selector helper function
     */
    const select = (el, all = false) => {
        el = el.trim()
        if (all) {
            return [...document.querySelectorAll(el)]
        } else {
            return document.querySelector(el)
        }
    }

    /**
     * Easy event listener function
     */
    const on = (type, el, listener, all = false) => {
        let selectEl = select(el, all)
        if (selectEl) {
            if (all) {
                selectEl.forEach(e => e.addEventListener(type, listener))
            } else {
                selectEl.addEventListener(type, listener)
            }
        }
    }

    /**
     * Easy on scroll event listener
     */
    const onscroll = (el, listener) => {
        el.addEventListener('scroll', listener)
    }

    /**
     * Navbar links active state on scroll
     */
    let navbarlinks = select('#navbar .scrollto', true)
    const navbarlinksActive = () => {
        let position = window.scrollY + 200
        navbarlinks.forEach(navbarlink => {
            if (!navbarlink.hash) return
            let section = select(navbarlink.hash)
            if (!section) return
            if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
                navbarlink.classList.add('active')
            } else {
                navbarlink.classList.remove('active')
            }
        })
    }
    window.addEventListener('load', navbarlinksActive)
    onscroll(document, navbarlinksActive)

    /**
     * Scrolls to an element with header offset
     */
    const scrollto = (el) => {
        let header = select('#header')
        let offset = header.offsetHeight

        if (!header.classList.contains('header-scrolled')) {
            offset -= 16
        }

        let elementPos = select(el).offsetTop
        window.scrollTo({
            top: elementPos - offset,
            behavior: 'smooth'
        })
    }

    /**
     * Reservations button
     */
    let reservationsBtn = select('#reserve-btn')
    if (reservationsBtn) {
        const reservationsBtnShow = () => {
            if (window.scrollY > 400) {
                reservationsBtn.classList.add('active')
            } else {
                reservationsBtn.classList.remove('active')
            }
        }
        window.addEventListener('load', reservationsBtnShow)
        onscroll(document, reservationsBtnShow)
    }

    /**
     * Back to top button
     */
    let backtotop = select('.back-to-top')
    if (backtotop) {
        const toggleBacktotop = () => {
            if (window.scrollY > 100) {
                backtotop.classList.add('active')
            } else {
                backtotop.classList.remove('active')
            }
        }
        window.addEventListener('load', toggleBacktotop)
        onscroll(document, toggleBacktotop)
    }

    /**
     * FIXED Mobile nav toggle - Updated for new hamburger design
     */
    on('click', '.mobile-nav-toggle', function(e) {
        e.preventDefault();
        console.log('Mobile nav clicked'); // Debug

        const navbar = select('#navbar');

        // Toggle classes
        navbar.classList.toggle('navbar-mobile');
        this.classList.toggle('active');
        document.body.classList.toggle('mobile-nav-active');

        // Handle animation
        if (navbar.classList.contains('navbar-mobile')) {
            console.log('Opening mobile menu'); // Debug
            setTimeout(() => {
                navbar.classList.add('active');
            }, 50);
        } else {
            console.log('Closing mobile menu'); // Debug
            navbar.classList.remove('active');
        }

        console.log('Navbar classes:', navbar.className); // Debug
    });

    /**
     * Contact links toggle
     */
    on('click', '.contact-links-toggle', function(e) {
        select('#contact-links').classList.toggle('contact-links-visible')
    })

    on('click', '.contact-links-close', function(e) {
        select('#contact-links').classList.toggle('contact-links-visible')
    })

    /**
     * Mobile nav dropdowns activate
     */
    on('click', '.navbar .dropdown > a', function(e) {
        if (select('#navbar').classList.contains('navbar-mobile')) {
            e.preventDefault()
            this.nextElementSibling.classList.toggle('dropdown-active')
        }
    }, true)

    /**
     * Scroll with offset on links with a class name .scrollto
     */
    on('click', '.scrollto', function(e) {
        if (select(this.hash)) {
            e.preventDefault()

            let navbar = select('#navbar')
            if (navbar.classList.contains('navbar-mobile')) {
                // Close mobile menu when clicking scroll links
                navbar.classList.remove('navbar-mobile', 'active')
                let navbarToggle = select('.mobile-nav-toggle')
                navbarToggle.classList.remove('active')
                document.body.classList.remove('mobile-nav-active')
            }
            scrollto(this.hash)
        }
    }, true)

    /**
     * Reservation form toggles
     */
    on('click', '#cta-landing', function (e) {
        let reservationForm = select('#reservation-form');
        reservationForm.classList.toggle('active')
    })

    on('click', '#cta-reserve', function(e) {
        let reservationForm = select('#reservation-form');
        reservationForm.classList.toggle('active')
        select('#contact-links').classList.toggle('contact-links-visible')
    })

    on('click', '#cta-body', function(e) {
        let reservationForm = select('#reservation-form');
        reservationForm.classList.toggle('active');
    })

    /**
     * Close reservation form
     */
    on('click', '#reservation-form .close', function (e) {
        let reservationForm = select('#reservation-form');
        reservationForm.classList.toggle('active')
    })

    /**
     * Close mobile menu when clicking navigation links
     */
    document.addEventListener('DOMContentLoaded', function() {
        const navLinks = document.querySelectorAll('#navbar a');

        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                const navbar = select('#navbar');
                const toggle = select('.mobile-nav-toggle');

                // Only close if we're in mobile mode
                if (navbar && navbar.classList.contains('navbar-mobile')) {
                    navbar.classList.remove('navbar-mobile', 'active');
                    if (toggle) {
                        toggle.classList.remove('active');
                    }
                    document.body.classList.remove('mobile-nav-active');
                }
            });
        });

        // Close menu when window is resized to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth > 991) {
                const navbar = select('#navbar');
                const toggle = select('.mobile-nav-toggle');

                if (navbar && navbar.classList.contains('navbar-mobile')) {
                    navbar.classList.remove('navbar-mobile', 'active');
                    if (toggle) {
                        toggle.classList.remove('active');
                    }
                    document.body.classList.remove('mobile-nav-active');
                }
            }
        });
    });

    /**
     * Scroll with offset on page load with hash links in the url
     */
    window.addEventListener('load', () => {
        if (window.location.hash) {
            if (select(window.location.hash)) {
                scrollto(window.location.hash)
            }
        }
    });

    /**
     * Testimonials slider
     */
    new Swiper('.testimonials-slider', {
        speed: 600,
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false
        },
        slidesPerView: 'auto',
        pagination: {
            el: '.swiper-pagination',
            type: 'bullets',
            clickable: true
        },
        breakpoints: {
            320: {
                slidesPerView: 1,
                spaceBetween: 20
            },
            1200: {
                slidesPerView: 3,
                spaceBetween: 20
            }
        }
    });

    /**
     * Portfolio isotope and filter
     */
    window.addEventListener('load', () => {
        let portfolioContainer = select('.portfolio-container');
        if (portfolioContainer) {
            let portfolioIsotope = new Isotope(portfolioContainer, {
                itemSelector: '.portfolio-item',
            });

            let portfolioFilters = select('#portfolio-flters li', true);

            on('click', '#portfolio-flters li', function(e) {
                e.preventDefault();
                portfolioFilters.forEach(function(el) {
                    el.classList.remove('filter-active');
                });
                this.classList.add('filter-active');

                portfolioIsotope.arrange({
                    filter: this.getAttribute('data-filter')
                });
            }, true);
        }
    });

    /**
     * Initiate portfolio lightbox
     */
    const portfolioLightbox = GLightbox({
        selector: '.portfolio-lightbox'
    });

    /**
     * Portfolio details slider
     */
    new Swiper('.portfolio-details-slider', {
        speed: 400,
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false
        },
        pagination: {
            el: '.swiper-pagination',
            type: 'bullets',
            clickable: true
        }
    });

    /**
     * Preloader
     */
    let preloader = select('#preloader');
    if (preloader) {
        window.addEventListener('load', () => {
            preloader.remove()
        });
    }

    /**
     * Initiate Pure Counter
     */
    new PureCounter();

})()
