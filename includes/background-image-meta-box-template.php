<?php
/**
 * Adds a meta box to the post editing screen
 */
function clean_blog_custom_meta() {
    add_meta_box('clean_blog_meta', __('Background Image', 'clean-blog'), 'clean_blog_meta_callback', 'post', 'side', 'high');
}

add_action('add_meta_boxes', 'clean_blog_custom_meta');

/**
 * Outputs the content of the meta box
 */
function clean_blog_meta_callback($post) {
    wp_nonce_field(basename(__FILE__), 'clean_blog_nonce');
    $stored_meta = get_post_meta($post->ID);
    ?>

    <p>
    <?php
    if (isset ($stored_meta['meta-image'])) { ?>
        <img id="post-background-image" width="254" src="<?php echo $stored_meta['meta-image'][0] ?>">
        <a href="#" id="remove-post-background-image" data-postid="<?php echo $post->ID ?>">Remove background image</a>
        <input type="hidden" name="meta-image" id="meta-image"
               value="<?php if (isset ($stored_meta['meta-image'])) echo $stored_meta['meta-image'][0]; ?>"/>
        <input type="button" id="meta-image-button" class="button" style="display: none"
               value="<?php _e('Choose or Upload an Image', 'clean-blog') ?>"/>
    <?php } else { ?>
        <input type="hidden" name="meta-image" id="meta-image"
               value="<?php if (isset ($stored_meta['meta-image'])) echo $stored_meta['meta-image'][0]; ?>"/>
        <input type="button" id="meta-image-button" class="button"
               value="<?php _e('Choose or Upload an Image', 'clean-blog') ?>"/>
        <img id="post-background-image" width="254" src="<?php echo $stored_meta['meta-image'][0] ?>"
             style="display: none">
        <a href="#" id="remove-post-background-image" data-postid="<?php echo $post->ID ?>" style="display: none">Remove
            background image</a>
        </p>

    <?php }
}

/**
 * Loads the image management javascript
 */
function clean_blog_image_enqueue() {
    global $typenow;
    if ($typenow == 'post') {
        wp_enqueue_media();

        // Registers and enqueues the required javascript.
        wp_register_script('meta-box-image', get_template_directory_uri() . '/js/meta-box-image.js', array('jquery'));
        wp_localize_script('meta-box-image', 'meta_image',
            array(
                'title' => __('Choose or Upload an Image', 'clean-blog'),
                'button' => __('Use this image', 'clean-blog'),
                'ajax_url' => admin_url('admin-ajax.php')
            )
        );
        wp_enqueue_script('meta-box-image');
    }
}

add_action('admin_enqueue_scripts', 'clean_blog_image_enqueue');


/**
 * Saves the custom meta input
 */
function clean_blog_meta_save($post_id) {

    // Checks save status
    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);
    $is_valid_nonce = (isset($_POST['clean_blog_nonce']) && wp_verify_nonce($_POST['clean_blog_nonce'], basename(__FILE__))) ? 'true' : 'false';

    // Exits script depending on save status
    if ($is_autosave || $is_revision || !$is_valid_nonce) {
        return;
    }

    // Checks for input and saves if needed
    if (isset($_POST['meta-image'])) {
        update_post_meta($post_id, 'meta-image', $_POST['meta-image']);
    }

}

add_action('save_post', 'clean_blog_meta_save');

/**
 * Ajax call from meta-box-image.js to remove background image in post
 */
add_action('wp_ajax_nopriv_remove_background_image', 'remove_background_image');
add_action('wp_ajax_remove_background_image', 'remove_background_image');

function remove_background_image() {
    delete_post_meta($_POST['post_id'], 'meta-image');
    die();
}