<?php
/**
 * Hlavní šablona — úvodní strana / záložní šablona
 *
 * @package jan-kadlec-theme
 */
get_header();
?>

<?php if ( is_front_page() ) : ?>

<!-- ============================================================
     HERO SEKCE
     ============================================================ -->
<section class="hero" id="hero" aria-labelledby="hero-heading">
    <div class="container">
        <div class="hero-inner">

            <!-- Obsah -->
            <div class="hero-content">
                <span class="hero-eyebrow"><?php esc_html_e( 'AI Strategie &amp; Business Automatizace', 'jan-kadlec-theme' ); ?></span>

                <h1 class="hero-title" id="hero-heading">
                    Jan Kadlec
                    <br>
                    <span class="highlight"><?php esc_html_e( 'AI Strategie', 'jan-kadlec-theme' ); ?></span>
                    &amp;&nbsp;<?php esc_html_e( 'Automatizace', 'jan-kadlec-theme' ); ?>
                </h1>

                <p class="hero-desc">
                    <?php esc_html_e( 'Pomáhám středním a velkým podnikům transformovat chaos v procesech v měřitelný výkon. Navrhuji a stavím AI automatizace, které vaší firmě vrátí stovky hodin měsíčně.', 'jan-kadlec-theme' ); ?>
                </p>

                <div class="hero-actions">
                    <a class="btn btn-primary" href="#contact">
                        <?php esc_html_e( 'Konzultovat potenciál AI', 'jan-kadlec-theme' ); ?>
                    </a>
                    <a class="btn btn-secondary" href="#services">
                        <?php esc_html_e( 'Moje expertíza', 'jan-kadlec-theme' ); ?>
                    </a>
                </div>

                <!-- Důvěryhodnostní metriky -->
                <div class="hero-trust" role="list" aria-label="<?php esc_attr_e( 'Klíčové výsledky', 'jan-kadlec-theme' ); ?>">
                    <div class="trust-item" role="listitem">
                        <span class="trust-number">50+</span>
                        <span class="trust-label"><?php esc_html_e( 'automatizovaných procesů', 'jan-kadlec-theme' ); ?></span>
                    </div>
                    <div class="trust-divider" aria-hidden="true"></div>
                    <div class="trust-item" role="listitem">
                        <span class="trust-number">8+</span>
                        <span class="trust-label"><?php esc_html_e( 'let v byznysu', 'jan-kadlec-theme' ); ?></span>
                    </div>
                    <div class="trust-divider" aria-hidden="true"></div>
                    <div class="trust-item" role="listitem">
                        <span class="trust-number">100s</span>
                        <span class="trust-label"><?php esc_html_e( 'hodin vrácených firmám', 'jan-kadlec-theme' ); ?></span>
                    </div>
                </div>
            </div><!-- /.hero-content -->

            <!-- Vizuál — silueta -->
            <div class="hero-visual" aria-hidden="true">
                <div class="hero-img-wrap">
                    <?php
                    $hero_img_id = get_theme_mod( 'jk_hero_image' );
                    if ( $hero_img_id ) {
                        echo wp_get_attachment_image( $hero_img_id, 'jk-hero', false, [
                            'alt'     => esc_attr__( 'Jan Kadlec — AI Strategie & Business Automatizace', 'jan-kadlec-theme' ),
                            'loading' => 'eager',
                            'class'   => 'hero-photo',
                        ] );
                    } else {
                        ?>
                        <img
                            src="<?php echo esc_url( JK_THEME_URI . '/assets/images/JK-silueta.png' ); ?>"
                            alt="<?php esc_attr_e( 'Jan Kadlec — AI Strategie & Business Automatizace', 'jan-kadlec-theme' ); ?>"
                            class="hero-photo hero-silhouette"
                            width="520"
                            loading="eager"
                            decoding="async"
                        >
                        <?php
                    }
                    ?>
                </div>
                <!-- Plovoucí badge -->
                <div class="hero-badge">
                    <div class="badge-icon" aria-hidden="true">🤖</div>
                    <div class="badge-text">
                        <strong><?php esc_html_e( 'AI & Automatizace', 'jan-kadlec-theme' ); ?></strong>
                        <span><?php esc_html_e( 'Praha &amp; Remote', 'jan-kadlec-theme' ); ?></span>
                    </div>
                </div>
            </div><!-- /.hero-visual -->

        </div><!-- /.hero-inner -->
    </div><!-- /.container -->
