<?php
/**
 * Template part for displaying posts.
 *
 * @package PAYMO
 * @version 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if (get_the_title() !== null): ?>
        <h1><strong><?php the_title() ?></strong></h1>
    <?php endif; ?>
    <?php the_content(); ?>
</article>
