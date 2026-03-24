<?php
/**
 * Main template — Front page / fallback
 *
 * @package jan-kadlec-theme
 */
get_header();
?>

<?php if ( is_front_page() ) : ?>

<!-- ============================================================
     HERO SECTION
     ============================================================ -->
<section class="hero" id="hero" aria-labelledby="hero-heading">
    <div class="container">
        <div class="hero-inner">

            <!-- Content -->
            <div class="hero-content">
                <span class="hero-eyebrow"><?php esc_html_e( 'AI &amp; Business Consulting', 'jan-kadlec-theme' ); ?></span>

                <h1 class="hero-title" id="hero-heading">
                    <?php esc_html_e( 'Transform your business', 'jan-kadlec-theme' ); ?>
                    <br>
                    <?php esc_html_e( 'with', 'jan-kadlec-theme' ); ?>
                    <span class="highlight"><?php esc_html_e( 'AI strategy', 'jan-kadlec-theme' ); ?></span>
                </h1>

                <p class="hero-desc">
                    <?php esc_html_e( 'I help CEOs, founders, and leadership teams cut through AI hype and build practical, high-ROI AI programmes — from vision to measurable results.', 'jan-kadlec-theme' ); ?>
                </p>

                <div class="hero-actions">
                    <a class="btn btn-primary" href="#contact">
                        <?php esc_html_e( 'Book a Free Discovery Call', 'jan-kadlec-theme' ); ?>
                    </a>
                    <a class="btn btn-secondary" href="#case-studies">
                        <?php esc_html_e( 'See Case Studies', 'jan-kadlec-theme' ); ?>
                    </a>
                </div>

                <!-- Trust metrics -->
                <div class="hero-trust" role="list" aria-label="<?php esc_attr_e( 'Key results', 'jan-kadlec-theme' ); ?>">
                    <div class="trust-item" role="listitem">
                        <span class="trust-number">50+</span>
                        <span class="trust-label"><?php esc_html_e( 'AI projects delivered', 'jan-kadlec-theme' ); ?></span>
                    </div>
                    <div class="trust-divider" aria-hidden="true"></div>
                    <div class="trust-item" role="listitem">
                        <span class="trust-number">8+</span>
                        <span class="trust-label"><?php esc_html_e( 'years of experience', 'jan-kadlec-theme' ); ?></span>
                    </div>
                    <div class="trust-divider" aria-hidden="true"></div>
                    <div class="trust-item" role="listitem">
                        <span class="trust-number">30+</span>
                        <span class="trust-label"><?php esc_html_e( 'satisfied clients', 'jan-kadlec-theme' ); ?></span>
                    </div>
                </div>
            </div><!-- /.hero-content -->

            <!-- Visual -->
            <div class="hero-visual" aria-hidden="true">
                <div class="hero-img-wrap">
                    <?php
                    $hero_img_id = get_theme_mod( 'jk_hero_image' );
                    if ( $hero_img_id ) {
                        echo wp_get_attachment_image( $hero_img_id, 'jk-hero', false, [
                            'alt'     => esc_attr__( 'Jan Kadlec — AI & Business Consultant', 'jan-kadlec-theme' ),
                            'loading' => 'eager',
                        ] );
                    }
                    ?>
                </div>
                <!-- Floating badge -->
                <div class="hero-badge">
                    <div class="badge-icon" aria-hidden="true">🤖</div>
                    <div class="badge-text">
                        <strong><?php esc_html_e( 'AI Strategy Expert', 'jan-kadlec-theme' ); ?></strong>
                        <span><?php esc_html_e( 'Prague &amp; Remote', 'jan-kadlec-theme' ); ?></span>
                    </div>
                </div>
            </div><!-- /.hero-visual -->

        </div><!-- /.hero-inner -->
    </div><!-- /.container -->
</section><!-- /.hero -->


<!-- ============================================================
     SERVICES SECTION
     ============================================================ -->
<section class="section section--alt" id="services" aria-labelledby="services-heading">
    <div class="container">

        <header class="section-header">
            <span class="section-eyebrow"><?php esc_html_e( 'What I do', 'jan-kadlec-theme' ); ?></span>
            <h2 class="section-title" id="services-heading">
                <?php esc_html_e( 'Services built for', 'jan-kadlec-theme' ); ?>
                <span><?php esc_html_e( 'real outcomes', 'jan-kadlec-theme' ); ?></span>
            </h2>
            <p class="section-desc">
                <?php esc_html_e( 'From strategic AI roadmaps to hands-on implementation, every engagement is tailored to your specific business context.', 'jan-kadlec-theme' ); ?>
            </p>
        </header>

        <div class="services-grid">
            <?php jk_render_services( 4 ); ?>
        </div>

    </div><!-- /.container -->