</section><!-- /.hero -->


<!-- ============================================================
     EXPERTÍZA — 3 PILÍŘE
     ============================================================ -->
<section class="section section--alt" id="services" aria-labelledby="services-heading">
    <div class="container">

        <header class="section-header">
            <span class="section-eyebrow"><?php esc_html_e( 'Expertíza', 'jan-kadlec-theme' ); ?></span>
            <h2 class="section-title" id="services-heading">
                <?php esc_html_e( 'Tři pilíře', 'jan-kadlec-theme' ); ?>
                <span><?php esc_html_e( 'spolupráce', 'jan-kadlec-theme' ); ?></span>
            </h2>
            <p class="section-desc">
                <?php esc_html_e( 'Neprodávám AI jako buzzword. Každý projekt začíná analýzou reálných procesů a končí měřitelným výsledkem.', 'jan-kadlec-theme' ); ?>
            </p>
        </header>

        <div class="services-grid services-grid--3col">
            <?php jk_render_services( 3 ); ?>
        </div>

    </div><!-- /.container -->
</section><!-- /.services -->


<!-- ============================================================
     O MNĚ — BYZNYSOVÝ KONTEXT
     ============================================================ -->
<section class="section" id="about" aria-labelledby="about-heading">
    <div class="container">
        <div class="about-inner">

            <!-- Fotografie -->
            <div class="about-img-wrap">
                <?php
                $about_img_id = get_theme_mod( 'jk_about_image' );
                if ( $about_img_id ) {
                    echo wp_get_attachment_image( $about_img_id, 'jk-avatar', false, [
                        'alt'     => esc_attr__( 'Jan Kadlec, AI stratég a Managing Director', 'jan-kadlec-theme' ),
                        'loading' => 'lazy',
                    ] );
                } else {
                    ?>
                    <img
                        src="<?php echo esc_url( JK_THEME_URI . '/assets/images/JK-silueta.png' ); ?>"
                        alt="<?php esc_attr_e( 'Jan Kadlec, AI stratég a Managing Director', 'jan-kadlec-theme' ); ?>"
                        class="hero-silhouette"
                        loading="lazy"
                        decoding="async"
                        style="width:100%;height:100%;object-fit:cover;"
                    >
                    <?php
                }
                ?>
            </div>

            <!-- Obsah -->
            <div class="about-content">
                <span class="section-eyebrow"><?php esc_html_e( 'Byznysový kontext', 'jan-kadlec-theme' ); ?></span>
                <h2 id="about-heading"><?php esc_html_e( 'Byznysový kontext nad rámec kódu', 'jan-kadlec-theme' ); ?></h2>
                <p>
                    <?php esc_html_e( 'Jsem jednatel a Managing Director v marketingové agentuře CreatiCom — a právě tohle mění perspektivu. Technologie vidím očima majitele a ředitele, ne jen technického experta. Vím, co to znamená nést odpovědnost za výsledky, žít s rozpočtovými limity a potřebovat řešení, která skutečně fungují v reálném provozu.', 'jan-kadlec-theme' ); ?>
                </p>
                <p>
                    <?php esc_html_e( 'Tato kombinace — hluboká technická znalost AI a přímá zkušenost s řízením firmy — je to, co z naší spolupráce dělá víc než jen IT projekt.', 'jan-kadlec-theme' ); ?>
                </p>

                <ul class="expertise-list" role="list">
                    <?php
                    $expertise = [
                        __( 'Přímá zkušenost s vedením a řízením firmy (Managing Director, CreatiCom)', 'jan-kadlec-theme' ),
                        __( 'Rozhodování v AI projektech přes byznys logiku, ne technický hype', 'jan-kadlec-theme' ),
                        __( 'Schopnost komunikovat s C-level i technickým týmem v jednom jazyce', 'jan-kadlec-theme' ),
                        __( 'Zaměření na ROI a skutečnou hodnotu, ne na demo výsledky', 'jan-kadlec-theme' ),
                    ];
                    foreach ( $expertise as $item ) : ?>
                        <li class="expertise-item">
                            <div class="expertise-dot" aria-hidden="true"></div>
                            <span class="expertise-text"><?= esc_html( $item ) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <!-- CreatiCom odkaz -->
                <div class="creaticom-link-wrap">
                    <a
                        href="https://creaticom.cz/"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="creaticom-link"
                        aria-label="<?php esc_attr_e( 'Navštívit CreatiCom – marketingová agentura', 'jan-kadlec-theme' ); ?>"
                    >
                        <span class="creaticom-link__icon" aria-hidden="true">↗</span>
                        <span class="creaticom-link__text">
                            <strong>CreatiCom</strong>
                            <em><?php esc_html_e( 'marketingová agentura — creaticom.cz', 'jan-kadlec-theme' ); ?></em>
                        </span>
                    </a>
                </div>

                <div style="margin-top: var(--space-md);">
                    <a class="btn btn-blue" href="#contact">
                        <?php esc_html_e( 'Zahájit spolupráci', 'jan-kadlec-theme' ); ?>
                    </a>
                </div>
            </div><!-- /.about-content -->

        </div><!-- /.about-inner -->
    </div><!-- /.container -->
