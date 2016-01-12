<?php get_header(); ?>

<main role="main">
    <!-- section -->
    <section>

        <!-- article -->
        <article id="post-404">

            <!-- Page Header -->
            <!-- Set your background image for this header on the line below. -->
            <header class="intro-header"
                    style="background-image: url('<?php echo get_template_directory_uri(); ?>/img/contact-bg.jpg')">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                            <div class="page-heading">
                                <h1><?php _e('Page not found', 'clean-blog'); ?></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                        <h2>
                            <a href="<?php echo home_url(); ?>"><?php _e('Return home?', 'clean-blog'); ?></a>
                        </h2>
                    </div>
                </div>
            </div>

        </article>
        <!-- /article -->

        <hr>
        
    </section>
    <!-- /section -->
</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
