<?php
/**
 * Single post template
 *
 * @package jan-kadlec-theme
 */
get_header();
?>

<div class="container" style="padding-top: calc(72px + var(--space-xl)); padding-bottom: var(--space-2xl); max-width: 760px;">

    <?php while ( have_posts() ) : the_post(); ?>

        <article <?php post_class( 'prose' ); ?> id="post-<?php the_ID(); ?>">

            <header style="margin-bottom: var(--space-lg);">
                <span class="tag" style="margin-bottom: var(--space-sm); display:inline-block;">
                    <?php the_category( ', ' ); ?>
                </span>
                <h1><?php the_title(); ?></h1>
                <p class="text-muted" style="margin-top: var(--space-xs); font-size:0.9rem;">
                    <?php echo esc_html( get_the_date() ); ?>
                    <?php if ( has_post_thumbnail() ) : ?>
                        <br>
                    <?php endif; ?>
                </p>
                <?php if ( has_post_thumbnail() ) : ?>
                    <div style="margin-top: var(--space-md); border-radius: var(--radius-lg); overflow:hidden;">
                        <?php the_post_thumbnail( 'jk-hero', [ 'style' => 'width:100%;height:auto;display:block;', 'loading' => 'eager' ] ); ?>
                    </div>
                <?php endif; ?>
            </header>

            <div class="entry-content">
                <?php the_content(); ?>
            </div>

            <footer style="margin-top: var(--space-xl); padding-top: var(--space-md); border-top: 1px solid var(--color-border);">
                <?php the_tags( '<div style="margin-bottom:var(--space-sm);">', ', ', '</div>' ); ?>
                <?php the_post_navigation( [
                    'prev_text' => '&larr; %title',
                    'next_text' => '%title &rarr;',
                ] ); ?>
            </footer>

        </article>

    <?php endwhile; ?>

</div>

<?php get_footer(); ?>
