<?php
/**
 * Šablona archivů — kategorie, štítky, datum, autor
 *
 * @package jan-kadlec-theme
 */
get_header();
?>

<!-- ============================================================
     ARCHIV — hlavička
     ============================================================ -->
<section class="blog-archive-hero" aria-labelledby="archive-title">
    <div class="container">
        <div class="blog-archive-hero__inner">

            <?php if ( is_category() ) : ?>
                <span class="section-eyebrow"><?php esc_html_e( 'Kategorie', 'jan-kadlec-theme' ); ?></span>
                <h1 class="blog-archive-hero__title" id="archive-title">
                    <?php single_cat_title(); ?>
                </h1>
                <?php if ( category_description() ) : ?>
                    <p class="blog-archive-hero__desc"><?php echo wp_kses_post( category_description() ); ?></p>
                <?php endif; ?>

            <?php elseif ( is_tag() ) : ?>
                <span class="section-eyebrow"><?php esc_html_e( 'Štítek', 'jan-kadlec-theme' ); ?></span>
                <h1 class="blog-archive-hero__title" id="archive-title">
                    <?php single_tag_title(); ?>
                </h1>

            <?php elseif ( is_author() ) : ?>
                <span class="section-eyebrow"><?php esc_html_e( 'Autor', 'jan-kadlec-theme' ); ?></span>
                <h1 class="blog-archive-hero__title" id="archive-title">
                    <?php the_author(); ?>
                </h1>

            <?php elseif ( is_date() ) : ?>
                <span class="section-eyebrow"><?php esc_html_e( 'Archiv', 'jan-kadlec-theme' ); ?></span>
                <h1 class="blog-archive-hero__title" id="archive-title">
                    <?php echo esc_html( get_the_archive_title() ); ?>
                </h1>

            <?php else : ?>
                <h1 class="blog-archive-hero__title" id="archive-title">
                    <?php echo esc_html( get_the_archive_title() ); ?>
                </h1>
            <?php endif; ?>

        </div><!-- /.blog-archive-hero__inner -->
    </div>
</section>

<!-- ============================================================
     ARCHIV — grid příspěvků
     ============================================================ -->
<div class="blog-archive-wrap">
    <div class="container">

        <?php get_template_part( 'template-parts/breadcrumbs' ); ?>

        <?php if ( have_posts() ) : ?>

            <div class="blog-grid">
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php get_template_part( 'template-parts/blog-card', null, [ 'variant' => 'standard' ] ); ?>
                <?php endwhile; ?>
            </div>

            <!-- Paginace -->
            <nav class="blog-pagination" aria-label="<?php esc_attr_e( 'Stránkování archivu', 'jan-kadlec-theme' ); ?>">
                <?php
                the_posts_pagination( [
                    'mid_size'  => 2,
                    'prev_text' => '←',
                    'next_text' => '→',
                ] );
                ?>
            </nav>

        <?php else : ?>

            <div class="blog-empty blog-empty--archive">
                <div class="blog-empty__icon" aria-hidden="true">📭</div>
                <h2 class="blog-empty__title"><?php esc_html_e( 'V této kategorii zatím nic není', 'jan-kadlec-theme' ); ?></h2>
                <a class="btn btn-secondary" href="<?php echo esc_url( home_url( '/#blog' ) ); ?>">
                    ← <?php esc_html_e( 'Zpět na blog', 'jan-kadlec-theme' ); ?>
                </a>
            </div>

        <?php endif; ?>

    </div><!-- /.container -->
</div><!-- /.blog-archive-wrap -->

<?php get_footer(); ?>
