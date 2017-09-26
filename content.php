<?php
/**
 * Template part for displaying posts.
 *
 * @package PAYMO
 * @version 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="entry-content">
        <?php if (get_the_title() !== null): ?>
            <h1><strong><?php the_title() ?></strong></h1>
        <?php endif; ?>
        <?php the_content(); ?>
    </div>

</article>
 