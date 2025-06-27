<?php
/**
 * The template for displaying the footer
 *
 * @package DevLite
 * @version 1.0
 */
?>
    </div><!-- #content -->
    <footer id="colophon" class="site-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-info">
                    <p>
                        <?php
                        printf(
                            esc_html__('&copy; %1$s %2$s. Built with %3$s theme.', 'devlite'),
                            esc_html(date('Y')),
                            '<a href="' . esc_url(home_url('/')) . '">' . esc_html(get_bloginfo('name')) . '</a>',
                            '<strong>DevLite</strong>'
                        );
                        ?>
                    </p>
                </div>
                
                <?php if (has_nav_menu('footer')) : ?>
                    <nav class="footer-navigation" role="navigation" aria-label="<?php esc_attr_e('Footer Menu', 'devlite'); ?>">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'footer',
                            'menu_class'     => 'footer-menu',
                            'container'      => false,
                            'depth'          => 1,
                            'fallback_cb'    => false,
                        ));
                        ?>
                    </nav>
                <?php endif; ?>
            </div><!-- .footer-content -->
        </div><!-- .container -->
    </footer><!-- #colophon -->
    
    <?php wp_footer(); ?>
</div><!-- #page -->
</body>
</html>