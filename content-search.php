<?php
/**
 * Template part for displaying search results.
 *
 * @package PAYMO
 * @version 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('search-result__item'); ?> data-search="item">
    <?php if (get_the_title() !== null): ?>
        <h2><strong><a href="<?php echo get_permalink(); ?>"><?php the_title() ?></a></strong></h2>
    <?php endif; ?>
    <?php echo wp_trim_words(get_the_content(), 45) ?>
</article>
