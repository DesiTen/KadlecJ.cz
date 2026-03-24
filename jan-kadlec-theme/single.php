<?php
/**
 * Šablona pro jednotlivý příspěvek (blog / CPT)
 *
 * @package jan-kadlec-theme
 */
get_header();
?>

<div class="single-wrap container" style="padding-top: calc(72px + var(--space-lg)); padding-bottom: var(--space-2xl); max-width: 760px;">

    <?php get_template_part( 'template-parts/breadcrumbs' ); ?>

    <?php while ( have_posts() ) : the_post(); ?>

        <article
            <?php post_class( 'prose single-article' ); ?>
            id="post-<?php the_ID(); ?>"
            itemscope
            itemtype="https://schema.org/<?php echo is_singular( 'post' ) ? 'Article' : 'WebPage'; ?>"
        >
            <!-- Skrytá meta data pro microdata zálohu (za JSON-LD) -->
            <meta itemprop="headline"      content="<?php echo esc_attr( get_the_title() ); ?>">
            <meta itemprop="datePublished" content="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
            <meta itemprop="dateModified"  content="<?php echo esc_attr( get_the_modified_date( 'c' ) ); ?>">
            <meta itemprop="inLanguage"    content="cs-CZ">
            <?php if ( has_post_thumbnail() ) : ?>
                <meta itemprop="image" content="<?php echo esc_url( get_the_post_thumbnail_url( null, 'jk-hero' ) ); ?>">
            <?php endif; ?>

            <header class="single-header" style="margin-bottom: var(--space-lg);">

                <!-- Kategorie / typ obsahu -->
                <?php
                $terms = get_the_terms( get_the_ID(), 'category' );
                if ( $terms && ! is_wp_error( $terms ) ) : ?>
                    <div class="single-meta" style="margin-bottom: var(--space-sm);">
                        <?php foreach ( $terms as $term ) : ?>
                            <a
                                class="tag"
                                href="<?php echo esc_url( get_term_link( $term ) ); ?>"
                                itemprop="about"
                            ><?php echo esc_html( $term->name ); ?></a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <h1 itemprop="name"><?php the_title(); ?></h1>

                <!-- Datum + autor -->
                <p class="text-muted" style="margin-top: var(--space-xs); font-size:0.9rem; display:flex; align-items:center; gap:1rem; flex-wrap:wrap;">
                    <time
                        datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"
                        itemprop="datePublished"
                    ><?php echo esc_html( get_the_date( 'j. n. Y' ) ); ?></time>
                    <span aria-hidden="true">·</span>
                    <span itemprop="author" itemscope itemtype="https://schema.org/Person">
                        <span itemprop="name"><?php the_author(); ?></span>
                    </span>
                    <?php
                    // Odhadovaný čas čtení
                    $word_count   = str_word_count( wp_strip_all_tags( get_the_content() ) );
                    $reading_time = max( 1, (int) ceil( $word_count / 200 ) );
                    ?>
                    <span aria-hidden="true">·</span>
                    <span><?php echo esc_html( $reading_time ); ?> min čtení</span>
                </p>

                <!-- Featured image -->
                <?php if ( has_post_thumbnail() ) : ?>
                    <figure
                        style="margin-top: var(--space-md); border-radius: var(--radius-lg); overflow:hidden;"
                        itemprop="image"
                        itemscope
                        itemtype="https://schema.org/ImageObject"
                    >
                        <?php the_post_thumbnail( 'jk-hero', [
                            'style'   => 'width:100%;height:auto;display:block;',
                            'loading' => 'eager',
                            'itemprop' => 'url',
                        ] ); ?>
                        <?php if ( get_the_post_thumbnail_caption() ) : ?>
                            <figcaption style="font-size:0.82rem; color:var(--color-text-muted); padding:0.5rem 0; text-align:center;">
                                <?php echo wp_kses_post( get_the_post_thumbnail_caption() ); ?>
                            </figcaption>
                        <?php endif; ?>
                    </figure>
                <?php endif; ?>
            </header>

            <!-- Hlavní obsah -->
            <div class="entry-content" itemprop="articleBody">
                <?php the_content(); ?>
            </div>

            <!-- Paginace dlouhých článků -->
            <?php
            wp_link_pages( [
                'before'      => '<nav class="page-links" aria-label="' . esc_attr__( 'Stránky článku', 'jan-kadlec-theme' ) . '"><span>' . esc_html__( 'Stránky:', 'jan-kadlec-theme' ) . '</span>',
                'after'       => '</nav>',
                'link_before' => '<span class="btn btn-secondary" style="padding:0.4rem 0.85rem;">',
                'link_after'  => '</span>',
            ] );
            ?>

            <footer class="single-footer" style="margin-top: var(--space-xl); padding-top: var(--space-md); border-top: 1px solid var(--color-border);">

                <!-- Tagy -->
                <?php the_tags(
                    '<div class="single-tags" style="margin-bottom:var(--space-sm); display:flex; gap:0.5rem; flex-wrap:wrap;">',
                    '',
                    '</div>'
                ); ?>

                <!-- Navigace předchozí / následující -->
                <nav class="post-navigation" aria-label="<?php esc_attr_e( 'Navigace v článcích', 'jan-kadlec-theme' ); ?>">
                    <?php the_post_navigation( [
                        'prev_text' => '<span class="post-nav-label">' . esc_html__( '← Předchozí', 'jan-kadlec-theme' ) . '</span><span class="post-nav-title">%title</span>',
                        'next_text' => '<span class="post-nav-label">' . esc_html__( 'Následující →', 'jan-kadlec-theme' ) . '</span><span class="post-nav-title">%title</span>',
                    ] ); ?>
                </nav>

            </footer>

        </article>

    <?php endwhile; ?>

</div><!-- /.single-wrap -->

<?php get_footer(); ?>
