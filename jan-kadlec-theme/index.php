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
                <span class="hero-eyebrow"><?php esc_html_e( 'AI &amp; Business Konzultace', 'jan-kadlec-theme' ); ?></span>

                <h1 class="hero-title" id="hero-heading">
                    <?php esc_html_e( 'Transformujte svůj byznys', 'jan-kadlec-theme' ); ?>
                    <br>
                    <?php esc_html_e( 'pomocí', 'jan-kadlec-theme' ); ?>
                    <span class="highlight"><?php esc_html_e( 'AI strategie', 'jan-kadlec-theme' ); ?></span>
                </h1>

                <p class="hero-desc">
                    <?php esc_html_e( 'Pomáhám generálním ředitelům, zakladatelům a manažerům proniknout skrz hype kolem AI a vybudovat praktické programy s vysokou návratností — od vize až po měřitelné výsledky.', 'jan-kadlec-theme' ); ?>
                </p>

                <div class="hero-actions">
                    <a class="btn btn-primary" href="#contact">
                        <?php esc_html_e( 'Bezplatná úvodní konzultace', 'jan-kadlec-theme' ); ?>
                    </a>
                    <a class="btn btn-secondary" href="#case-studies">
                        <?php esc_html_e( 'Případové studie', 'jan-kadlec-theme' ); ?>
                    </a>
                </div>

                <!-- Důvěryhodnostní metriky -->
                <div class="hero-trust" role="list" aria-label="<?php esc_attr_e( 'Klíčové výsledky', 'jan-kadlec-theme' ); ?>">
                    <div class="trust-item" role="listitem">
                        <span class="trust-number">50+</span>
                        <span class="trust-label"><?php esc_html_e( 'dokončených AI projektů', 'jan-kadlec-theme' ); ?></span>
                    </div>
                    <div class="trust-divider" aria-hidden="true"></div>
                    <div class="trust-item" role="listitem">
                        <span class="trust-number">8+</span>
                        <span class="trust-label"><?php esc_html_e( 'let zkušeností', 'jan-kadlec-theme' ); ?></span>
                    </div>
                    <div class="trust-divider" aria-hidden="true"></div>
                    <div class="trust-item" role="listitem">
                        <span class="trust-number">30+</span>
                        <span class="trust-label"><?php esc_html_e( 'spokojených klientů', 'jan-kadlec-theme' ); ?></span>
                    </div>
                </div>
            </div><!-- /.hero-content -->

            <!-- Vizuál — silueta -->
            <div class="hero-visual" aria-hidden="true">
                <div class="hero-img-wrap">
                    <?php
                    $hero_img_id = get_theme_mod( 'jk_hero_image' );
                    if ( $hero_img_id ) {
                        // Pokud je v Customizeru nahraná fotka, použij ji.
                        echo wp_get_attachment_image( $hero_img_id, 'jk-hero', false, [
                            'alt'     => esc_attr__( 'Jan Kadlec — AI & Business Konzultant', 'jan-kadlec-theme' ),
                            'loading' => 'eager',
                            'class'   => 'hero-photo',
                        ] );
                    } else {
                        // Výchozí silueta z aktiv šablony.
                        ?>
                        <img
                            src="<?php echo esc_url( JK_THEME_URI . '/assets/images/JK-silueta.png' ); ?>"
                            alt="<?php esc_attr_e( 'Jan Kadlec — AI & Business Konzultant', 'jan-kadlec-theme' ); ?>"
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
                        <strong><?php esc_html_e( 'Expert na AI strategii', 'jan-kadlec-theme' ); ?></strong>
                        <span><?php esc_html_e( 'Praha &amp; Remote', 'jan-kadlec-theme' ); ?></span>
                    </div>
                </div>
            </div><!-- /.hero-visual -->

        </div><!-- /.hero-inner -->
    </div><!-- /.container -->
</section><!-- /.hero -->


<!-- ============================================================
     SEKCE SLUŽBY
     ============================================================ -->
<section class="section section--alt" id="services" aria-labelledby="services-heading">
    <div class="container">

        <header class="section-header">
            <span class="section-eyebrow"><?php esc_html_e( 'Co dělám', 'jan-kadlec-theme' ); ?></span>
            <h2 class="section-title" id="services-heading">
                <?php esc_html_e( 'Služby zaměřené na', 'jan-kadlec-theme' ); ?>
                <span><?php esc_html_e( 'skutečné výsledky', 'jan-kadlec-theme' ); ?></span>
            </h2>
            <p class="section-desc">
                <?php esc_html_e( 'Od strategických AI plánů po praktickou implementaci — každá spolupráce je přizpůsobena vašemu konkrétnímu obchodnímu kontextu.', 'jan-kadlec-theme' ); ?>
            </p>
        </header>

        <div class="services-grid">
            <?php jk_render_services( 4 ); ?>
        </div>

    </div><!-- /.container -->
</section><!-- /.services -->


<!-- ============================================================
     SEKCE O MNĚ
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
                        'alt'     => esc_attr__( 'Jan Kadlec, AI & Business Konzultant', 'jan-kadlec-theme' ),
                        'loading' => 'lazy',
                    ] );
                } else {
                    ?>
                    <img
                        src="<?php echo esc_url( JK_THEME_URI . '/assets/images/JK-silueta.png' ); ?>"
                        alt="<?php esc_attr_e( 'Jan Kadlec, AI & Business Konzultant', 'jan-kadlec-theme' ); ?>"
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
                <span class="section-eyebrow"><?php esc_html_e( 'O mně', 'jan-kadlec-theme' ); ?></span>
                <h2 id="about-heading"><?php esc_html_e( 'Překlenuju propast mezi potenciálem AI a obchodní realitou', 'jan-kadlec-theme' ); ?></h2>
                <p>
                    <?php esc_html_e( 'S více než 8 lety práce na průsečíku technologií a obchodní strategie jsem pomohl firmám po celé střední Evropě identifikovat, kde AI přináší skutečnou hodnotu — a jak ji získat bez typického hype a přeinvestování.', 'jan-kadlec-theme' ); ?>
                </p>
                <ul class="expertise-list" role="list">
                    <?php
                    $expertise = [
                        __( 'Návrh AI programů a strategie nezávislá na dodavatelích', 'jan-kadlec-theme' ),
                        __( 'Integrace LLM, RAG architektury a automatizace pracovních postupů', 'jan-kadlec-theme' ),
                        __( 'Řízení změn a adopce AI pro manažerské týmy', 'jan-kadlec-theme' ),
                        __( 'ROI modelování a tvorba business case pro AI projekty', 'jan-kadlec-theme' ),
                    ];
                    foreach ( $expertise as $item ) : ?>
                        <li class="expertise-item">
                            <div class="expertise-dot" aria-hidden="true"></div>
                            <span class="expertise-text"><?= esc_html( $item ) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div style="margin-top: var(--space-sm);">
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
                <?php esc_html_e( 'Výsledky, které', 'jan-kadlec-theme' ); ?>
                <span><?php esc_html_e( 'mluví samy za sebe', 'jan-kadlec-theme' ); ?></span>
            </h2>
            <p class="section-desc">
                <?php esc_html_e( 'Výběr AI a transformačních projektů realizovaných napříč odvětvími.', 'jan-kadlec-theme' ); ?>
            </p>
        </header>

        <div class="references-grid">
            <?php jk_render_references( 3 ); ?>
        </div>

    </div><!-- /.container -->
</section><!-- /.case-studies -->


<!-- ============================================================
     CTA SEKCE
     ============================================================ -->
<section class="cta-section" id="contact" aria-labelledby="cta-heading">
    <div class="container">
        <div class="cta-inner">
            <span class="section-eyebrow" style="background:rgba(255,255,255,0.12); color:#fff;">
                <?php esc_html_e( 'Pojďme si promluvit', 'jan-kadlec-theme' ); ?>
            </span>
            <h2 id="cta-heading">
                <?php esc_html_e( 'Jste připraveni využít AI pro váš byznys?', 'jan-kadlec-theme' ); ?>
            </h2>
            <p>
                <?php esc_html_e( 'Zarezervujte si bezplatný 30minutový úvodní hovor. Žádný prodejní tlak — jen soustředěný rozhovor o vašich cílech a o tom, kde AI skutečně pomůže.', 'jan-kadlec-theme' ); ?>
            </p>
            <div class="cta-actions">
                <a class="btn btn-primary" href="mailto:jan@kadlecj.cz">
                    <?php esc_html_e( 'Bezplatná úvodní konzultace', 'jan-kadlec-theme' ); ?>
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
