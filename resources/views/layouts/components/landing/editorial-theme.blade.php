{{--
    Editorial theme: the site's permanent black & white "luxury magazine" look (serif headings, square
    corners, hairline black borders). It is switched on by data-look="editorial" on <html> in
    landing-master, layered over the base styles in the layout and page files.
--}}
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&display=swap">

<style>
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

    /* Catalogue, accessories and product-page components */
    html[data-look="editorial"] :is(.accessory-card, .pairing-section, .pairing-card, .detail-option, .category-tab, .accessory-pill, .filter-chip, .refine-select, .sort-select, .catalogue-search, .payment-switch) { border: 1px solid #0a0a0a !important; box-shadow: none !important; }
    html[data-look="editorial"] :is(.accessory-card, .pairing-card):hover { transform: translate(-4px, -4px) !important; box-shadow: 6px 6px 0 #0a0a0a !important; }
    html[data-look="editorial"] :is(.category-tab, .accessory-pill, .filter-chip, .detail-option):hover { color: #0a0a0a; background: #f2f2f2; }
    html[data-look="editorial"] :is(.category-tab, .filter-chip, .detail-option).active { color: #fff; background: #0a0a0a; }
    html[data-look="editorial"] :is(.category-tab span, .accessory-pill, .filter-chip, .payment-option, .media-badge, .option-pill, .active-filter) { letter-spacing: .06em; }
    html[data-look="editorial"] :is(.media-badge, .option-pill) { border: 1px solid #0a0a0a; box-shadow: none; }
    html[data-look="editorial"] .accessory-banner { background: #0a0a0a; }
    html[data-look="editorial"] .accessory-banner a { font-size: .74rem; letter-spacing: .12em; text-transform: uppercase; }
    html[data-look="editorial"] .landing-body :is(.accessory-card__name, .product-name, .pairing-head h2) { font-family: 'Instrument Serif', serif !important; font-weight: 400 !important; letter-spacing: 0 !important; }
    html[data-look="editorial"] .landing-body :is(.accessory-card__name, .product-name) { font-size: 1.2rem; line-height: 1.15; }
    html[data-look="editorial"] .landing-body .pairing-head h2 { font-size: 2rem; }
    html[data-look="editorial"] :is(.product-whatsapp, .detail-back) { border: 1px solid #0a0a0a; }
    html[data-look="editorial"] :is(.search-button, .detail-whatsapp) { font-size: .74rem; letter-spacing: .14em; text-transform: uppercase; }

    /* Uppercase, letter-spaced nav labels need tighter spacing to stay on one row on small laptops. */
    @media (min-width: 992px) and (max-width: 1279.98px) {
        html[data-look="editorial"] #sidebar .side-menu__label { font-size: .64rem; letter-spacing: .08em; }
        html[data-look="editorial"] .landing-body .app-sidebar .side-menu__item { padding: .6rem .5rem !important; }
        html[data-look="editorial"] .landing-body .app-sidebar .side-menu__item.active::after,
        html[data-look="editorial"] .landing-body .app-sidebar .side-menu__item:hover::after { right: .5rem; left: .5rem; }
        html[data-look="editorial"] .landing-nav-cta { padding: .6rem .8rem; font-size: .64rem; letter-spacing: .1em; }
    }
</style>
