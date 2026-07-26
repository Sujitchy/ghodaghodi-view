<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class('font-mukta bg-gray-50 text-gray-800'); ?>>

<?php wp_body_open(); ?>

<header id="header" class="site-header text-white">
    <div class="container mx-auto px-4 flex justify-between items-center">
        <div class="flex items-center space-x-3">
            <?php if (has_custom_logo()): ?>
                <?php the_custom_logo(); ?>
            <?php else: ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
                    <i class="fa-solid fa-tree-city text-amber-400"></i>
                    <span><?php bloginfo('name'); ?></span>
                </a>
            <?php endif; ?>
        </div>

        <button id="mobile-menu-toggle" class="md:hidden text-white focus:outline-none" aria-label="Toggle menu">
            <i class="fa-solid fa-bars text-2xl"></i>
        </button>

        <nav id="mobile-menu" class="hidden md:flex md:space-x-6 text-sm font-semibold absolute md:relative top-full left-0 w-full md:w-auto bg-emerald-900 md:bg-transparent px-4 md:px-0 pb-4 md:pb-0 shadow-md md:shadow-none">
            <?php
            if (has_nav_menu('primary')) {
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'flex flex-col md:flex-row md:space-x-6',
                    'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    'walker'         => new Ghodaghodi_Walker_Nav(),
                    'fallback_cb'    => false,
                    'depth'          => 2,
                ]);
            } else {
                ?>
<ul class="flex flex-col md:flex-row md:space-x-6">
                    <li><a href="#dashboard" class="block py-2 md:py-0 hover:text-[#FFD700] transition">ड्यासबोर्ड</a></li>
                    <li><a href="#destinations" class="block py-2 md:py-0 hover:text-[#FFD700] transition">गन्तव्यहरू</a></li>
                    <li><a href="#hotels" class="block py-2 md:py-0 hover:text-[#FFD700] transition">होटल तथा होमस्टे</a></li>
                    <li><a href="#qr-section" class="block py-2 md:py-0 hover:text-[#FFD700] transition">डिजिटल क्युआर</a></li>
                </ul>
                <?php
            }
            ?>
        </nav>
    </div>
</header>
