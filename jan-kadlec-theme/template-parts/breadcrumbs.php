<?php
/**
 * Template part: Breadcrumbs (drobečková navigace)
 *
 * Použití: get_template_part( 'template-parts/breadcrumbs' );
 * Nezobrazuje se na úvodní stránce.
 * Kompatibilní se Schema.org BreadcrumbList (microdata jako záloha za JSON-LD).
 *
 * @package jan-kadlec-theme
 */

defined( 'ABSPATH' ) || exit;

// Na úvodní stránce breadcrumbs nedávají smysl
if ( is_front_page() ) {
    return;
}

$crumbs   = [];
$crumbs[] = [
    'label' => __( 'Domů', 'jan-kadlec-theme' ),
    'url'   => home_url( '/' ),
];

if ( is_singular() ) {
    $post_type = get_post_type();

    // CPT: Služby
    if ( $post_type === 'jk_service' ) {
        $crumbs[] = [
            'label' => __( 'Služby', 'jan-kadlec-theme' ),
            'url'   => home_url( '/sluzby/' ),
        ];
    }

    // CPT: Případové studie
    if ( $post_type === 'jk_reference' ) {
        $archive_link = get_post_type_archive_link( 'jk_reference' );
        $crumbs[]     = [
            'label' => __( 'Případové studie', 'jan-kadlec-theme' ),
            'url'   => $archive_link ?: home_url( '/pripadove-studie/' ),
        ];
    }

    // Blog post — kategorie
    if ( $post_type === 'post' ) {
        $categories = get_the_category();
        if ( $categories ) {
            $crumbs[] = [
                'label' => $categories[0]->name,
                'url'   => get_category_link( $categories[0]->term_id ),
            ];
        }
    }

    // Aktuální příspěvek / stránka (bez odkazu)
    $crumbs[] = [
        'label'   => get_the_title(),
        'current' => true,
    ];

} elseif ( is_archive() ) {
    if ( is_post_type_archive( 'jk_reference' ) ) {
        $crumbs[] = [
            'label'   => __( 'Případové studie', 'jan-kadlec-theme' ),
            'current' => true,
        ];
    } elseif ( is_category() ) {
        $crumbs[] = [
            'label'   => single_cat_title( '', false ),
            'current' => true,
        ];
    } elseif ( is_tag() ) {
        $crumbs[] = [
            'label'   => single_tag_title( '', false ),
            'current' => true,
        ];
    } else {
        $crumbs[] = [
            'label'   => get_the_archive_title(),
            'current' => true,
        ];
    }
} elseif ( is_search() ) {
    $crumbs[] = [
        /* translators: %s: search query */
        'label'   => sprintf( __( 'Výsledky hledání: „%s"', 'jan-kadlec-theme' ), get_search_query() ),
        'current' => true,
    ];
} elseif ( is_404() ) {
    $crumbs[] = [
        'label'   => __( 'Stránka nenalezena', 'jan-kadlec-theme' ),
        'current' => true,
    ];
}

if ( count( $crumbs ) < 2 ) {
    return;
}
?>
<nav
    class="breadcrumbs"
    aria-label="<?php esc_attr_e( 'Drobečková navigace', 'jan-kadlec-theme' ); ?>"
    itemscope
    itemtype="https://schema.org/BreadcrumbList"
>
    <ol class="breadcrumbs__list">
        <?php foreach ( $crumbs as $position => $crumb ) :
            $is_current = ! empty( $crumb['current'] );
            $is_last    = ( $position === array_key_last( $crumbs ) );
        ?>
            <li
                class="breadcrumbs__item<?php echo $is_current ? ' breadcrumbs__item--current' : ''; ?>"
                itemprop="itemListElement"
                itemscope
                itemtype="https://schema.org/ListItem"
            >
                <?php if ( ! $is_current && isset( $crumb['url'] ) ) : ?>
                    <a
                        class="breadcrumbs__link"
                        href="<?php echo esc_url( $crumb['url'] ); ?>"
                        itemprop="item"
                    >
                        <span itemprop="name"><?php echo esc_html( $crumb['label'] ); ?></span>
                    </a>
                <?php else : ?>
                    <span
                        itemprop="name"
                        <?php echo $is_current ? 'aria-current="page"' : ''; ?>
                    ><?php echo esc_html( $crumb['label'] ); ?></span>
                <?php endif; ?>
                <meta itemprop="position" content="<?php echo esc_attr( $position + 1 ); ?>">

                <?php if ( ! $is_last ) : ?>
                    <span class="breadcrumbs__sep" aria-hidden="true">/</span>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ol>
</nav>
