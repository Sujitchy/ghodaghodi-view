    <footer class="site-footer">
        <div class="container mx-auto px-4">
            <div class="footer-grid">

                <div class="footer-col">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="footer-logo-link">
                        <?php if (has_custom_logo()): ?>
                            <?php the_custom_logo(); ?>
                        <?php else: ?>
                            <span class="footer-logo-text">
                                <i class="fa-solid fa-tree-city"></i>
                                <?php bloginfo('name'); ?>
                            </span>
                        <?php endif; ?>
                    </a>
                    <p class="footer-about-text">
                        <?php _e('Discover the natural beauty and cultural heritage of Ghodaghodi Nagarpalika. Your gateway to eco-tourism, homestays, and unforgettable experiences in western Nepal.', 'ghodaghodi-view'); ?>
                    </p>
                </div>

                <div class="footer-col">
                    <h4 class="footer-heading"><?php _e('Quick Links', 'ghodaghodi-view'); ?></h4>
                    <ul class="footer-links">
                        <?php
                        if (has_nav_menu('footer')) {
                            wp_nav_menu([
                                'theme_location' => 'footer',
                                'container'      => false,
                                'menu_class'     => '',
                                'items_wrap'     => '<ul class="footer-links">%3$s</ul>',
                                'walker'         => new Ghodaghodi_Footer_Walker(),
                                'fallback_cb'    => false,
                                'depth'          => 1,
                            ]);
                        } else {
                            ?>
                            <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php _e('Home', 'ghodaghodi-view'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/destination/')); ?>"><?php _e('Destinations', 'ghodaghodi-view'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/hotel/')); ?>"><?php _e('Hotels & Homestays', 'ghodaghodi-view'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/about-us/')); ?>"><?php _e('About Us', 'ghodaghodi-view'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/contact/')); ?>"><?php _e('Contact', 'ghodaghodi-view'); ?></a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4 class="footer-heading"><?php _e('Contact Info', 'ghodaghodi-view'); ?></h4>
                    <ul class="footer-contact">
                        <li>
                            <i class="fa-solid fa-location-dot"></i>
                            <span><?php _e('Ghodaghodi Nagarpalika, Kailali, Nepal', 'ghodaghodi-view'); ?></span>
                        </li>
                        <li>
                            <i class="fa-solid fa-phone"></i>
                            <a href="tel:+977-01-5XXXXXX"><?php _e('+977-01-5XXXXXX', 'ghodaghodi-view'); ?></a>
                        </li>
                        <li>
                            <i class="fa-solid fa-envelope"></i>
                            <a href="mailto:info@ghodaghodinagarpalika.gov.np">info@ghodaghodinagarpalika.gov.np</a>
                        </li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4 class="footer-heading"><?php _e('Follow Us', 'ghodaghodi-view'); ?></h4>
                    <div class="footer-social">
                        <a href="#" target="_blank" rel="noopener" aria-label="Facebook">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                        <a href="#" target="_blank" rel="noopener" aria-label="Instagram">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="#" target="_blank" rel="noopener" aria-label="YouTube">
                            <i class="fa-brands fa-youtube"></i>
                        </a>
                        <a href="#" target="_blank" rel="noopener" aria-label="Twitter">
                            <i class="fa-brands fa-x-twitter"></i>
                        </a>
                        <a href="#" target="_blank" rel="noopener" aria-label="Medium">
                            <i class="fa-brands fa-medium"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <div class="footer-bottom">
            <div class="container mx-auto px-4 footer-bottom-inner">
                <p>
                    &copy; <?php echo date('Y'); ?>
                    <?php bloginfo('name'); ?> &mdash;
                    <?php _e('Tourism Development Department. All rights reserved.', 'ghodaghodi-view'); ?>
                </p>
                <p class="footer-credit">
                    <?php _e('Developed by', 'ghodaghodi-view'); ?>
                    <a href="https://www.mohrain.com" target="_blank" rel="noopener">Mohrain</a>
                </p>
            </div>
        </div>

        <button id="back-to-top" class="back-to-top" aria-label="Back to top">
            <i class="fa-solid fa-chevron-up"></i>
        </button>
    </footer>

    <?php wp_footer(); ?>
</body>
</html>
