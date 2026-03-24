</main><!-- /#main-content -->

<!-- ============================================================
     PATIČKA WEBU
     ============================================================ -->
<footer class="site-footer" id="site-footer" role="contentinfo">
    <div class="container">

        <div class="footer-inner">

            <!-- Značka -->
            <div class="footer-brand">
                <a class="footer-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" aria-label="<?php esc_attr_e( 'Jan Kadlec — Domů', 'jan-kadlec-theme' ); ?>">
                    <div class="logo-mark" aria-hidden="true">K</div>
                    <div class="logo-text">
                        <span class="logo-name">JAN KADLEC</span>
                        <span class="logo-subtitle"><?php esc_html_e( 'AI &amp; Business Konzultant', 'jan-kadlec-theme' ); ?></span>
                    </div>
                </a>
                <p class="footer-tagline">
                    <?php esc_html_e( 'Pomáhám organizacím orientovat se v přechodu na AI s jasností, strategií a měřitelnými výsledky.', 'jan-kadlec-theme' ); ?>
                </p>
            </div>

            <!-- Navigace -->
            <div class="footer-col">
                <p class="footer-nav-title"><?php esc_html_e( 'Navigace', 'jan-kadlec-theme' ); ?></p>
                <nav class="footer-nav" aria-label="<?php esc_attr_e( 'Navigace v patičce', 'jan-kadlec-theme' ); ?>">
                    <?php
                    if ( has_nav_menu( 'footer' ) ) {
                        wp_nav_menu( [
                            'theme_location' => 'footer',
                            'container'      => false,
                            'items_wrap'     => '%3$s',
                            'fallback_cb'    => false,
                            'depth'          => 1,
                        ] );
                    } else {
                        ?>
                        <a href="<?php echo esc_url( home_url( '/#services' ) ); ?>"><?php esc_html_e( 'Služby', 'jan-kadlec-theme' ); ?></a>
                        <a href="<?php echo esc_url( home_url( '/#about' ) ); ?>"><?php esc_html_e( 'O mně', 'jan-kadlec-theme' ); ?></a>
                        <a href="<?php echo esc_url( home_url( '/#case-studies' ) ); ?>"><?php esc_html_e( 'Případové studie', 'jan-kadlec-theme' ); ?></a>
                        <a href="<?php echo esc_url( home_url( '/#contact' ) ); ?>"><?php esc_html_e( 'Kontakt', 'jan-kadlec-theme' ); ?></a>
                        <a href="<?php echo esc_url( get_privacy_policy_url() ); ?>"><?php esc_html_e( 'Zásady ochrany osobních údajů', 'jan-kadlec-theme' ); ?></a>
                        <?php
                    }
                    ?>
                </nav>
            </div>

            <!-- Kontakt -->
            <div class="footer-col">
                <p class="footer-nav-title"><?php esc_html_e( 'Kontakt', 'jan-kadlec-theme' ); ?></p>
                <ul class="footer-contact-list">
                    <li>
                        <span aria-hidden="true">✉</span>
                        <a href="mailto:jan@kadlecj.cz">jan@kadlecj.cz</a>
                    </li>
                    <li>
                        <span aria-hidden="true">🌐</span>
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">kadlecj.cz</a>
                    </li>
                    <li>
                        <span aria-hidden="true">📍</span>
                        <?php esc_html_e( 'Praha, Česká republika', 'jan-kadlec-theme' ); ?>
                    </li>
                    <li>
                        <span aria-hidden="true">💼</span>
                        <a href="https://linkedin.com/in/jankadlec" target="_blank" rel="noopener noreferrer">LinkedIn</a>
                    </li>
                </ul>
            </div>

        </div><!-- /.footer-inner -->

        <!-- Spodní lišta patičky -->
        <div class="footer-bottom">
            <p class="footer-copy">
                &copy; <?php echo esc_html( date( 'Y' ) ); ?> Jan Kadlec.
                <?php esc_html_e( 'Všechna práva vyhrazena.', 'jan-kadlec-theme' ); ?>
            </p>
            <nav class="footer-legal" aria-label="<?php esc_attr_e( 'Právní odkazy', 'jan-kadlec-theme' ); ?>">
                <?php if ( get_privacy_policy_url() ) : ?>
                    <a href="<?php echo esc_url( get_privacy_policy_url() ); ?>">
                        <?php esc_html_e( 'Ochrana osobních údajů', 'jan-kadlec-theme' ); ?>
                    </a>
                <?php endif; ?>
                <a href="<?php echo esc_url( home_url( '/cookies' ) ); ?>">
                    <?php esc_html_e( 'Zásady cookies', 'jan-kadlec-theme' ); ?>
                </a>
            </nav>
        </div><!-- /.footer-bottom -->

    </div><!-- /.container -->
</footer><!-- /.site-footer -->

<?php wp_footer(); ?>
</body>
</html>
