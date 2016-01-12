<?php get_header(); ?>

<!-- Author Header -->
<!-- Set your background image for this header on the line below. -->
<header class="intro-header"
        style="background-image: url('<?php echo get_template_directory_uri(); ?>/img/about-bg.jpg')">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <div class="site-heading">
                    <h2><?php echo get_the_author(); ?></h2>
                </div>
            </div>
        </div>
    </div>
</header>

<main role="main">
    <!-- section -->
    <section>

        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <?php if (have_posts()): the_post(); ?>

                        <?php rewind_posts();
                        while (have_posts()) : the_post(); ?>

                            <!-- article -->
                            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                                <div class="post-preview">
                                    <a href="<?php the_permalink(); ?>">
                                        <!-- post title -->
                                        <h2 class="post-title">
                                            <?php the_title(); ?>
                                        </h2>
                                        <!-- /Post title -->

                                        <h3 class="post-subtitle">
                                            <?php clean_blog_wp_excerpt('clean_blog_wp_index'); // Build your custom callback length in functions.php ?>
                                        </h3>
                                    </a>
                                    <p class="post-meta">Posted by <?php the_author_posts_link(); ?>
                                        on <?php the_time('F j, Y'); ?> <?php echo get_post_category() ?></p>
                                    
                                    <p class="post-edit"><?php edit_post_link(); ?></p>
                                </div>
                                <hr>

                            </article>
                            <!-- /article -->

                        <?php endwhile; ?>

                        <!-- Pager -->
                        <ul class="pager">
                            <li class="next">
                                <?php next_posts_link('Older posts &rarr;'); ?>
                            </li>
                            <li class="previous">
                                <?php previous_posts_link('&larr; Newer posts'); ?>
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

                </div>
            </div>
        </div>

        <hr>
        
    </section>
    <!-- /section -->
</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