</section><!-- /.services -->


<!-- ============================================================
     ABOUT SECTION
     ============================================================ -->
<section class="section" id="about" aria-labelledby="about-heading">
    <div class="container">
        <div class="about-inner">

            <!-- Photo -->
            <div class="about-img-wrap">
                <?php
                $about_img_id = get_theme_mod( 'jk_about_image' );
                if ( $about_img_id ) {
                    echo wp_get_attachment_image( $about_img_id, 'jk-avatar', false, [
                        'alt'     => esc_attr__( 'Jan Kadlec, AI & Business Consultant', 'jan-kadlec-theme' ),
                        'loading' => 'lazy',
                    ] );
                }
                ?>
            </div>

            <!-- Content -->
            <div class="about-content">
                <span class="section-eyebrow"><?php esc_html_e( 'About', 'jan-kadlec-theme' ); ?></span>
                <h2 id="about-heading"><?php esc_html_e( 'I bridge the gap between AI potential and business reality', 'jan-kadlec-theme' ); ?></h2>
                <p>
                    <?php esc_html_e( 'With over 8 years working at the intersection of technology and business strategy, I have helped companies across Central Europe identify where AI creates genuine value — and how to capture it without the typical hype and overspend.', 'jan-kadlec-theme' ); ?>
                </p>
                <ul class="expertise-list" role="list">
                    <?php
                    $expertise = [
                        __( 'AI programme design and vendor-independent strategy', 'jan-kadlec-theme' ),
                        __( 'LLM integration, RAG architectures, and workflow automation', 'jan-kadlec-theme' ),
                        __( 'Change management and AI adoption for leadership teams', 'jan-kadlec-theme' ),
                        __( 'ROI modelling and AI business case development', 'jan-kadlec-theme' ),
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
                        <?php esc_html_e( 'Start a conversation', 'jan-kadlec-theme' ); ?>
                    </a>
                </div>
            </div><!-- /.about-content -->

        </div><!-- /.about-inner -->
    </div><!-- /.container -->
</section><!-- /.about -->


<!-- ============================================================
     CASE STUDIES / REFERENCES
     ============================================================ -->
<section class="section section--alt" id="case-studies" aria-labelledby="references-heading">
    <div class="container">

        <header class="section-header">
            <span class="section-eyebrow"><?php esc_html_e( 'Client results', 'jan-kadlec-theme' ); ?></span>
            <h2 class="section-title" id="references-heading">
                <?php esc_html_e( 'Results that', 'jan-kadlec-theme' ); ?>
                <span><?php esc_html_e( 'speak for themselves', 'jan-kadlec-theme' ); ?></span>
            </h2>
            <p class="section-desc">
                <?php esc_html_e( 'A selection of AI and business transformation projects delivered across industries.', 'jan-kadlec-theme' ); ?>
            </p>
        </header>

        <div class="references-grid">
            <?php jk_render_references( 3 ); ?>
        </div>

    </div><!-- /.container -->
</section><!-- /.case-studies -->


<!-- ============================================================
     CTA SECTION
     ============================================================ -->
<section class="cta-section" id="contact" aria-labelledby="cta-heading">
    <div class="container">
        <div class="cta-inner">
            <span class="section-eyebrow" style="background:rgba(255,255,255,0.12); color:#fff;">
                <?php esc_html_e( "Let's talk", 'jan-kadlec-theme' ); ?>
            </span>
            <h2 id="cta-heading">
                <?php esc_html_e( 'Ready to make AI work for your business?', 'jan-kadlec-theme' ); ?>
            </h2>
            <p>
                <?php esc_html_e( 'Book a free 30-minute discovery call. No sales pitch — just a focused conversation about your goals and where AI can genuinely help.', 'jan-kadlec-theme' ); ?>
            </p>
            <div class="cta-actions">
                <a class="btn btn-primary" href="mailto:jan@kadlecj.cz">
                    <?php esc_html_e( 'Book a Free Discovery Call', 'jan-kadlec-theme' ); ?>
                </a>
                <a class="btn btn-secondary" href="mailto:jan@kadlecj.cz" style="color:#fff; border-color:rgba(255,255,255,0.4);">
                    <?php esc_html_e( 'Send an Email', 'jan-kadlec-theme' ); ?>
                </a>
            </div>
        </div>
    </div>
</section><!-- /.cta-section -->


<?php else : ?>
<!-- ============================================================
     STANDARD BLOG / ARCHIVE LOOP
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
        <p><?php esc_html_e( 'No posts found.', 'jan-kadlec-theme' ); ?></p>
    <?php endif; ?>
</div>
<?php endif; ?>

<?php get_footer(); ?>
