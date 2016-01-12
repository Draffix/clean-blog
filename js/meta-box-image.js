/*
 * Attaches the image uploader to the input field
 */
jQuery(document).ready(function ($) {

    // Instantiates the variable that holds the media library frame.
    var meta_image_frame;

    // Runs when the image button is clicked.
    $('#meta-image-button').click(function (e) {

        // Prevents the default action from occuring.
        e.preventDefault();

        // If the frame already exists, re-open it.
        if (meta_image_frame) {
            meta_image_frame.open();
            return;
        }

        // Sets up the media library frame
        meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
            title: meta_image.title,
            button: {text: meta_image.button},
            library: {type: 'image'}
        });

        // Runs when an image is selected.
        meta_image_frame.on('select', function () {

            // Grabs the attachment selection and creates a JSON representation of the model.
            var media_attachment = meta_image_frame.state().get('selection').first().toJSON();

            // Sends the attachment URL to our custom image input field.
            $('#meta-image').val(media_attachment.url);
            
            // display/hide fields 
            $('#post-background-image').attr('src', media_attachment.url);
            $('#post-background-image').css('display', 'block');
            $('#remove-post-background-image').css('display', 'block');
            $('#meta-image-button').css('display', 'none');
        });

        // Opens the media library frame.
        meta_image_frame.open();
    });

    // Runs when link to delete image is clicked.
    $('#remove-post-background-image').click(function (e) {
        var post_id = $(this).attr('data-postid');
        jQuery.ajax({
            url: meta_image.ajax_url,
            type: 'post',
            data: {
                action: 'remove_background_image',
                post_id: post_id
            },
            success: function (response) {
                
                // display/hide fields 
                $('#post-background-image').css('display', 'none');
                $('#remove-post-background-image').css('display', 'none');
                $('#meta-image').css('display', 'block');
                $('#meta-image').val('');
                $('#meta-image-button').css('display', 'block');
            }
        });
    });
});