<?php
/**
 * Jan Kadlec Theme — Funkce šablony
 *
 * @package jan-kadlec-theme
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/* ============================================================
   KONSTANTY
   ============================================================ */
define( 'JK_THEME_VERSION', '1.0.0' );
define( 'JK_THEME_DIR',     get_template_directory() );
define( 'JK_THEME_URI',     get_template_directory_uri() );

/* ============================================================
   NASTAVENÍ ŠABLONY
   ============================================================ */
function jk_theme_setup(): void {
    // Podpora překladu šablony.
    load_theme_textdomain( 'jan-kadlec-theme', JK_THEME_DIR . '/languages' );

    // Automatické RSS odkazy v <head>.
    add_theme_support( 'automatic-feed-links' );

    // WordPress spravuje titulek stránky.
    add_theme_support( 'title-tag' );

    // Náhledy příspěvků (featured images).
    add_theme_support( 'post-thumbnails' );
    add_image_size( 'jk-hero',      1400, 800,  true );
    add_image_size( 'jk-card',       800, 600,  true );
    add_image_size( 'jk-reference',  720, 480,  true );
    add_image_size( 'jk-avatar',     400, 400,  true );

    // Registrace navigačních menu.
    register_nav_menus( [
        'primary' => __( 'Hlavní menu', 'jan-kadlec-theme' ),
        'footer'  => __( 'Menu v patičce', 'jan-kadlec-theme' ),
    ] );

    // HTML5 podpora.
    add_theme_support( 'html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ] );

    // Vlastní logo.
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

    // Responzivní embedy.
    add_theme_support( 'responsive-embeds' );

    // Vlastní pozadí.
    add_theme_support( 'custom-background', [
        'default-color' => 'FFFFFF',
    ] );
}
add_action( 'after_setup_theme', 'jk_theme_setup' );

/* ============================================================
   NAČÍTÁNÍ STYLŮ A SKRIPTŮ
   ============================================================ */
function jk_enqueue_assets(): void {
    // ---- Google Fonts ----------------------------------------
    // Montserrat (nadpisy) + Inter (text) — subset latin
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
        null // bez verze — Google řeší cache
    );

    // DNS-prefetch hint přidán přes wp_head (viz jk_preconnect_fonts níže).

    // ---- Hlavní stylesheet ------------------------------------
    wp_enqueue_style(
        'jk-main',
        JK_THEME_URI . '/style.css',
        [ 'jk-google-fonts' ],
        JK_THEME_VERSION
    );

    // ---- Rozšířené / utility styly ---------------------------
    wp_enqueue_style(
        'jk-custom',
        JK_THEME_URI . '/custom-style.css',
        [ 'jk-main' ],
        JK_THEME_VERSION
    );

    // ---- Hlavní JS -------------------------------------------
    wp_enqueue_script(
        'jk-main',
        JK_THEME_URI . '/assets/js/main.js',
        [],
        JK_THEME_VERSION,
        [ 'strategy' => 'defer', 'in_footer' => true ]
    );

    // ---- Komentáře -------------------------------------------
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'jk_enqueue_assets' );

/* ============================================================
   PRECONNECT HINTY PRO FONTY
   ============================================================ */
function jk_preconnect_fonts(): void {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}
add_action( 'wp_head', 'jk_preconnect_fonts', 1 );

/* ============================================================
   WIDGETOVÉ OBLASTI
   ============================================================ */
function jk_register_sidebars(): void {
    $shared_args = [
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ];

    register_sidebar( array_merge( $shared_args, [
        'name' => __( 'Postranní panel', 'jan-kadlec-theme' ),
        'id'   => 'sidebar-1',
    ] ) );

    register_sidebar( array_merge( $shared_args, [
        'name' => __( 'Patička – sloupec 1', 'jan-kadlec-theme' ),
        'id'   => 'footer-1',
    ] ) );

    register_sidebar( array_merge( $shared_args, [
        'name' => __( 'Patička – sloupec 2', 'jan-kadlec-theme' ),
        'id'   => 'footer-2',
    ] ) );
}
add_action( 'widgets_init', 'jk_register_sidebars' );

/* ============================================================
   ŠÍŘKA OBSAHU
   ============================================================ */
function jk_set_content_width(): void {
    $GLOBALS['content_width'] = 1200;
}
add_action( 'after_setup_theme', 'jk_set_content_width', 0 );

/* ============================================================
   VLASTNÍ VÝTAH (EXCERPT)
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
   BEZPEČNOSTNÍ HLAVIČKY
   ============================================================ */
function jk_remove_wp_version(): string {
    return '';
}
add_filter( 'the_generator', 'jk_remove_wp_version' );

/* ============================================================
   VLASTNÍ TYPY PŘÍSPĚVKŮ — Služby & Případové studie
   ============================================================ */
