<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package PAYMO
 * @version 1.0
 */

?>
<?php get_header(); ?>
<div class="container">
    <div class="sidebar" data-ajaxify="sidebar">
        <?php if (!is_front_page()) echo '<a href="' . esc_url(home_url('/')) . '">'; ?>
        <img class="site-logo"
             src="<?php echo get_template_directory_uri() . '/images/logo.svg'; ?>"
             alt="<?php echo get_bloginfo('name'); ?>">
        <?php if (!is_front_page()) echo '</a>'; ?>
        <?php get_sidebar(); ?>
    </div>
    <section class="primary">
        <div class="primary__inner">
            <?php get_search_form(); ?>
            <div class="page-status">
                <div class="page-status__inner">
                    <span class="page-status__code">404</span>
                    <h1 class="page-status__message"><strong>Нет такой страницы</strong></h1>
                    <h3><strong>Вернуться на <a href="<?php echo esc_url(home_url('/')) ?>">главную
                                страницу.</a></strong></h3>
                </div>
            </div>
            <?php get_template_part('page', 'footer'); ?>
        </div>
        <button class="sidebar-toggle" data-js="sidebar-toggle"></button>
    </section>
</div>
<?php get_footer(); ?>
