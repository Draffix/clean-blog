<?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; ?>
<?php if (have_posts()): while (have_posts()) : the_post(); ?>

    <!-- article -->
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <div class="post-preview">
            <a href="<?php the_permalink(); ?>">
                <h2 class="post-title">
                    <?php the_title(); ?>
                </h2>
                <h3 class="post-subtitle">
                    <?php clean_blog_wp_excerpt('clean_blog_wp_index'); // Build your custom callback length in functions.php ?>
                </h3>
            </a>
            <p class="post-meta"><?php _e('Published by', 'clean-blog'); ?> <?php the_author_posts_link(); ?> <?php _e('on', 'clean-blog'); ?> <?php the_time(get_option('date_format')); ?> <?php echo get_post_category() ?></p>

            <?php //echo get_post_tag() ?>

            <p class="post-edit"><?php edit_post_link(); ?></p>
        </div>
        <hr>

    </article>
    <!-- /article -->

<?php endwhile; ?>

    <!-- Pager -->
    <ul class="pager">
        <li class="next">
            <?php next_posts_link(__('older posts', 'clean-blog') . ' &rarr;'); ?>
        </li>
        <li class="previous">
            <?php previous_posts_link('&larr; ' . __('newer posts', 'clean-blog')); ?>
        </li>
    </ul>

<?php else: ?>

    <!-- article -->
    <article>
        <div class="post-preview">
            <h2 class="post-title">
                <?php _e('Sorry, nothing to display.', 'clean-blog'); ?>
            </h2>
        </div>
    </article>
    <!-- /article -->

<?php endif; ?>
