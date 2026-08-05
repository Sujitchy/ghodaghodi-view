<?php
if (!has_post_thumbnail()) {
    return;
}
?>
<div class="relative w-full h-[220px] md:h-[300px] lg:h-[380px] overflow-hidden bg-gray-900">
    <?php the_post_thumbnail('full', [
        'class' => 'w-full h-full object-cover object-center',
        'alt'   => esc_attr(get_the_title()),
    ]); ?>
    <div class="absolute inset-0 bg-gradient-to-b from-black/10 via-transparent to-black/30 pointer-events-none" aria-hidden="true"></div>
</div>