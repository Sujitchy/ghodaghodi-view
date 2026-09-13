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
                        घोडाघोडी नगरपालिकाको प्राकृतिक सौन्दर्य र सांस्कृतिक सम्पदा पत्ता लगाउनुहोस्। पश्चिम नेपालमा इको-पर्यटन, होमस्टे र अविस्मरणीय अनुभवहरूको लागि तपाईंको प्रवेशद्वार।
                    </p>
                </div>

                <div class="footer-col">
                    <h4 class="footer-heading">द्रुत लिङ्कहरू</h4>
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
                            <li><a href="<?php echo esc_url(home_url('/')); ?>">गृहपृष्ठ</a></li>
                            <li><a href="<?php echo esc_url(home_url('/destination/')); ?>">गन्तव्यहरू</a></li>
                            <li><a href="<?php echo esc_url(home_url('/hotel/')); ?>">होटल तथा होमस्टे</a></li>
                            <li><a href="<?php echo esc_url(home_url('/about-us/')); ?>">हाम्रो बारेमा</a></li>
                            <li><a href="<?php echo esc_url(home_url('/contact/')); ?>">सम्पर्क</a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4 class="footer-heading">सम्पर्क जानकारी</h4>
                    <ul class="footer-contact">
                        <li>
                            <i class="fa-solid fa-location-dot"></i>
                            <span>घोडाघोडी नगरपालिका, कैलाली, नेपाल</span>
                        </li>
                        <li>
                            <i class="fa-solid fa-phone"></i>
                            <a href="tel:+977-01-5XXXXXX">+977-01-5XXXXXX</a>
                        </li>
                        <li>
                            <i class="fa-solid fa-envelope"></i>
                            <a href="mailto:info@ghodaghodinagarpalika.gov.np">info@ghodaghodinagarpalika.gov.np</a>
                        </li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4 class="footer-heading">हामीलाई फलो गर्नुहोस्</h4>
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
                    पर्यटन विकास विभाग। सर्वाधिकार सुरक्षित।
                </p>
                <p class="footer-credit">
                    डिजाइन गरिएको
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
