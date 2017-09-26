<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
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
            <div data-ajaxify="content">
                <?php get_template_part('page', 'footer'); ?>
            </div>
        </div>
        <button class="sidebar-toggle" data-js="sidebar-toggle"></button>
    </section>
</div>
<?php get_footer(); ?>
