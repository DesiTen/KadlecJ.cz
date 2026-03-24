<?php
/**
 * Template part: Blog karta příspěvku
 *
 * Použití:
 *   get_template_part( 'template-parts/blog-card', null, [
 *       'variant' => 'featured',   // 'featured' | 'standard' | 'horizontal'
 *   ] );
 *
 * Musí být voláno uvnitř WordPress Loop (have_posts / the_post).
 *
 * @package jan-kadlec-theme
 */

defined( 'ABSPATH' ) || exit;

$variant = $args['variant'] ?? 'standard'; // featured | standard | horizontal

// Meta hodnoty
$word_count   = str_word_count( wp_strip_all_tags( get_the_content() ) );
$reading_time = max( 1, (int) ceil( $word_count / 200 ) );
$categories   = get_the_category();
$first_cat    = $categories ? $categories[0] : null;

// Barvy kategorií — automaticky se cyklují přes brand paletu
$cat_colors = [ '#0056b3', '#FFD700', '#2d8a4e', '#b35000', '#5000b3' ];
$cat_color  = $first_cat
    ? $cat_colors[ $first_cat->term_id % count( $cat_colors ) ]
    : '#0056b3';
?>

<article
    <?php post_class( 'blog-card blog-card--' . esc_attr( $variant ) ); ?>
    id="post-<?php the_ID(); ?>"
    itemscope
    itemtype="https://schema.org/Article"
>
    <!-- Obrázek -->
    <a
        class="blog-card__img-wrap"
        href="<?php the_permalink(); ?>"
        tabindex="-1"
        aria-hidden="true"
    >
        <?php if ( has_post_thumbnail() ) : ?>
            <?php the_post_thumbnail(
                $variant === 'featured' ? 'jk-hero' : 'jk-card',
                [
                    'class'    => 'blog-card__img',
                    'loading'  => 'lazy',
                    'itemprop' => 'image',
                    'alt'      => esc_attr( get_the_title() ),
                ]
            ); ?>
        <?php else : ?>
            <!-- Placeholder s iniciálou kategorie -->
            <div class="blog-card__img-placeholder" style="--cat-color: <?php echo esc_attr( $cat_color ); ?>">
                <span><?php echo esc_html( $first_cat ? mb_strtoupper( mb_substr( $first_cat->name, 0, 1 ) ) : 'B' ); ?></span>
            </div>
        <?php endif; ?>

        <!-- Kategorie jako overlay badge na obrázku -->
        <?php if ( $first_cat ) : ?>
            <span class="blog-card__cat-badge" style="--cat-color: <?php echo esc_attr( $cat_color ); ?>">
                <?php echo esc_html( $first_cat->name ); ?>
            </span>
        <?php endif; ?>
    </a>

    <!-- Obsah karty -->
    <div class="blog-card__body">

        <!-- Titulek -->
        <h3 class="blog-card__title" itemprop="headline">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>

        <!-- Meta: datum + čas čtení -->
        <div class="blog-card__meta">
            <time
                class="blog-card__date"
                datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"
                itemprop="datePublished"
            ><?php echo esc_html( get_the_date( 'j. n. Y' ) ); ?></time>
            <span class="blog-card__sep" aria-hidden="true">·</span>
            <span class="blog-card__reading-time">
                <?php echo esc_html( $reading_time ); ?> min čtení
            </span>
        </div>

        <!-- Výtah (pouze pro featured a standard) -->
        <?php if ( $variant !== 'horizontal' ) : ?>
            <p class="blog-card__excerpt" itemprop="description">
                <?php echo esc_html( wp_trim_words( get_the_excerpt(), $variant === 'featured' ? 28 : 18, '…' ) ); ?>
            </p>
        <?php endif; ?>

        <!-- Odkaz -->
        <a
            class="blog-card__link service-link"
            href="<?php the_permalink(); ?>"
            itemprop="url"
            aria-label="<?php echo esc_attr( sprintf( __( 'Číst: %s', 'jan-kadlec-theme' ), get_the_title() ) ); ?>"
        ><?php esc_html_e( 'Číst dál', 'jan-kadlec-theme' ); ?> →</a>

    </div><!-- /.blog-card__body -->

</article>
