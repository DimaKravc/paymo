<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Nobrand
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
        <div>
            <?php get_sidebar(); ?>
        </div>
    </div>
    <section class="primary">
        <div class="primary__inner">
            <div data-ajaxify="top-bar">
                <?php get_search_form(); ?>
                <?php breadcrumbs(); ?>
            </div>
            <div data-ajaxify="content" data-ajaxify-transition>
                <?php while (have_posts()) : the_post();
                    echo '<main class="content">';
                    get_template_part('content', 'page');
                    echo '</main>';

                    $nextPageID = get_post_meta(get_the_ID(), "meta-box-dropdown", true);
                    if ($nextPageID) {
                        echo '<div class="page-nav">';
                        echo '<a href="' . get_permalink($nextPageID) . '">' . get_the_title($nextPageID) . '</a>';
                        echo '</div>';
                    }
                endwhile; ?>
                <?php get_template_part('page', 'footer'); ?>
            </div>
        </div>
        <button class="sidebar-toggle" data-js="sidebar-toggle"></button>
    </section>
</div>
<?php get_footer(); ?>