</section><!-- /.about -->


<!-- ============================================================
     PŘÍPADOVÉ STUDIE / REFERENCE
     ============================================================ -->
<section class="section section--alt" id="case-studies" aria-labelledby="references-heading">
    <div class="container">

        <header class="section-header">
            <span class="section-eyebrow"><?php esc_html_e( 'Výsledky klientů', 'jan-kadlec-theme' ); ?></span>
            <h2 class="section-title" id="references-heading">
                <?php esc_html_e( 'Čísla, která', 'jan-kadlec-theme' ); ?>
                <span><?php esc_html_e( 'mluví za vše', 'jan-kadlec-theme' ); ?></span>
            </h2>
            <p class="section-desc">
                <?php esc_html_e( 'Výběr AI a automatizačních projektů realizovaných napříč odvětvími. Konkrétní procesy, konkrétní výsledky.', 'jan-kadlec-theme' ); ?>
            </p>
        </header>

        <div class="references-grid">
            <?php jk_render_references( 3 ); ?>
        </div>

    </div><!-- /.container -->
</section><!-- /.case-studies -->


<!-- ============================================================
     MIMO TERMINÁL — COMING SOON
     ============================================================ -->
<section class="section mimo-terminal" id="mimo-terminal" aria-labelledby="mimo-terminal-heading">
    <div class="container">
        <div class="mimo-terminal__inner">

            <!-- Levý obsah -->
            <div class="mimo-terminal__content">
                <span class="section-eyebrow"><?php esc_html_e( 'Mimo terminál', 'jan-kadlec-theme' ); ?></span>
                <h2 id="mimo-terminal-heading" class="mimo-terminal__title">
                    <?php esc_html_e( 'Leadership, mindset', 'jan-kadlec-theme' ); ?>
                    <br>
                    <span><?php esc_html_e( '& knihy, které mě formují', 'jan-kadlec-theme' ); ?></span>
                </h2>
                <p class="mimo-terminal__desc">
                    <?php esc_html_e( 'AI a automatizace jsou jen část příběhu. Připravuji prostor pro myšlenky o leadershipu, strategickém myšlení a knihách, které rezonují s každodenní realitou vedení firmy.', 'jan-kadlec-theme' ); ?>
                </p>
                <div class="mimo-terminal__coming-soon">
                    <span class="mimo-terminal__dot" aria-hidden="true"></span>
                    <?php esc_html_e( 'Obsah se připravuje — brzy spustím', 'jan-kadlec-theme' ); ?>
                </div>
            </div>

            <!-- Pravý placeholder -->
            <div class="mimo-terminal__cards" aria-hidden="true">
                <div class="book-card book-card--blur">
                    <div class="book-card__spine"></div>
                    <div class="book-card__body">
                        <div class="book-card__line book-card__line--title"></div>
                        <div class="book-card__line book-card__line--author"></div>
                        <div class="book-card__line"></div>
                        <div class="book-card__line book-card__line--short"></div>
                    </div>
                </div>
                <div class="book-card book-card--blur book-card--offset">
                    <div class="book-card__spine book-card__spine--gold"></div>
                    <div class="book-card__body">
                        <div class="book-card__line book-card__line--title"></div>
                        <div class="book-card__line book-card__line--author"></div>
                        <div class="book-card__line"></div>
                    </div>
                </div>
                <div class="book-card book-card--blur book-card--back">
                    <div class="book-card__spine"></div>
                    <div class="book-card__body">
                        <div class="book-card__line book-card__line--title"></div>
                        <div class="book-card__line"></div>
                    </div>
                </div>
            </div>

        </div><!-- /.mimo-terminal__inner -->
    </div><!-- /.container -->
