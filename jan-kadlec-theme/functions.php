<?php
/**
 * Jan Kadlec Theme — Functions
 *
 * @package jan-kadlec-theme
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/* ============================================================
   CONSTANTS
   ============================================================ */
define( 'JK_THEME_VERSION', '1.0.0' );
define( 'JK_THEME_DIR',     get_template_directory() );
define( 'JK_THEME_URI',     get_template_directory_uri() );

/* ============================================================
   THEME SETUP
   ============================================================ */
function jk_theme_setup(): void {
    // Make theme available for translation.
    load_theme_textdomain( 'jan-kadlec-theme', JK_THEME_DIR . '/languages' );

    // Automatic feed links in <head>.
    add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title.
    add_theme_support( 'title-tag' );

    // Enable post thumbnails.
    add_theme_support( 'post-thumbnails' );
    add_image_size( 'jk-hero',      1400, 800,  true );
    add_image_size( 'jk-card',       800, 600,  true );
    add_image_size( 'jk-reference',  720, 480,  true );
    add_image_size( 'jk-avatar',     400, 400,  true );

    // Register navigation menus.
    register_nav_menus( [
        'primary' => __( 'Primary Menu', 'jan-kadlec-theme' ),
        'footer'  => __( 'Footer Menu', 'jan-kadlec-theme' ),
    ] );

    // Enable HTML5 support.
    add_theme_support( 'html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ] );

    // Custom logo support.
    add_theme_support( 'custom-logo', [
        'height'      => 44,
        'width'       => 44,
        'flex-height' => true,
        'flex-width'  => true,
    ] );

    // Gutenberg / Block editor.
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'editor-styles' );
    add_editor_style( 'style.css' );

    // Responsive embeds.
    add_theme_support( 'responsive-embeds' );

    // Custom background.
    add_theme_support( 'custom-background', [
        'default-color' => 'FFFFFF',
    ] );
}
add_action( 'after_setup_theme', 'jk_theme_setup' );

/* ============================================================
   ENQUEUE STYLES & SCRIPTS
   ============================================================ */
function jk_enqueue_assets(): void {
    // ---- Google Fonts ----------------------------------------
    // Montserrat (headings) + Inter (body) — subset latin
    $google_fonts_url = add_query_arg(
        [
            'family'  => 'Montserrat:wght@700;800|Inter:wght@400;500',
            'display' => 'swap',
        ],
        'https://fonts.googleapis.com/css2'
    );

    wp_enqueue_style(
        'jk-google-fonts',
        $google_fonts_url,
        [],
        null // no version — Google handles caching
    );

    // DNS-prefetch hint added via wp_head (see jk_preconnect_fonts below).

    // ---- Main Stylesheet ------------------------------------
    wp_enqueue_style(
        'jk-main',
        JK_THEME_URI . '/style.css',
        [ 'jk-google-fonts' ],
        JK_THEME_VERSION
    );

    // ---- Extended / Utility Styles --------------------------
    wp_enqueue_style(
        'jk-custom',
        JK_THEME_URI . '/custom-style.css',
        [ 'jk-main' ],
        JK_THEME_VERSION
    );

    // ---- Theme JS -------------------------------------------
    wp_enqueue_script(
        'jk-main',
        JK_THEME_URI . '/assets/js/main.js',
        [],
        JK_THEME_VERSION,
        [ 'strategy' => 'defer', 'in_footer' => true ]
    );

    // ---- Comments -------------------------------------------
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'jk_enqueue_assets' );

/* ============================================================
   FONT PRECONNECT HINTS
   ============================================================ */
function jk_preconnect_fonts(): void {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}
add_action( 'wp_head', 'jk_preconnect_fonts', 1 );

/* ============================================================
   WIDGET AREAS
   ============================================================ */
function jk_register_sidebars(): void {
    $shared_args = [
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ];

    register_sidebar( array_merge( $shared_args, [
        'name' => __( 'Sidebar', 'jan-kadlec-theme' ),
        'id'   => 'sidebar-1',
    ] ) );

    register_sidebar( array_merge( $shared_args, [
        'name' => __( 'Footer Column 1', 'jan-kadlec-theme' ),
        'id'   => 'footer-1',
    ] ) );

    register_sidebar( array_merge( $shared_args, [
        'name' => __( 'Footer Column 2', 'jan-kadlec-theme' ),
        'id'   => 'footer-2',
    ] ) );
}
add_action( 'widgets_init', 'jk_register_sidebars' );

/* ============================================================
   CONTENT WIDTH
   ============================================================ */
