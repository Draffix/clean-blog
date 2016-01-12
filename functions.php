<?php
/*
 *  Author: Todd Motto | @toddmotto
 *  URL: html5blank.com | @html5blank
 *  Custom functions, support, custom post types and more.
 */

/*------------------------------------*\
	External Modules/Files
\*------------------------------------*/

//Initialize the update checker.
require 'theme-updates/theme-update-checker.php';
$example_update_checker = new ThemeUpdateChecker(
    'clean-blog',
    'https://github.com/Draffix/clean-blog/blob/master/info.json'
);

/*------------------------------------*\
	Theme Support
\*------------------------------------*/

if (!isset($content_width)) {
    $content_width = 900;
}

if (function_exists('add_theme_support')) {
    // Add Menu Support
    add_theme_support('menus');

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');
    add_image_size('large', 700, '', true); // Large Thumbnail
    add_image_size('medium', 250, '', true); // Medium Thumbnail
    add_image_size('small', 120, '', true); // Small Thumbnail
    add_image_size('custom-size', 700, 200, true); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');

    // Enables post and comment RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Localisation Support
    load_theme_textdomain('clean-blog', get_template_directory() . '/languages');
}

/*------------------------------------*\
	Functions
\*------------------------------------*/

// Clean-blog navigation
function clean_blog_nav() {
    wp_nav_menu(
        array(
            'theme_location' => 'header-menu',
            'menu' => '',
            'container' => 'div',
            'container_class' => 'menu-{menu slug}-container',
            'container_id' => '',
            'menu_class' => 'menu',
            'menu_id' => '',
            'echo' => true,
            'fallback_cb' => 'wp_page_menu',
            'before' => '',
            'after' => '',
            'link_before' => '',
            'link_after' => '',
            'items_wrap' => '<ul>%3$s</ul>',
            'depth' => 0,
            'walker' => ''
        )
    );
}

// Load Clean-blog scripts (header.php)
function clean_blog_header_scripts() {

    wp_register_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'));
    wp_enqueue_script('bootstrap'); // Enqueue it!

    wp_register_script('clean-blog', get_template_directory_uri() . '/js/clean-blog.js', array('jquery'));
    wp_enqueue_script('clean-blog'); // Enqueue it!

}

// Load Clean-blog styles
function clean_blog_styles() {
    wp_register_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '1.0', 'all');
    wp_enqueue_style('bootstrap'); // Enqueue it!

    wp_register_style('clean-blog', get_template_directory_uri() . '/css/clean-blog.min.css', array(), '1.0', 'all');
    wp_enqueue_style('clean-blog'); // Enqueue it!
}

// Register blog Navigation
function register_blog_menu() {
    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('Header Menu', 'clean-blog'), // Main Navigation
    ));
}

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = '') {
    $args['container'] = false;
    return $args;
}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter($var) {
    return is_array($var) ? array() : '';
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist) {
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes) {
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}