</section><!-- /.mimo-terminal -->


<!-- ============================================================
     KONTAKTNÍ SEKCE
     ============================================================ -->
<section class="cta-section" id="contact" aria-labelledby="cta-heading">
    <div class="container">
        <div class="cta-inner">
            <span class="section-eyebrow" style="background:rgba(255,255,255,0.12); color:#fff;">
                <?php esc_html_e( 'Pojďme si promluvit', 'jan-kadlec-theme' ); ?>
            </span>
            <h2 id="cta-heading">
                <?php esc_html_e( 'Kde má vaše firma největší prostor pro růst?', 'jan-kadlec-theme' ); ?>
            </h2>
            <p>
                <?php esc_html_e( 'Pojďme probrat, kde má vaše firma největší prostor pro růst. Prvních 15 minut je na mě.', 'jan-kadlec-theme' ); ?>
            </p>
            <div class="cta-actions">
                <a class="btn btn-primary" href="mailto:jan@kadlecj.cz">
                    <?php esc_html_e( 'Konzultovat potenciál AI', 'jan-kadlec-theme' ); ?>
                </a>
                <a class="btn btn-secondary" href="mailto:jan@kadlecj.cz" style="color:#fff; border-color:rgba(255,255,255,0.4);">
                    <?php esc_html_e( 'Napsat e-mail', 'jan-kadlec-theme' ); ?>
                </a>
            </div>
        </div>
    </div>
</section><!-- /.cta-section -->


<?php else : ?>
<!-- ============================================================
     STANDARDNÍ ARCHIV / BLOG
     ============================================================ -->
<div class="container" style="padding-top: calc(72px + var(--space-xl)); padding-bottom: var(--space-2xl);">
    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <article <?php post_class( 'card' ); ?> id="post-<?php the_ID(); ?>">
                <div class="card-body">
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <div><?php the_excerpt(); ?></div>
                </div>
            </article>
        <?php endwhile; ?>
        <?php the_posts_navigation(); ?>
    <?php else : ?>
        <p><?php esc_html_e( 'Nebyly nalezeny žádné příspěvky.', 'jan-kadlec-theme' ); ?></p>
    <?php endif; ?>
</div>
<?php endif; ?>

<?php get_footer(); ?>
