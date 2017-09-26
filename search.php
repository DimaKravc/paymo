<?php
/**
 * The template for displaying search results pages.
 *
 * @package PAYMO
 * @version 1.0
 */

?>
<?php get_header(); ?>
<div class="container">
    <div class="sidebar" data-ajaxify="sidebar">
        <?php echo '<a href="' . esc_url(home_url('/')) . '">'; ?>
        <img class="site-logo"
             src="<?php echo get_template_directory_uri() . '/images/logo.svg'; ?>"
             alt="<?php echo get_bloginfo('name'); ?>">
        <?php echo '</a>'; ?>
        <?php get_sidebar(); ?>
    </div>
    <section class="primary">
        <div class="primary__inner">
            <div data-ajaxify="top-bar">
                <?php get_search_form(); ?>
            </div>
            <div data-ajaxify="content" data-ajaxify-transition>
                <?php while (have_posts()) : the_post();
                    echo '<main class="content">';
                    get_template_part('content', 'page');
                    echo '</main>';
                endwhile; ?>
                <?php get_template_part('page', 'footer'); ?>
            </div>
        </div>
        <button class="sidebar-toggle" data-js="sidebar-toggle"></button>
    </section>
</div>
<?php get_footer(); ?>
