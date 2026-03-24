<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="screen-reader-text" href="#main-content">
    <?php esc_html_e( 'Skip to content', 'jan-kadlec-theme' ); ?>
</a>

<!-- ============================================================
     SITE HEADER
     ============================================================ -->
<header class="site-header" id="site-header" role="banner">
    <div class="container">
        <div class="header-inner">

            <!-- Logo -->
            <a class="site-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" aria-label="<?php esc_attr_e( 'Jan Kadlec — Home', 'jan-kadlec-theme' ); ?>">
                <?php if ( has_custom_logo() ) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <div class="logo-mark" aria-hidden="true">K</div>
                    <div class="logo-text">
                        <span class="logo-name">JAN KADLEC</span>
                        <span class="logo-subtitle"><?php esc_html_e( 'AI &amp; Business Consultant', 'jan-kadlec-theme' ); ?></span>
                    </div>
                <?php endif; ?>
            </a>

            <!-- Primary Navigation -->
            <nav class="primary-nav" id="primary-nav" role="navigation" aria-label="<?php esc_attr_e( 'Primary menu', 'jan-kadlec-theme' ); ?>">
                <?php
                if ( has_nav_menu( 'primary' ) ) {
                    wp_nav_menu( [
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'container'      => false,
                        'items_wrap'     => '%3$s',
                        'fallback_cb'    => false,
                        'walker'         => null,
                        'link_before'    => '',
                        'link_after'     => '',
                        'depth'          => 1,
                    ] );
                } else {
                    // Fallback links when no menu is assigned.
                    ?>
                    <a href="<?php echo esc_url( home_url( '/#services' ) ); ?>"><?php esc_html_e( 'Services', 'jan-kadlec-theme' ); ?></a>
                    <a href="<?php echo esc_url( home_url( '/#about' ) ); ?>"><?php esc_html_e( 'About', 'jan-kadlec-theme' ); ?></a>
                    <a href="<?php echo esc_url( home_url( '/#case-studies' ) ); ?>"><?php esc_html_e( 'Case Studies', 'jan-kadlec-theme' ); ?></a>
                    <a href="<?php echo esc_url( home_url( '/#contact' ) ); ?>"><?php esc_html_e( 'Contact', 'jan-kadlec-theme' ); ?></a>
                    <?php
                }
                ?>
            </nav>

            <!-- Header CTA -->
            <a class="btn btn-primary" href="<?php echo esc_url( home_url( '/#contact' ) ); ?>">
                <?php esc_html_e( 'Book a Call', 'jan-kadlec-theme' ); ?>
            </a>

            <!-- Mobile Toggle -->
            <button
                class="nav-toggle"
                id="nav-toggle"
                aria-controls="primary-nav"
                aria-expanded="false"
                aria-label="<?php esc_attr_e( 'Toggle menu', 'jan-kadlec-theme' ); ?>"
            >
                <span></span>
                <span></span>
                <span></span>
            </button>

        </div><!-- /.header-inner -->
    </div><!-- /.container -->
</header><!-- /.site-header -->

<main id="main-content" class="site-main" role="main">