function jk_set_content_width(): void {
    $GLOBALS['content_width'] = 1200;
}
add_action( 'after_setup_theme', 'jk_set_content_width', 0 );

/* ============================================================
   CUSTOM EXCERPT
   ============================================================ */
function jk_excerpt_length(): int {
    return 25;
}
add_filter( 'excerpt_length', 'jk_excerpt_length' );

function jk_excerpt_more(): string {
    return '&hellip;';
}
add_filter( 'excerpt_more', 'jk_excerpt_more' );

/* ============================================================
   SECURITY HEADERS
   ============================================================ */
function jk_remove_wp_version(): string {
    return '';
}
add_filter( 'the_generator', 'jk_remove_wp_version' );

/* ============================================================
   CUSTOM POST TYPES — Services
   ============================================================ */
function jk_register_cpts(): void {
    // Services
    register_post_type( 'jk_service', [
        'labels' => [
            'name'          => __( 'Services', 'jan-kadlec-theme' ),
            'singular_name' => __( 'Service', 'jan-kadlec-theme' ),
            'add_new_item'  => __( 'Add New Service', 'jan-kadlec-theme' ),
        ],
        'public'       => true,
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-star-filled',
        'supports'     => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ],
        'has_archive'  => false,
        'rewrite'      => [ 'slug' => 'services' ],
    ] );

    // Case Studies / References
    register_post_type( 'jk_reference', [
        'labels' => [
            'name'          => __( 'Case Studies', 'jan-kadlec-theme' ),
            'singular_name' => __( 'Case Study', 'jan-kadlec-theme' ),
            'add_new_item'  => __( 'Add New Case Study', 'jan-kadlec-theme' ),
        ],
        'public'       => true,
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-portfolio',
        'supports'     => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ],
        'has_archive'  => true,
        'rewrite'      => [ 'slug' => 'case-studies' ],
    ] );
}
add_action( 'init', 'jk_register_cpts' );

/* ============================================================
   BODY CLASSES
   ============================================================ */
function jk_body_classes( array $classes ): array {
    if ( ! is_singular() ) {
        $classes[] = 'jk-archive';
    }
    if ( is_front_page() ) {
        $classes[] = 'jk-front-page';
    }
    return $classes;
}
add_filter( 'body_class', 'jk_body_classes' );

/* ============================================================
   HELPER: Render service cards (used in index.php / blocks)
   ============================================================ */
function jk_render_services( int $count = 4 ): void {
    $query = new WP_Query( [
        'post_type'      => 'jk_service',
        'posts_per_page' => $count,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    ] );

    if ( ! $query->have_posts() ) {
        // Fallback static data when no CPT entries exist yet.
        jk_render_fallback_services();
        return;
    }

    while ( $query->have_posts() ) {
        $query->the_post();
        $icon = get_post_meta( get_the_ID(), '_jk_service_icon', true ) ?: '🤖';
        ?>
        <div class="service-card">
            <div class="service-icon"><?= esc_html( $icon ) ?></div>
            <h3 class="service-title"><?php the_title(); ?></h3>
            <p class="service-desc"><?php the_excerpt(); ?></p>
            <a class="service-link" href="<?php the_permalink(); ?>">
                <?php esc_html_e( 'Learn more', 'jan-kadlec-theme' ); ?> →
            </a>
        </div>
        <?php
    }
    wp_reset_postdata();
}

function jk_render_fallback_services(): void {
    $services = [
        [
            'icon'  => '🤖',
            'title' => __( 'AI Strategy', 'jan-kadlec-theme' ),
            'desc'  => __( 'Custom AI roadmaps that align with your business goals — from proof-of-concept to scaled deployment.', 'jan-kadlec-theme' ),
        ],
        [
            'icon'  => '📈',
            'title' => __( 'Business Consulting', 'jan-kadlec-theme' ),
            'desc'  => __( 'Operational and growth consulting grounded in data, process design, and measurable KPIs.', 'jan-kadlec-theme' ),
        ],
        [
            'icon'  => '⚙️',
            'title' => __( 'Process Automation', 'jan-kadlec-theme' ),
            'desc'  => __( 'End-to-end workflow automation using AI tools to eliminate bottlenecks and free your team.', 'jan-kadlec-theme' ),
        ],
        [
            'icon'  => '🎓',
            'title' => __( 'AI Workshops', 'jan-kadlec-theme' ),
            'desc'  => __( 'Hands-on team training in LLMs, prompt engineering, and responsible AI adoption.', 'jan-kadlec-theme' ),
        ],
    ];

    foreach ( $services as $s ) : ?>
        <div class="service-card">
            <div class="service-icon"><?= esc_html( $s['icon'] ) ?></div>
            <h3 class="service-title"><?= esc_html( $s['title'] ) ?></h3>
            <p class="service-desc"><?= esc_html( $s['desc'] ) ?></p>
            <a class="service-link" href="#"><?php esc_html_e( 'Learn more', 'jan-kadlec-theme' ); ?> →</a>
        </div>
    <?php endforeach;
}

