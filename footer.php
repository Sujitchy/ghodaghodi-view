    <footer class="bg-gray-900 text-gray-400 text-xs py-8 border-t border-gray-800 text-center">
        <div class="container mx-auto px-4">
            <p class="mb-2">
                &copy; <?php echo date('Y'); ?>
                <?php bloginfo('name'); ?> -
                <?php _e('Tourism Development Department. All rights reserved.', 'ghodaghodi-view'); ?>
            </p>
            <p>
                <?php _e('Developed by:', 'ghodaghodi-view'); ?>
                <span class="text-amber-400"><a href="https://www.mohrain.com" target="_blank">Mohrain</a></span>
            </p>
        </div>
    </footer>

    <?php wp_footer(); ?>
</body>
</html>
