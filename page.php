<?php get_header(); ?>

<main role="main">
    <!-- section -->
    <section>

        <?php if (have_posts()): while (have_posts()) : the_post(); ?>

            <!-- article -->
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <!-- Page Header -->
                <!-- Set your background image for this header on the line below. -->
                <header class="intro-header"
                        style="background-image: url('<?php echo get_template_directory_uri(); ?>/img/post-bg.jpg')">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                                <div class="post-heading">
                                    <h1><?php the_title(); ?></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                            <!-- post thumbnail -->
                            <?php if (has_post_thumbnail()) : // Check if Thumbnail exists ?>
                                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                    <?php the_post_thumbnail(); // Fullsize image for the single post ?>
                                </a>
                            <?php endif; ?>
                            <!-- /post thumbnail -->

                            <?php the_content(); // Dynamic Content ?>

                            <?php edit_post_link(); // Always handy to have Edit Post Links available ?>

                            <?php comments_template(); ?>

                        </div>
                    </div>
                </div>

            </article>
            <!-- /article -->

        <?php endwhile; ?>

        <?php else: ?>

            <!-- article -->
            <article>

                <h1><?php _e('Sorry, nothing to display.', 'clean-blog'); ?></h1>

            </article>
            <!-- /article -->

        <?php endif; ?>

        <hr>

    </section>
    <!-- /section -->
</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