/* ============================================================
   HELPER: Render reference cards
   ============================================================ */
function jk_render_references( int $count = 3 ): void {
    $query = new WP_Query( [
        'post_type'      => 'jk_reference',
        'posts_per_page' => $count,
        'orderby'        => 'menu_order date',
        'order'          => 'DESC',
    ] );

    if ( ! $query->have_posts() ) {
        jk_render_fallback_references();
        return;
    }

    while ( $query->have_posts() ) {
        $query->the_post();
        $tag    = get_post_meta( get_the_ID(), '_jk_ref_tag', true ) ?: __( 'Case Study', 'jan-kadlec-theme' );
        $metric = get_post_meta( get_the_ID(), '_jk_ref_metric', true );
        $m_label = get_post_meta( get_the_ID(), '_jk_ref_metric_label', true );
        $emoji  = get_post_meta( get_the_ID(), '_jk_ref_emoji', true ) ?: '💼';
        ?>
        <div class="reference-card">
            <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'jk-reference', [ 'class' => 'reference-img', 'loading' => 'lazy' ] ); ?>
            <?php else : ?>
                <div class="reference-img"><?= esc_html( $emoji ) ?></div>
            <?php endif; ?>
            <div class="reference-body">
                <span class="reference-tag"><?= esc_html( $tag ) ?></span>
                <h3 class="reference-title"><?php the_title(); ?></h3>
                <p class="reference-result"><?php the_excerpt(); ?></p>
                <?php if ( $metric ) : ?>
                    <div class="reference-metric">
                        <span class="metric-value"><?= esc_html( $metric ) ?></span>
                        <span class="metric-label"><?= esc_html( $m_label ) ?></span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
    wp_reset_postdata();
}

function jk_render_fallback_references(): void {
    $refs = [
        [
            'emoji'  => '🏭',
            'tag'    => __( 'Manufacturing', 'jan-kadlec-theme' ),
            'title'  => __( 'AI-Driven Quality Control', 'jan-kadlec-theme' ),
            'result' => __( 'Implemented computer vision inspection, cutting defect rate and reducing manual review time.', 'jan-kadlec-theme' ),
            'metric' => '−38%',
            'mlabel' => __( 'defect rate', 'jan-kadlec-theme' ),
        ],
        [
            'emoji'  => '💼',
            'tag'    => __( 'Finance', 'jan-kadlec-theme' ),
            'title'  => __( 'Automated Reporting Pipeline', 'jan-kadlec-theme' ),
            'result' => __( 'Replaced 12 hours of weekly manual reporting with a fully automated AI pipeline.', 'jan-kadlec-theme' ),
            'metric' => '12h',
            'mlabel' => __( 'saved / week', 'jan-kadlec-theme' ),
        ],
        [
            'emoji'  => '🛒',
            'tag'    => __( 'E-Commerce', 'jan-kadlec-theme' ),
            'title'  => __( 'Personalisation Engine', 'jan-kadlec-theme' ),
            'result' => __( 'Deployed a recommendation system that measurably increased average order value.', 'jan-kadlec-theme' ),
            'metric' => '+22%',
            'mlabel' => __( 'avg. order value', 'jan-kadlec-theme' ),
        ],
    ];

    foreach ( $refs as $r ) : ?>
        <div class="reference-card">
            <div class="reference-img"><?= esc_html( $r['emoji'] ) ?></div>
            <div class="reference-body">
                <span class="reference-tag"><?= esc_html( $r['tag'] ) ?></span>
                <h3 class="reference-title"><?= esc_html( $r['title'] ) ?></h3>
                <p class="reference-result"><?= esc_html( $r['result'] ) ?></p>
                <div class="reference-metric">
                    <span class="metric-value"><?= esc_html( $r['metric'] ) ?></span>
                    <span class="metric-label"><?= esc_html( $r['mlabel'] ) ?></span>
                </div>
            </div>
        </div>
    <?php endforeach;
}
