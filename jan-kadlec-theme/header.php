<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Barva prohlížeče na mobilech (brand primary) -->
    <meta name="theme-color" content="#0056b3">

    <!-- Autor webu -->
    <link rel="author" href="<?php echo esc_url( home_url( '/' ) ); ?>">

    <!-- Preload kritického fontu (Montserrat Bold — hlavní nadpisy) -->
    <link
        rel="preload"
        as="style"
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800&amp;family=Inter:wght@400;500&amp;display=swap"
        crossorigin="anonymous"
    >

    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="screen-reader-text" href="#main-content">
    <?php esc_html_e( 'Přejít na obsah', 'jan-kadlec-theme' ); ?>
</a>

<!-- ============================================================
     HLAVIČKA WEBU
     ============================================================ -->
<header class="site-header" id="site-header" role="banner">
    <div class="container">
        <div class="header-inner">

            <!-- Logo -->
            <a class="site-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" aria-label="<?php esc_attr_e( 'Jan Kadlec — Domů', 'jan-kadlec-theme' ); ?>">
                <?php if ( has_custom_logo() ) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <div class="logo-mark" aria-hidden="true">K</div>
                    <div class="logo-text">
                        <span class="logo-name">JAN KADLEC</span>
                        <span class="logo-subtitle"><?php esc_html_e( 'AI &amp; Business Konzultant', 'jan-kadlec-theme' ); ?></span>
                    </div>
                <?php endif; ?>
            </a>

            <!-- Hlavní navigace -->
            <nav class="primary-nav" id="primary-nav" role="navigation" aria-label="<?php esc_attr_e( 'Hlavní menu', 'jan-kadlec-theme' ); ?>">
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
                    // Záložní odkazy, pokud není přiřazeno menu.
                    ?>
                    <a href="<?php echo esc_url( home_url( '/#services' ) ); ?>"><?php esc_html_e( 'Služby', 'jan-kadlec-theme' ); ?></a>
                    <a href="<?php echo esc_url( home_url( '/#about' ) ); ?>"><?php esc_html_e( 'O mně', 'jan-kadlec-theme' ); ?></a>
                    <a href="<?php echo esc_url( home_url( '/#case-studies' ) ); ?>"><?php esc_html_e( 'Případové studie', 'jan-kadlec-theme' ); ?></a>
                    <a href="<?php echo esc_url( home_url( '/#contact' ) ); ?>"><?php esc_html_e( 'Kontakt', 'jan-kadlec-theme' ); ?></a>
                    <?php
                }
                ?>
            </nav>

            <!-- CTA v hlavičce -->
            <a class="btn btn-primary" href="<?php echo esc_url( home_url( '/#contact' ) ); ?>">
                <?php esc_html_e( 'Domluvit schůzku', 'jan-kadlec-theme' ); ?>
            </a>

            <!-- Tlačítko mobilního menu -->
            <button
                class="nav-toggle"
                id="nav-toggle"
                aria-controls="primary-nav"
                aria-expanded="false"
                aria-label="<?php esc_attr_e( 'Otevřít / zavřít menu', 'jan-kadlec-theme' ); ?>"
            >
                <span></span>
                <span></span>
                <span></span>
            </button>

        </div><!-- /.header-inner -->
    </div><!-- /.container -->
</header><!-- /.site-header -->

<main id="main-content" class="site-main" role="main">
