/**
 * Jan Kadlec Theme — Main JS
 * Vanilla JS only. No framework dependency.
 */

( function () {
    'use strict';

    /* ============================================================
       STICKY HEADER
       ============================================================ */
    const header = document.getElementById( 'site-header' );

    if ( header ) {
        const onScroll = () => {
            header.classList.toggle( 'scrolled', window.scrollY > 40 );
        };
        window.addEventListener( 'scroll', onScroll, { passive: true } );
        onScroll();
    }

    /* ============================================================
       MOBILE NAV TOGGLE
       ============================================================ */
    const navToggle = document.getElementById( 'nav-toggle' );
    const primaryNav = document.getElementById( 'primary-nav' );

    if ( navToggle && primaryNav ) {
        navToggle.addEventListener( 'click', () => {
            const isOpen = navToggle.getAttribute( 'aria-expanded' ) === 'true';
            navToggle.setAttribute( 'aria-expanded', String( ! isOpen ) );
            primaryNav.classList.toggle( 'is-open', ! isOpen );
        } );

        primaryNav.querySelectorAll( 'a' ).forEach( link => {
            link.addEventListener( 'click', () => {
                navToggle.setAttribute( 'aria-expanded', 'false' );
                primaryNav.classList.remove( 'is-open' );
            } );
        } );

        document.addEventListener( 'click', ( e ) => {
            if ( ! header.contains( e.target ) ) {
                navToggle.setAttribute( 'aria-expanded', 'false' );
                primaryNav.classList.remove( 'is-open' );
            }
        } );
    }

    /* ============================================================
       ACTIVE NAV LINK — highlight based on scroll position
       ============================================================ */
    const sections = document.querySelectorAll( 'section[id]' );
    const navLinks = document.querySelectorAll( '.primary-nav a[href*="#"]' );

    if ( sections.length && navLinks.length ) {
        const highlightNav = () => {
            let current = '';
            sections.forEach( section => {
                if ( window.scrollY >= section.offsetTop - 120 ) {
                    current = section.getAttribute( 'id' );
                }
            } );
            navLinks.forEach( link => {
                link.classList.toggle( 'active', link.getAttribute( 'href' ).includes( current ) );
            } );
        };
        window.addEventListener( 'scroll', highlightNav, { passive: true } );
        highlightNav();
    }

    /* ============================================================
       SMOOTH SCROLL
       ============================================================ */
    document.querySelectorAll( 'a[href^="#"]' ).forEach( anchor => {
        anchor.addEventListener( 'click', function ( e ) {
            const target = document.querySelector( this.getAttribute( 'href' ) );
            if ( ! target ) return;
            e.preventDefault();
            const headerOffset = header ? header.offsetHeight : 72;
            const top = target.getBoundingClientRect().top + window.scrollY - headerOffset - 16;
            window.scrollTo( { top, behavior: 'smooth' } );
        } );
    } );

    /* ============================================================
       CLIENTS LIST TOGGLE
       ============================================================ */
    const clientsToggle = document.getElementById( 'clientsToggle' );
    const clientsList   = document.getElementById( 'clientsList' );

    if ( clientsToggle && clientsList ) {
        clientsToggle.addEventListener( 'click', () => {
            const isOpen = clientsToggle.getAttribute( 'aria-expanded' ) === 'true';
            clientsToggle.setAttribute( 'aria-expanded', String( ! isOpen ) );
            clientsList.setAttribute( 'aria-hidden', String( isOpen ) );
            clientsList.classList.toggle( 'is-open', ! isOpen );
            clientsToggle.querySelector( '.clients-list-toggle__text' ).textContent =
                isOpen ? 'Zobrazit všechny klienty' : 'Skrýt klienty';
        } );
    }

    /* ============================================================
       INTERSECTION OBSERVER — fade-in on scroll
       ============================================================ */
    if ( 'IntersectionObserver' in window ) {
        const observer = new IntersectionObserver(
            ( entries ) => {
                entries.forEach( entry => {
                    if ( entry.isIntersecting ) {
                        entry.target.classList.add( 'is-visible' );
                        observer.unobserve( entry.target );
                    }
                } );
            },
            { rootMargin: '0px 0px -60px 0px', threshold: 0.1 }
        );

        document.querySelectorAll(
            '.service-card, .reference-card, .hero-content, .about-content, .hero-trust'
        ).forEach( el => {
            el.classList.add( 'fade-in' );
            observer.observe( el );
        } );
    }

} )();
