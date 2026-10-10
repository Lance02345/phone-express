{{--
    Look switcher: previews alternative black & white looks on the live pages.
    Hidden from customers. Visit any page with ?looks to reveal it (remembered in this browser),
    or ?look=gallery|editorial|chrome|split to open a specific look. "Hide" turns it off again.
    The default look ("spotlight") is the styling in the layout and page files; everything here only
    applies while html[data-look] is set.
--}}
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&display=swap">

<script>
    (function () {
        var looks = ['spotlight', 'gallery', 'editorial', 'chrome', 'split'];
        try {
            var query = new URLSearchParams(window.location.search);
            if (query.has('looks')) localStorage.setItem('ddk-looks', '1');
            if (looks.indexOf(query.get('look')) > -1) {
                localStorage.setItem('ddk-looks', '1');
                localStorage.setItem('ddk-look', query.get('look'));
            }
            if (localStorage.getItem('ddk-looks') !== '1') return;
            var look = localStorage.getItem('ddk-look');
            if (looks.indexOf(look) > 0) document.documentElement.setAttribute('data-look', look);
        } catch (e) {}
    })();
</script>

<style>
    /* ================= Switcher widget ================= */
    .look-switcher { position: fixed; z-index: 1000; left: 16px; bottom: 16px; display: flex; align-items: center; gap: .25rem; max-width: calc(100vw - 32px); padding: .35rem; overflow-x: auto; color: #fff; background: rgba(10,10,10,.92); border: 1px solid rgba(255,255,255,.16); border-radius: 14px; box-shadow: 0 18px 40px rgba(0,0,0,.35); backdrop-filter: blur(14px); font: 600 .74rem/1 'DM Sans', sans-serif; }
    .look-switcher__label { padding: 0 .5rem; color: rgba(255,255,255,.55); letter-spacing: .12em; text-transform: uppercase; font-size: .62rem; white-space: nowrap; }
    .look-switcher button { padding: .55rem .7rem; color: rgba(255,255,255,.8); white-space: nowrap; background: transparent; border: 0; border-radius: 9px; cursor: pointer; }
    .look-switcher button:hover { color: #fff; background: rgba(255,255,255,.1); }
    .look-switcher button.active { color: #0a0a0a; background: #fff; }
    .look-switcher .look-switcher__hide { color: rgba(255,255,255,.5); }

    /* ================= 1. Gallery: white-first, Apple-store bright ================= */
    html[data-look="gallery"] body.landing-body { background: #fff; }
    html[data-look="gallery"] .section-bg { background: #f5f5f7 !important; }
    html[data-look="gallery"] .app-sidebar,
    html[data-look="gallery"] .app-header { background: rgba(255,255,255,.88) !important; border-bottom: 1px solid #e8e8e8 !important; box-shadow: none; }
    html[data-look="gallery"] .header-link,
    html[data-look="gallery"] .header-link-icon { color: #0a0a0a !important; }
    html[data-look="gallery"] .landing-body .app-sidebar .side-menu__label { color: #3a3a3a !important; }
    html[data-look="gallery"] #sidebar .side-menu__item.active .side-menu__label,
    html[data-look="gallery"] #sidebar .side-menu__item:hover .side-menu__label { color: #000 !important; opacity: 1; }
    html[data-look="gallery"] .landing-body .app-sidebar .side-menu__item.active,
    html[data-look="gallery"] .landing-body .app-sidebar .side-menu__item:hover { background: rgba(0,0,0,.05) !important; }
    html[data-look="gallery"] .landing-body .app-sidebar .side-menu__item.active::after { background: #000; }
    html[data-look="gallery"] .landing-nav-cta { color: #fff; background: #0a0a0a; box-shadow: 0 10px 24px rgba(0,0,0,.15); }
    html[data-look="gallery"] .landing-nav-cta:hover { color: #fff; background: #262626; }

    html[data-look="gallery"] .landing-banner,
    html[data-look="gallery"] .catalogue-hero { background: radial-gradient(ellipse 45% 60% at 74% 48%, #e8e8ec, transparent 70%), #fff !important; }
    html[data-look="gallery"] .landing-banner::before,
    html[data-look="gallery"] .catalogue-hero::before { background-image: linear-gradient(rgba(0,0,0,.045) 1px, transparent 1px), linear-gradient(90deg, rgba(0,0,0,.045) 1px, transparent 1px); }
    html[data-look="gallery"] .hero-kicker { color: #1d1d1f; background: #f5f5f7; border-color: #e5e5e5; }
    html[data-look="gallery"] .hero-kicker::before,
    html[data-look="gallery"] .catalogue-eyebrow::before { background: #000; }
    html[data-look="gallery"] .landing-body .landing-banner .landing-banner-heading,
    html[data-look="gallery"] .hero-highlight,
    html[data-look="gallery"] .catalogue-title,
    html[data-look="gallery"] .catalogue-title span { color: #0a0a0a; }
    html[data-look="gallery"] .hero-copy,
    html[data-look="gallery"] .hero-trust,
    html[data-look="gallery"] .catalogue-subtitle { color: #555; }
    html[data-look="gallery"] .catalogue-eyebrow { color: #6b6b6b; }
    html[data-look="gallery"] .hero-trust i { color: #000; }
    html[data-look="gallery"] .hero-actions .btn-primary { color: #fff !important; background: #0a0a0a !important; border-color: #0a0a0a !important; box-shadow: 0 12px 30px rgba(0,0,0,.18); }
    html[data-look="gallery"] .hero-actions .btn-primary:hover { background: #262626 !important; }
    html[data-look="gallery"] .hero-actions .btn-outline-light { color: #0a0a0a !important; background: #fff; border-color: #d4d4d4 !important; }
    html[data-look="gallery"] .hero-actions .btn-outline-light:hover { background: #f2f2f2 !important; border-color: #a3a3a3 !important; }
    html[data-look="gallery"] .hero-photo-frame { background: #f5f5f7; border-color: #e5e5e5; box-shadow: 0 30px 80px rgba(0,0,0,.14); }
    html[data-look="gallery"] .hero-photo-frame::after { display: none; }
    html[data-look="gallery"] .hero-rating,
    html[data-look="gallery"] .hero-price-card { border: 1px solid #e8e8e8; box-shadow: 0 18px 40px rgba(0,0,0,.1); }
    html[data-look="gallery"] .trust-hero { color: #0a0a0a; background: #f5f5f7; border: 1px solid #e8e8e8; box-shadow: none; }
    html[data-look="gallery"] .trust-title { color: #0a0a0a !important; }
    html[data-look="gallery"] .trust-copy { color: #555; }
    html[data-look="gallery"] .trust-eyebrow { color: #6b6b6b; }
    html[data-look="gallery"] .trust-hero::after { border-color: rgba(0,0,0,.08); box-shadow: 0 0 0 55px rgba(0,0,0,.02), 0 0 0 110px rgba(0,0,0,.015); }

    /* ================= 2. Editorial: luxury magazine ================= */
    html[data-look="editorial"] body.landing-body { background: #fff; }
    html[data-look="editorial"] .landing-body * { border-radius: 0 !important; }
    html[data-look="editorial"] .landing-body :is(h1, h2, h3, .landing-banner-heading, .catalogue-title, .trust-title, .detail-title, .related-heading) { font-family: 'Instrument Serif', serif !important; font-weight: 400 !important; letter-spacing: -.02em !important; }
    html[data-look="editorial"] .landing-body .section :is(h2, h3) { font-size: clamp(2.4rem, 4.5vw, 3.8rem); line-height: 1.02; }
    html[data-look="editorial"] .section-bg { background: #fff !important; }
    html[data-look="editorial"] .landing-main > section.section:not(.landing-footer) { border-top: 1px solid #0a0a0a; }
    html[data-look="editorial"] .landing-section-heading { color: #0a0a0a !important; letter-spacing: .3em; }
    html[data-look="editorial"] .landing-section-heading::before { display: none; }

    html[data-look="editorial"] .app-sidebar,
    html[data-look="editorial"] .app-header { background: #fff !important; border-bottom: 1px solid #0a0a0a !important; box-shadow: none; backdrop-filter: none; }
    html[data-look="editorial"] .header-link,
    html[data-look="editorial"] .header-link-icon { color: #0a0a0a !important; }
    html[data-look="editorial"] #sidebar .side-menu__label { color: #0a0a0a !important; opacity: 1; font-size: .72rem; letter-spacing: .14em; text-transform: uppercase; }
    html[data-look="editorial"] .landing-body .app-sidebar .side-menu__item.active,
    html[data-look="editorial"] .landing-body .app-sidebar .side-menu__item:hover { background: transparent !important; transform: none; }
    html[data-look="editorial"] .landing-body .app-sidebar .side-menu__item.active::after,
    html[data-look="editorial"] .landing-body .app-sidebar .side-menu__item:hover::after { content: ''; position: absolute; right: .85rem; bottom: .3rem; left: .85rem; height: 1px; background: #0a0a0a; }
    html[data-look="editorial"] .landing-nav-cta { color: #fff; background: #0a0a0a; box-shadow: none; font-size: .7rem; letter-spacing: .14em; text-transform: uppercase; }
    html[data-look="editorial"] .landing-nav-cta:hover { color: #0a0a0a; background: #fff; outline: 1px solid #0a0a0a; }

    html[data-look="editorial"] .landing-banner,
    html[data-look="editorial"] .catalogue-hero { background: #fff !important; border-bottom: 1px solid #0a0a0a; }
    html[data-look="editorial"] .landing-banner::before,
    html[data-look="editorial"] .catalogue-hero::before { display: none; }
    html[data-look="editorial"] .hero-kicker,
    html[data-look="editorial"] .catalogue-eyebrow { padding: 0; color: #0a0a0a; background: none; border: 0; font-size: .7rem; letter-spacing: .3em; }
    html[data-look="editorial"] .hero-kicker::before,
    html[data-look="editorial"] .catalogue-eyebrow::before { width: 48px; height: 1px; background: #0a0a0a; }
    html[data-look="editorial"] .landing-body .landing-banner .landing-banner-heading { color: #0a0a0a; font-size: clamp(3.6rem, 7.5vw, 7rem); line-height: .95; }
    html[data-look="editorial"] .hero-highlight,
    html[data-look="editorial"] .catalogue-title,
    html[data-look="editorial"] .catalogue-title span { color: #0a0a0a; }
    html[data-look="editorial"] .hero-copy,
    html[data-look="editorial"] .hero-trust,
    html[data-look="editorial"] .catalogue-subtitle { color: #444; }
    html[data-look="editorial"] .hero-trust i { color: #0a0a0a; }
    html[data-look="editorial"] .hero-actions .btn { font-size: .74rem; letter-spacing: .14em; text-transform: uppercase; }
    html[data-look="editorial"] .hero-actions .btn-primary { color: #fff !important; background: #0a0a0a !important; border: 1px solid #0a0a0a !important; box-shadow: none; }
    html[data-look="editorial"] .hero-actions .btn-outline-light { color: #0a0a0a !important; background: transparent; border: 1px solid #0a0a0a !important; }
    html[data-look="editorial"] .hero-actions .btn-outline-light:hover { color: #fff !important; background: #0a0a0a !important; }
    html[data-look="editorial"] .hero-photo-frame { padding: 12px; background: #fff; border: 1px solid #0a0a0a; box-shadow: none; }
    html[data-look="editorial"] .hero-photo-frame::after { display: none; }
    html[data-look="editorial"] .hero-rating,
    html[data-look="editorial"] .hero-price-card { border: 1px solid #0a0a0a; box-shadow: none; }

    html[data-look="editorial"] :is(.category-tile, .phone-card, .stat-card, .testimonial-card, .contact-card, .landing-missions, .accordion-item, .category-filter, .alert-info, .catalogue-card, .filter-panel, .catalogue-toolbar, .empty-results, .product-detail, .related-card, .policy-panel, .policy-nav__item) { border: 1px solid #0a0a0a !important; box-shadow: none !important; }
    html[data-look="editorial"] :is(.category-tile, .phone-card, .catalogue-card, .related-card):hover { transform: translate(-4px, -4px) !important; box-shadow: 6px 6px 0 #0a0a0a !important; }
    html[data-look="editorial"] .category-tile--light { background: #fff; }
    html[data-look="editorial"] :is(.phone-card__action, .product-action) { color: #0a0a0a; background: #fff; border: 1px solid #0a0a0a; font-size: .7rem; letter-spacing: .12em; text-transform: uppercase; }
    html[data-look="editorial"] :is(.phone-card__action, .product-action):hover { color: #fff; background: #0a0a0a; }
    html[data-look="editorial"] .trust-hero { color: #0a0a0a; background: #fff; border: 1px solid #0a0a0a; box-shadow: none; }
    html[data-look="editorial"] .trust-title { color: #0a0a0a !important; }
    html[data-look="editorial"] .trust-copy { color: #444; }
    html[data-look="editorial"] .trust-eyebrow { color: #0a0a0a; }
    html[data-look="editorial"] .trust-hero::after { display: none; }

    /* ================= 3. Chrome & glass: dark, metallic, tech ================= */
    html[data-look="chrome"] body.landing-body {
        --ink: #f5f5f5; --muted: #a3a3a3; --border: rgba(255,255,255,.12); --surface: #111;
        --custom-white: #111; --custom-black: #fff; --default-text-color: rgba(255,255,255,.78);
        --default-border: rgba(255,255,255,.1); --bootstrap-card-border: rgba(255,255,255,.1);
        --text-muted: rgba(255,255,255,.55); --input-border: rgba(255,255,255,.14); --form-control-bg: #0f0f0f;
        --bs-body-color: rgba(255,255,255,.78); --bs-heading-color: #f5f5f5; --bs-border-color: rgba(255,255,255,.12);
        color: rgba(255,255,255,.78);
        background: #070707;
    }
    html[data-look="chrome"] .section-bg,
    html[data-look="chrome"] #testimonials { background: #0b0b0b !important; }
    html[data-look="chrome"] .landing-body .section :is(h4, h5, h6) { color: #f5f5f5; }
    html[data-look="chrome"] .landing-section-heading::before { background-image: linear-gradient(to right, #fff, rgba(255,255,255,.1)) !important; }
    html[data-look="chrome"] .app-sidebar { border-bottom: 1px solid transparent !important; border-image: linear-gradient(90deg, transparent, rgba(255,255,255,.45), transparent) 1 !important; }
    html[data-look="chrome"] .hero-highlight,
    html[data-look="chrome"] .catalogue-title span { background: linear-gradient(180deg, #ffffff 15%, #8a8a8a 55%, #e9e9e9 85%); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; }
    html[data-look="chrome"] .hero-kicker { border-color: rgba(255,255,255,.3); background: linear-gradient(180deg, rgba(255,255,255,.14), rgba(255,255,255,.03)); }
    html[data-look="chrome"] .hero-photo-frame { border: 1px solid transparent; background: linear-gradient(#111, #111) padding-box, linear-gradient(135deg, rgba(255,255,255,.8), rgba(255,255,255,.08) 40%, rgba(255,255,255,.08) 60%, rgba(255,255,255,.5)) border-box; }
    html[data-look="chrome"] .hero-rating,
    html[data-look="chrome"] .hero-price-card { color: #fff; background: rgba(24,24,24,.55); border: 1px solid rgba(255,255,255,.22); backdrop-filter: blur(16px) saturate(140%); -webkit-backdrop-filter: blur(16px) saturate(140%); }
    html[data-look="chrome"] .hero-price-card .text-success { color: #bdbdbd !important; }

    html[data-look="chrome"] :is(.category-tile, .phone-card, .stat-card, .testimonial-card, .contact-card, .landing-missions, .accordion-item, .category-filter) {
        color: rgba(255,255,255,.8);
        background: linear-gradient(160deg, #191919, #0c0c0c) padding-box, linear-gradient(135deg, rgba(255,255,255,.5), rgba(255,255,255,.06) 35%, rgba(255,255,255,.06) 65%, rgba(255,255,255,.3)) border-box !important;
        border: 1px solid transparent !important;
        box-shadow: 0 20px 50px rgba(0,0,0,.45) !important;
    }
    html[data-look="chrome"] :is(.category-tile, .phone-card, .stat-card, .testimonial-card, .contact-card):hover { box-shadow: 0 0 0 1px rgba(255,255,255,.22), 0 24px 70px rgba(255,255,255,.08) !important; }
    html[data-look="chrome"] .category-tile,
    html[data-look="chrome"] .category-tile:hover { color: #fff; }
    html[data-look="chrome"] .category-tile__count { color: #fff; background: rgba(255,255,255,.1); }
    html[data-look="chrome"] .phone-card img { background: #f2f2f2; }
    html[data-look="chrome"] .phone-card__action { color: #fff; background: rgba(255,255,255,.07); border: 1px solid rgba(255,255,255,.12); }
    html[data-look="chrome"] :is(.btn-primary, .hero-actions .btn-primary, .landing-nav-cta, .btn-dark, .floating-whatsapp, .phone-card__action:hover, .category-btn.active, .nav-tabs .nav-link.active, .search-button, .filter-chip.active, .page-item.active .page-link) {
        color: #0a0a0a !important;
        background: linear-gradient(180deg, #ffffff 0%, #e6e6e6 45%, #b8b8b8 100%) !important;
        border-color: #d4d4d4 !important;
        box-shadow: inset 0 1px 0 #fff, 0 10px 30px rgba(255,255,255,.12) !important;
    }
    html[data-look="chrome"] .floating-whatsapp { border: 0; }
    html[data-look="chrome"] .category-btn { color: rgba(255,255,255,.7) !important; }
    html[data-look="chrome"] .nav-tabs .nav-link { color: rgba(255,255,255,.75) !important; }
    html[data-look="chrome"] .bg-primary-transparent { color: #fff !important; background: rgba(255,255,255,.07) !important; }
    html[data-look="chrome"] .landing-body :is(.text-primary, .text-dark) { color: #f5f5f5 !important; }
    html[data-look="chrome"] .landing-main .text-success { color: var(--muted) !important; }
    html[data-look="chrome"] .badge.bg-dark,
    html[data-look="chrome"] .lipa-polepole-badge { color: #0a0a0a !important; background: #fff !important; }
    html[data-look="chrome"] .alert-info { color: rgba(255,255,255,.8); background: rgba(255,255,255,.05); border-color: rgba(255,255,255,.12); }
    html[data-look="chrome"] .alert-info a { color: #fff; }
    html[data-look="chrome"] .accordion { --bs-accordion-bg: transparent; --bs-accordion-color: rgba(255,255,255,.75); }
    html[data-look="chrome"] .accordion-button { color: #fff !important; background: transparent !important; }
    html[data-look="chrome"] .accordion-button:not(.collapsed) { background: rgba(255,255,255,.06) !important; }
    html[data-look="chrome"] .accordion-button::after { filter: invert(1); }
    html[data-look="chrome"] .landing-main .form-control { color: #fff; background: #0f0f0f; border-color: rgba(255,255,255,.14); }
    html[data-look="chrome"] .landing-main .form-control::placeholder { color: rgba(255,255,255,.4); }

    /* ================= 4. Split: alternating black and white sections ================= */
    html[data-look="split"] :is(#categories, #statistics, #our-mission, #faq, #contact) { background: #fff !important; }
    html[data-look="split"] :is(#pricing, #about, #testimonials) {
        --ink: #fff; --muted: rgba(255,255,255,.6); --border: rgba(255,255,255,.12);
        --custom-white: #111; --default-text-color: rgba(255,255,255,.78); --default-border: rgba(255,255,255,.1);
        --bootstrap-card-border: rgba(255,255,255,.1); --text-muted: rgba(255,255,255,.55);
        --bs-body-color: rgba(255,255,255,.78); --bs-heading-color: #fff;
        color: rgba(255,255,255,.78);
        background: radial-gradient(ellipse 60% 45% at 50% 0%, rgba(255,255,255,.1), transparent 70%), #000 !important;
    }
    html[data-look="split"] :is(#pricing, #about, #testimonials) :is(h1, h2, h3, h4, h5, h6) { color: #fff; }
    html[data-look="split"] :is(#pricing, #about, #testimonials) .landing-section-heading::before { background-image: linear-gradient(to right, #fff, rgba(255,255,255,.1)) !important; }
    html[data-look="split"] :is(#pricing, #about, #testimonials) :is(.text-success, .text-primary, .text-dark) { color: #fff !important; }
    html[data-look="split"] :is(#pricing, #about, #testimonials) .landing-section-heading { color: rgba(255,255,255,.6) !important; }
    html[data-look="split"] #pricing .phone-card { background: #0f0f0f; border-color: rgba(255,255,255,.1) !important; box-shadow: none; }
    html[data-look="split"] #pricing .phone-card:hover { border-color: rgba(255,255,255,.35) !important; box-shadow: 0 24px 60px rgba(255,255,255,.07); }
    html[data-look="split"] #pricing .phone-card__action { color: #fff; background: rgba(255,255,255,.08); }
    html[data-look="split"] #pricing .phone-card__action:hover { color: #0a0a0a; background: #fff; }
    html[data-look="split"] #pricing .lipa-polepole-badge { color: #0a0a0a; background: #fff; }
    html[data-look="split"] :is(#pricing, #about) .btn-primary { color: #0a0a0a !important; background: #fff !important; box-shadow: 0 10px 30px rgba(255,255,255,.12) !important; }
    html[data-look="split"] :is(#pricing, #about) .btn-primary:hover { background: #e5e5e5 !important; }
    html[data-look="split"] #pricing .bg-primary-transparent { background: rgba(255,255,255,.08) !important; }
    html[data-look="split"] #pricing .nav-tabs .nav-link { color: rgba(255,255,255,.75) !important; }
    html[data-look="split"] #pricing .nav-tabs .nav-link.active { color: #0a0a0a !important; background: #fff !important; box-shadow: none; }
    html[data-look="split"] #pricing .nav-link:not(.active) .badge.bg-dark { color: #0a0a0a; background: #fff !important; }
    html[data-look="split"] #pricing .alert-info { color: rgba(255,255,255,.8); background: rgba(255,255,255,.06); border-color: rgba(255,255,255,.12); }
    html[data-look="split"] #pricing .alert-info a { color: #fff; }
    html[data-look="split"] #testimonials .testimonial-card { background: #0f0f0f; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        try { if (localStorage.getItem('ddk-looks') !== '1') return; } catch (e) { return; }

        var looks = [['spotlight', 'Spotlight'], ['gallery', 'Gallery'], ['editorial', 'Editorial'], ['chrome', 'Chrome'], ['split', 'Split']];
        var root = document.documentElement;
        var bar = document.createElement('div');
        bar.className = 'look-switcher';
        bar.setAttribute('role', 'toolbar');
        bar.setAttribute('aria-label', 'Preview site look');
        bar.innerHTML = '<span class="look-switcher__label">Look</span>';

        looks.forEach(function (look) {
            var button = document.createElement('button');
            button.type = 'button';
            button.textContent = look[1];
            button.dataset.look = look[0];
            button.addEventListener('click', function () {
                if (look[0] === 'spotlight') root.removeAttribute('data-look');
                else root.setAttribute('data-look', look[0]);
                try { localStorage.setItem('ddk-look', look[0]); } catch (e) {}
                sync();
            });
            bar.appendChild(button);
        });

        var hide = document.createElement('button');
        hide.type = 'button';
        hide.className = 'look-switcher__hide';
        hide.textContent = 'Hide ×';
        hide.addEventListener('click', function () {
            try { localStorage.removeItem('ddk-looks'); localStorage.removeItem('ddk-look'); } catch (e) {}
            root.removeAttribute('data-look');
            bar.remove();
        });
        bar.appendChild(hide);

        function sync() {
            var current = root.getAttribute('data-look') || 'spotlight';
            bar.querySelectorAll('[data-look]').forEach(function (button) {
                button.classList.toggle('active', button.dataset.look === current);
            });
        }

        sync();
        document.body.appendChild(bar);
    });
</script>
