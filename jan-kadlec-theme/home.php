<?php
/**
 * Šablona blogu — Posts Page
 *
 * Zobrazí se, když je v Nastavení → Čtení nastavena
 * "Stránka příspěvků" na konkrétní stránku (např. /blog/).
 * WordPress pro tuto šablonu předá standardní Loop se všemi
 * publikovanými příspěvky.
 *
 * @package jan-kadlec-theme
 */
get_header();

// Název a popis sekce — přebírá z nastavené "Posts page" nebo fallback
$posts_page_id   = (int) get_option( 'page_for_posts' );
$archive_title   = $posts_page_id ? get_the_title( $posts_page_id ) : __( 'Blog', 'jan-kadlec-theme' );
$archive_desc    = $posts_page_id ? get_the_excerpt( $posts_page_id ) : '';
?>

<!-- ============================================================
     BLOG ARCHIV — hlavička
     ============================================================ -->
<section class="blog-archive-hero" aria-labelledby="blog-archive-title">
    <div class="container">
        <div class="blog-archive-hero__inner">
            <span class="section-eyebrow"><?php esc_html_e( 'Mimo terminál', 'jan-kadlec-theme' ); ?></span>
            <h1 class="blog-archive-hero__title" id="blog-archive-title">
                <?php echo esc_html( $archive_title ); ?>
            </h1>
            <?php if ( $archive_desc ) : ?>
                <p class="blog-archive-hero__desc">
                    <?php echo esc_html( $archive_desc ); ?>
                </p>
            <?php else : ?>
                <p class="blog-archive-hero__desc">
                    <?php esc_html_e( 'Myšlenky o leadershipu, AI, strategickém myšlení a knihách, které rezonují s každodenní realitou vedení firmy.', 'jan-kadlec-theme' ); ?>
                </p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ============================================================
     BLOG ARCHIV — filtr kategorií
     ============================================================ -->
<?php
$blog_cats = get_categories( [
    'orderby'    => 'count',
    'order'      => 'DESC',
    'hide_empty' => true,
    'number'     => 8,
] );
if ( $blog_cats ) :
    $current_cat = get_query_var( 'cat' );
?>
<div class="blog-filter-bar">
    <div class="container">
        <nav class="blog-filter" aria-label="<?php esc_attr_e( 'Filtr kategorií', 'jan-kadlec-theme' ); ?>">
            <a
                class="blog-filter__item<?php echo ! $current_cat ? ' blog-filter__item--active' : ''; ?>"
                href="<?php echo esc_url( $posts_page_id ? get_permalink( $posts_page_id ) : home_url( '/blog/' ) ); ?>"
            ><?php esc_html_e( 'Vše', 'jan-kadlec-theme' ); ?></a>
            <?php foreach ( $blog_cats as $cat ) : ?>
                <a
                    class="blog-filter__item<?php echo ( $current_cat === $cat->term_id ) ? ' blog-filter__item--active' : ''; ?>"
                    href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>"
                ><?php echo esc_html( $cat->name ); ?></a>
            <?php endforeach; ?>
        </nav>
    </div>
</div>
<?php endif; ?>

<!-- ============================================================
     BLOG ARCHIV — grid příspěvků
     ============================================================ -->
<div class="blog-archive-wrap">
    <div class="container">

        <?php if ( have_posts() ) : ?>

            <div class="blog-grid">
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php get_template_part( 'template-parts/blog-card', null, [ 'variant' => 'standard' ] ); ?>
                <?php endwhile; ?>
            </div>

            <!-- Paginace -->
            <nav class="blog-pagination" aria-label="<?php esc_attr_e( 'Stránkování blogu', 'jan-kadlec-theme' ); ?>">
                <?php
                the_posts_pagination( [
                    'mid_size'           => 2,
                    'prev_text'          => '←',
                    'next_text'          => '→',
                    'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Stránka', 'jan-kadlec-theme' ) . ' </span>',
                ] );
                ?>
            </nav>

        <?php else : ?>

            <div class="blog-empty blog-empty--archive">
                <div class="blog-empty__icon" aria-hidden="true">✍️</div>
                <h2 class="blog-empty__title"><?php esc_html_e( 'Zatím žádné příspěvky', 'jan-kadlec-theme' ); ?></h2>
                <p class="blog-empty__hint">
                    <?php esc_html_e( 'Obsah se připravuje. Zkuste to brzy znovu.', 'jan-kadlec-theme' ); ?>
                </p>
                <a class="btn btn-secondary" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    ← <?php esc_html_e( 'Zpět na hlavní stránku', 'jan-kadlec-theme' ); ?>
                </a>
            </div>

        <?php endif; ?>

    </div><!-- /.container -->
</div><!-- /.blog-archive-wrap -->

<?php get_footer(); ?>
