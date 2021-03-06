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
                <div class="search-result">
                <?php
                 if (have_posts()) {
                     while (have_posts()) : the_post();
                         get_template_part('content', 'search');
                     endwhile;
                 } else {
                     echo '<h2 class="search-result__not-found-caption">По вашему запросу ничего не найдено!</h2>';
                     echo '<span>Попробуйте изменить поисковую фразу.</span>';
                 }
                ?>
                </div>
                <?php get_template_part('page', 'footer'); ?>
            </div>
        </div>
        <button class="sidebar-toggle" data-js="sidebar-toggle"></button>
    </section>
</div>
<?php get_footer(); ?>
