</main><!-- /#main-content -->

<!-- ============================================================
     SITE FOOTER
     ============================================================ -->
<footer class="site-footer" id="site-footer" role="contentinfo">
    <div class="container">

        <div class="footer-inner">

            <!-- Brand Column -->
            <div class="footer-brand">
                <a class="footer-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" aria-label="<?php esc_attr_e( 'Jan Kadlec — Home', 'jan-kadlec-theme' ); ?>">
                    <div class="logo-mark" aria-hidden="true">K</div>
                    <div class="logo-text">
                        <span class="logo-name">JAN KADLEC</span>
                        <span class="logo-subtitle"><?php esc_html_e( 'AI &amp; Business Consultant', 'jan-kadlec-theme' ); ?></span>
                    </div>
                </a>
                <p class="footer-tagline">
                    <?php esc_html_e( 'Helping organisations navigate the AI transition with clarity, strategy, and measurable results.', 'jan-kadlec-theme' ); ?>
                </p>
            </div>

            <!-- Navigation Column -->
            <div class="footer-col">
                <p class="footer-nav-title"><?php esc_html_e( 'Navigation', 'jan-kadlec-theme' ); ?></p>
                <nav class="footer-nav" aria-label="<?php esc_attr_e( 'Footer navigation', 'jan-kadlec-theme' ); ?>">
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
                        <a href="<?php echo esc_url( home_url( '/#services' ) ); ?>"><?php esc_html_e( 'Services', 'jan-kadlec-theme' ); ?></a>
                        <a href="<?php echo esc_url( home_url( '/#about' ) ); ?>"><?php esc_html_e( 'About', 'jan-kadlec-theme' ); ?></a>
                        <a href="<?php echo esc_url( home_url( '/#case-studies' ) ); ?>"><?php esc_html_e( 'Case Studies', 'jan-kadlec-theme' ); ?></a>
                        <a href="<?php echo esc_url( home_url( '/#contact' ) ); ?>"><?php esc_html_e( 'Contact', 'jan-kadlec-theme' ); ?></a>
                        <a href="<?php echo esc_url( get_privacy_policy_url() ); ?>"><?php esc_html_e( 'Privacy Policy', 'jan-kadlec-theme' ); ?></a>
                        <?php
                    }
                    ?>
                </nav>
            </div>

            <!-- Contact Column -->
            <div class="footer-col">
                <p class="footer-nav-title"><?php esc_html_e( 'Contact', 'jan-kadlec-theme' ); ?></p>
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
                        <?php esc_html_e( 'Prague, Czech Republic', 'jan-kadlec-theme' ); ?>
                    </li>
                    <li>
                        <span aria-hidden="true">💼</span>
                        <a href="https://linkedin.com/in/jankadlec" target="_blank" rel="noopener noreferrer">LinkedIn</a>
                    </li>
                </ul>
            </div>

        </div><!-- /.footer-inner -->

        <!-- Footer Bottom Bar -->
        <div class="footer-bottom">
            <p class="footer-copy">
                &copy; <?php echo esc_html( date( 'Y' ) ); ?> Jan Kadlec.
                <?php esc_html_e( 'All rights reserved.', 'jan-kadlec-theme' ); ?>
            </p>
            <nav class="footer-legal" aria-label="<?php esc_attr_e( 'Legal links', 'jan-kadlec-theme' ); ?>">
                <?php if ( get_privacy_policy_url() ) : ?>
                    <a href="<?php echo esc_url( get_privacy_policy_url() ); ?>">
                        <?php esc_html_e( 'Privacy Policy', 'jan-kadlec-theme' ); ?>
                    </a>
                <?php endif; ?>
                <a href="<?php echo esc_url( home_url( '/cookies' ) ); ?>">
                    <?php esc_html_e( 'Cookie Policy', 'jan-kadlec-theme' ); ?>
                </a>
            </nav>
        </div><!-- /.footer-bottom -->

    </div><!-- /.container -->
</footer><!-- /.site-footer -->

<?php wp_footer(); ?>
</body>
</html>