function jk_register_cpts(): void {
    // Služby
    register_post_type( 'jk_service', [
        'labels' => [
            'name'          => __( 'Služby', 'jan-kadlec-theme' ),
            'singular_name' => __( 'Služba', 'jan-kadlec-theme' ),
            'add_new_item'  => __( 'Přidat novou službu', 'jan-kadlec-theme' ),
        ],
        'public'       => true,
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-star-filled',
        'supports'     => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ],
        'has_archive'  => false,
        'rewrite'      => [ 'slug' => 'sluzby' ],
    ] );

    // Případové studie / Reference
    register_post_type( 'jk_reference', [
        'labels' => [
            'name'          => __( 'Případové studie', 'jan-kadlec-theme' ),
            'singular_name' => __( 'Případová studie', 'jan-kadlec-theme' ),
            'add_new_item'  => __( 'Přidat novou případovou studii', 'jan-kadlec-theme' ),
        ],
        'public'       => true,
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-portfolio',
        'supports'     => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ],
        'has_archive'  => true,
        'rewrite'      => [ 'slug' => 'pripadove-studie' ],
    ] );
}
add_action( 'init', 'jk_register_cpts' );

/* ============================================================
   TŘÍDY BODY
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
   POMOCNÍK: Vykreslení karet služeb (index.php / bloky)
   ============================================================ */
function jk_render_services( int $count = 4 ): void {
    $query = new WP_Query( [
        'post_type'      => 'jk_service',
        'posts_per_page' => $count,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    ] );

    if ( ! $query->have_posts() ) {
        // Záložní statická data, pokud ještě nejsou žádné záznamy CPT.
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
                <?php esc_html_e( 'Zjistit více', 'jan-kadlec-theme' ); ?> →
            </a>
        </div>
        <?php
    }
    wp_reset_postdata();
}

function jk_render_fallback_services(): void {
    $services = [
        [
            'icon'  => '🎯',
            'title' => __( 'AI Strategie & Audit', 'jan-kadlec-theme' ),
            'desc'  => __( 'Neimplementuji AI pro efekt. Identifikuji kritická místa ve workflow, kde nasazení modelů přinese skutečnou návratnost — a kde naopak ne. Výstupem je konkrétní plán s prioritami a odhadovaným ROI.', 'jan-kadlec-theme' ),
        ],
        [
            'icon'  => '🔗',
            'title' => __( 'Procesní automatizace na míru', 'jan-kadlec-theme' ),
            'desc'  => __( 'Propojuji CRM, ERP a interní nástroje do autonomních celků. Stavím automatizace v Make i na míru — procesy, které jedou samy a vrátí vašemu týmu stovky hodin ročně.', 'jan-kadlec-theme' ),
        ],
        [
            'icon'  => '⚡',
            'title' => __( 'Rapid Prototyping', 'jan-kadlec-theme' ),
            'desc'  => __( 'Rychlý vývoj funkčních interních aplikací a MVP v řádu dnů. Metodikou Vibe Coding dokážeme ověřit nebo dodat řešení dřív, než klasický vývoj napíše první specifikaci.', 'jan-kadlec-theme' ),
        ],
    ];

    foreach ( $services as $s ) : ?>
        <div class="service-card">
            <div class="service-icon"><?= esc_html( $s['icon'] ) ?></div>
            <h3 class="service-title"><?= esc_html( $s['title'] ) ?></h3>
            <p class="service-desc"><?= esc_html( $s['desc'] ) ?></p>
            <a class="service-link" href="#"><?php esc_html_e( 'Zjistit více', 'jan-kadlec-theme' ); ?> →</a>
        </div>
    <?php endforeach;
}

/* ============================================================
   POMOCNÍK: Vykreslení karet referencí
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
        $tag     = get_post_meta( get_the_ID(), '_jk_ref_tag', true ) ?: __( 'Případová studie', 'jan-kadlec-theme' );
        $metric  = get_post_meta( get_the_ID(), '_jk_ref_metric', true );
        $m_label = get_post_meta( get_the_ID(), '_jk_ref_metric_label', true );
        $emoji   = get_post_meta( get_the_ID(), '_jk_ref_emoji', true ) ?: '💼';
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
            'tag'    => __( 'Výroba', 'jan-kadlec-theme' ),
            'title'  => __( 'Automatizace výstupní kontroly', 'jan-kadlec-theme' ),
            'result' => __( 'Nasazení AI modelu pro automatickou inspekci výrobních kusů. Eliminace manuálního třídění a zkrácení cyklu kontroly kvality.', 'jan-kadlec-theme' ),
            'metric' => '−38%',
            'mlabel' => __( 'míra defektů', 'jan-kadlec-theme' ),
        ],
        [
            'emoji'  => '📊',
            'tag'    => __( 'Marketing & Agentura', 'jan-kadlec-theme' ),
            'title'  => __( 'Automatizovaný reporting klientů', 'jan-kadlec-theme' ),
            'result' => __( 'Propojení reklamních platforem, CRM a Google Sheets do autonomního pipeline. 12 hodin manuální práce týdně eliminováno.', 'jan-kadlec-theme' ),
            'metric' => '12h',
            'mlabel' => __( 'ušetřeno / týden', 'jan-kadlec-theme' ),
        ],
        [
            'emoji'  => '🛒',
            'tag'    => __( 'E-Commerce', 'jan-kadlec-theme' ),
            'title'  => __( 'AI personalizace produktového feedu', 'jan-kadlec-theme' ),
            'result' => __( 'Rapid prototyping doporučovacího enginu v Make + custom API. Nasazeno za 11 dní od prvního briefu.', 'jan-kadlec-theme' ),
            'metric' => '+22%',
            'mlabel' => __( 'průměrná hodnota objednávky', 'jan-kadlec-theme' ),
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