// If Dynamic Sidebar Exists
if (function_exists('register_sidebar')) {
    // Define Sidebar Widget Area 1
    register_sidebar(array(
        'name' => __('Widget Area 1', 'clean-blog'),
        'description' => __('Description for this widget-area...', 'clean-blog'),
        'id' => 'widget-area-1',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

    // Define Sidebar Widget Area 2
    register_sidebar(array(
        'name' => __('Widget Area 2', 'clean-blog'),
        'description' => __('Description for this widget-area...', 'clean-blog'),
        'id' => 'widget-area-2',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
}

// Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style() {
    global $wp_widget_factory;
    remove_action('wp_head', array(
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style'
    ));
}

// Custom Excerpts
function clean_blog_wp_index($length) // Create 20 Word Callback for Index page Excerpts, call using clean_blog_wp_excerpt('clean_blog_wp_index');
{
    return 20;
}

// Create 40 Word Callback for Custom Post Excerpts, call using clean_blog_wp_excerpt('clean_blog_wp_custom_post');
function clean_blog_wp_custom_post($length) {
    return 40;
}

// Create the Custom Excerpts callback
function clean_blog_wp_excerpt($length_callback = '', $more_callback = '') {
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}

// Custom View Article link to Post
function clean_blog_view_article($more) {
    global $post;
    return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . __('View Article', 'clean-blog') . '</a>';
}

// Remove Admin bar
function remove_admin_bar() {
    return false;
}

// Remove 'text/css' from our enqueued stylesheet
function clean_blog_style_remove($tag) {
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions($html) {
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}

// Custom Gravatar in Settings > Discussion
function clean_blog_gravatar($avatar_defaults) {
    $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
}

// Threaded Comments
function enable_threaded_comments() {
    if (!is_admin()) {
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply');
        }
    }
}

// Custom Comments Callback
function cleanblogcomments($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    extract($args, EXTR_SKIP);

    if ('div' == $args['style']) {
        $tag = 'div';
        $add_below = 'comment';
    } else {
        $tag = 'li';
        $add_below = 'div-comment';
    }
    ?>
    <!-- heads up: starting < for the html tag (li or div) in the next line: -->
    <<?php echo $tag ?><?php comment_class(empty($args['has_children']) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
    <?php if ('div' != $args['style']) : ?>
        <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
    <?php endif; ?>
    <div class="comment-author vcard">
        <?php if ($args['avatar_size'] != 0) echo get_avatar($comment, $args['180']); ?>
        <?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
    </div>
    <?php if ($comment->comment_approved == '0') : ?>
        <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
        <br/>
    <?php endif; ?>

    <div class="comment-meta commentmetadata"><a
            href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)) ?>">
            <?php
            printf(__('%1$s at %2$s'), get_comment_date(), get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'), '  ', '');
        ?>
    </div>

    <?php comment_text() ?>

    <div class="reply">
        <?php comment_reply_link(array_merge($args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </div>
    <?php if ('div' != $args['style']) : ?>
        </div>
    <?php endif; ?>
<?php }

// Header menu name for header navigation
function header_menu_name() {
    $menu_name = 'header-menu';
    $locations = get_nav_menu_locations();
    $menu_id = $locations[$menu_name];
    $menu = wp_get_nav_menu_object($menu_id);
    echo $menu->name;
}

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array $size Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function clean_blog_content_image_sizes_attr($sizes, $size) {
    $width = $size[0];
    840 <= $width && $sizes = '(max-width: 709px) 150px, (max-width: 909px) 700px, (max-width: 1362px) 62vw, 840px';
    if ('page' === get_post_type()) {
        840 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
    } else {
        840 > $width && 600 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 61vw, (max-width: 1362px) 45vw, 600px';
        600 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
    }
    return $sizes;
}

/**
 * Add custom image sizes attribute to enhance responsive image functionality for post thumbnails
 *
 * @param array $attr Attributes for the image markup.
 * @param int $attachment Image attachment ID.
 * @param array $size Registered image size or flat array of height and width dimensions.
 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
 */
function clean_blog_post_thumbnail_sizes_attr($attr, $attachment, $size) {
    if ('post-thumbnail' === $size) {
        is_active_sidebar('sidebar-1') && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 60vw, (max-width: 1362px) 62vw, 840px';
        !is_active_sidebar('sidebar-1') && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 88vw, 1200px';
    }
    return $attr;
}

// Add custom class to all images
function add_custom_class_to_all_images($content) {
    /* Filter by Qassim Hassan - http://wp-time.com */
    $my_custom_class = "img-responsive"; // your custom class
    $add_class = str_replace('<img class="', '<img class="' . $my_custom_class . ' ', $content); // add class
    return $add_class; // display class to image
}


// Remove width and height dynamic attributes to post images
function fixed_img_caption_shortcode($attr, $content = null) {
    if (!isset($attr['caption'])) {
        if (preg_match('#((?:<a [^>]+>\s*)?<img [^>]+>(?:\s*</a>)?)(.*)#is', $content, $matches)) {
            $content = $matches[1];
            $attr['caption'] = trim($matches[2]);
        }
    }
    $output = apply_filters('img_caption_shortcode', '', $attr, $content);
    if ($output != '')
        return $output;
    extract(shortcode_atts(array(
        'id' => '',
        'align' => 'alignnone',
        'width' => '',
        'caption' => ''
    ), $attr));
    if (1 > (int)$width || empty($caption))
        return $content;
    if ($id) $id = 'id="' . esc_attr($id) . '" ';
    return '<div ' . $id . 'class="wp-caption ' . esc_attr($align) . '" >'
    . do_shortcode($content) . '<p class="wp-caption-text">' . $caption . '</p></div>';
}


/**
 * Filter the array of categories to return for a post.
 *
 * @since 4.4.0 Added `$id` parameter.
 * @param bool|int $id ID of the post.
 * @return mixed|void
 */
function get_post_category($id = false) {
    $categories = get_the_terms($id, 'category');
    if (!$categories || is_wp_error($categories))
        $categories = array();

    $categories = array_values($categories);

    foreach (array_keys($categories) as $key) {
        _make_cat_compat($categories[$key]);
    }

    $category_print = '';
    if ($categories) {
        $category_print = _e('in', 'clean-blog');
        foreach ($categories as $category) {
            $category_link = get_category_link($category->cat_ID); // Get the URL of this category
            $category_name = $category->name;
            $category_print .= ' <a href="' . $category_link . '" title="' . $category_name . '">' . $category_name . '</a>,';
        }

        $category_print = rtrim($category_print, ','); // remove last comma from string
    }

    return $category_print;
}

/**
 * Filter the array of tags to return for a post.
 *
 * @since 4.4.0 Added `$id` parameter.
 * @param bool|int $id ID of the post.
 * @return mixed|void
 */
function get_post_tag() {
    $posttags = get_the_tags();
    $tag_print = '';
    if ($posttags) {

        $tag_print = '<br><p class="post-meta">' . _e('Tags: ');
        foreach ($posttags as $tag) {
            $tag_link = get_tag_link($tag->term_id); // Get the URL of this tag
            $tag_name = $tag->name;
            $tag_print .= '<a href="' . $tag_link . '" title="' . $tag_name . '">' . $tag_name . '</a>,';
        }

        $tag_print = rtrim($tag_print, ','); // remove last comma from string
        $tag_print .= '</p>';
    }

    return $tag_print;
}

/**
 * Return post background image source from post meta
 * If not exist then default background image
 * @param $post_id
 */
function get_post_background_image_src($post_id) {
    $meta = get_post_meta($post_id, 'meta-image');
    if($meta[0]) {
        echo $meta[0];
    } else {
        echo get_template_directory_uri() . '/img/post-bg.jpg';
    }
}

/*------------------------------------*\
	Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_action('init', 'clean_blog_header_scripts'); // Add Custom Scripts to wp_head
add_action('get_header', 'enable_threaded_comments'); // Enable Threaded Comments
add_action('wp_enqueue_scripts', 'clean_blog_styles'); // Add Theme Stylesheet
add_action('init', 'register_blog_menu'); // Add Clean-blog Menu
add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()

// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Add Filters
add_filter('avatar_defaults', 'clean_blog_gravatar'); // Custom Gravatar in Settings > Discussion
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
// add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected classes (Commented out by default)
// add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected ID (Commented out by default)
// add_filter('page_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('excerpt_more', 'clean_blog_view_article'); // Add 'View Article' button instead of [...] for Excerpts
add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
add_filter('style_loader_tag', 'clean_blog_style_remove'); // Remove 'text/css' from enqueued stylesheet
//add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
//add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images
add_filter('wp_calculate_image_sizes', 'clean_blog_content_image_sizes_attr', 10, 2); // Add custom image sizes attribute to enhance responsive image functionality
add_filter('wp_get_attachment_image_attributes', 'clean_blog_post_thumbnail_sizes_attr', 10, 3); // Add custom image sizes attribute to enhance responsive image functionality for post thumbnails
add_filter('the_content', 'add_custom_class_to_all_images'); // Add custom class to all images


// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

// Add shortcodes
add_shortcode('wp_caption', 'fixed_img_caption_shortcode'); // Remove width and height dynamic attributes to post images
add_shortcode('caption', 'fixed_img_caption_shortcode'); // Remove width and height dynamic attributes to post images
    
// Included functions to split up
require_once('includes/background-image-meta-box-template.php');
require_once('includes/theme-settings-page.php');