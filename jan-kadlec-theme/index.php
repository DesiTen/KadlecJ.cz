<?php
/**
 * Záložní šablona — používá se jen tehdy, když žádná jiná šablona neodpovídá
 * (front-page.php → home.php → archive.php → singular.php → …)
 *
 * @package jan-kadlec-theme
 */
get_header();
?>

<!-- ============================================================
     ZÁLOŽNÍ ARCHIV / BLOG
     ============================================================ -->
<div class="container" style="padding-top: calc(72px + var(--space-lg)); padding-bottom: var(--space-2xl);">

    <?php get_template_part( 'template-parts/breadcrumbs' ); ?>

    <?php if ( have_posts() ) : ?>
        <div class="archive-grid">
            <?php while ( have_posts() ) : the_post(); ?>
                <article
                    <?php post_class( 'card archive-card' ); ?>
                    id="post-<?php the_ID(); ?>"
                    itemscope
                    itemtype="https://schema.org/Article"
                >
                    <?php if ( has_post_thumbnail() ) : ?>
                        <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
                            <?php the_post_thumbnail( 'jk-card', [
                                'class'    => 'archive-card__img',
                                'loading'  => 'lazy',
                                'itemprop' => 'image',
                            ] ); ?>
                        </a>
                    <?php endif; ?>
                    <div class="card-body">
                        <h2 class="archive-card__title" itemprop="headline">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        <p class="text-muted" style="font-size:0.85rem; margin-bottom:0.75rem;">
                            <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" itemprop="datePublished">
                                <?php echo esc_html( get_the_date( 'j. n. Y' ) ); ?>
                            </time>
                        </p>
                        <div itemprop="description"><?php the_excerpt(); ?></div>
                        <a class="service-link" href="<?php the_permalink(); ?>" itemprop="url">
                            <?php esc_html_e( 'Číst dál', 'jan-kadlec-theme' ); ?> →
                        </a>
                    </div>
                </article>
            <?php endwhile; ?>
        </div><!-- /.archive-grid -->
        <div style="margin-top:var(--space-xl);">
            <?php the_posts_navigation( [
                'prev_text' => '← ' . esc_html__( 'Novější příspěvky', 'jan-kadlec-theme' ),
                'next_text' => esc_html__( 'Starší příspěvky', 'jan-kadlec-theme' ) . ' →',
            ] ); ?>
        </div>
    <?php else : ?>
        <p><?php esc_html_e( 'Nebyly nalezeny žádné příspěvky.', 'jan-kadlec-theme' ); ?></p>
    <?php endif; ?>

</div>

<?php get_footer(); ?>
