<?php
/**
 * Theme settings page
 */
function theme_settings_page() {
    ?>
    <div class="wrap">
        <h1>Theme Panel</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields("section");
            do_settings_sections("theme-options");
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// theme menu register
function add_theme_menu_item() {
    add_menu_page("Theme Panel", "Theme Panel", "manage_options", "theme-panel", "theme_settings_page", null, 99);
}

add_action("admin_menu", "add_theme_menu_item");

// twitter account
function display_twitter() {
    ?>
    <input type="checkbox" name="display_twitter" value="1" <?php checked(1, get_option('display_twitter'), true); ?>"/>
    <?php
}

function twitter_url() {
    ?>
    <input type="text" name="twitter_url" id="twitter_url" value="<?php echo get_option('twitter_url'); ?>"/>
    <?php
}

// facebook account
function display_facebook() {
    ?>
    <input type="checkbox" name="display_facebook"
           value="1" <?php checked(1, get_option('display_facebook'), true); ?>"/>
    <?php
}

function facebook_url() {
    ?>
    <input type="text" name="facebook_url" id="facebook_url" value="<?php echo get_option('facebook_url'); ?>"/>
    <?php
}

// google account
function display_google() {
    ?>
    <input type="checkbox" name="display_google" value="1" <?php checked(1, get_option('display_google'), true); ?>"/>
    <?php
}

function google_url() {
    ?>
    <input type="text" name="google_url" id="google_url" value="<?php echo get_option('google_url'); ?>"/>
    <?php
}

// linkedin account
function display_linkedin() {
    ?>
    <input type="checkbox" name="display_linkedin"
           value="1" <?php checked(1, get_option('display_linkedin'), true); ?>"/>
    <?php
}

function linkedin_url() {
    ?>
    <input type="text" name="linkedin_url" id="linkedin_url" value="<?php echo get_option('linkedin_url'); ?>"/>
    <?php
}

// github account
function display_github() {
    ?>
    <input type="checkbox" name="display_github" value="1" <?php checked(1, get_option('display_github'), true); ?>"/>
    <?php
}

function github_url() {
    ?>
    <input type="text" name="github_url" id="github_url" value="<?php echo get_option('github_url'); ?>"/>
    <?php
}

function footer_info() {
    ?>
    <input type="text" size="30" name="footer_info" id="footer_info" value="<?php echo get_option('footer_info'); ?>"/>
    <?php
}

// Display theme panel fields
function display_theme_panel_fields() {
    add_settings_section("section", "Profile Settings", null, "theme-options");

    add_settings_field("display_twitter", "Display Twitter Profile", "display_twitter", "theme-options", "section");
    add_settings_field("twitter_url", "Twitter Profile Url", "twitter_url", "theme-options", "section");

    add_settings_field("display_facebook", "Display Facebook Profile", "display_facebook", "theme-options", "section");
    add_settings_field("facebook_url", "Facebook Profile Url", "facebook_url", "theme-options", "section");

    add_settings_field("display_google", "Display Google Profile", "display_google", "theme-options", "section");
    add_settings_field("google_url", "Google Profile Url", "google_url", "theme-options", "section");

    add_settings_field("display_linkedin", "Display LinkedIn Profile", "display_linkedin", "theme-options", "section");
    add_settings_field("linkedin_url", "LinkedIn Profile Url", "linkedin_url", "theme-options", "section");

    add_settings_field("display_github", "Display GitHub Profile", "display_github", "theme-options", "section");
    add_settings_field("github_url", "GitHub Profile Url", "github_url", "theme-options", "section");

    register_setting("section", "twitter_url");
    register_setting("section", "facebook_url");
    register_setting("section", "google_url");
    register_setting("section", "linkedin_url");
    register_setting("section", "github_url");

    register_setting("section", "display_twitter");
    register_setting("section", "display_facebook");
    register_setting("section", "display_google");
    register_setting("section", "display_linkedin");
    register_setting("section", "display_github");

    add_settings_field("footer_info", "Footer info", "footer_info", "theme-options", "section");
    register_setting("section", "footer_info");
}

add_action("admin_init", "display_theme_panel_fields");

// helper to render footer icons regarding options
function render_footer_icons() {
    if (get_option('display_twitter')) {
        echo '<li>
            <a href="' . get_option('twitter_url') . '" data-toggle="tooltip" title data-original-title="Twitter" target="_blank">
                <span class="fa-stack fa-lg">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
                </span>
            </a>
        </li>';
    }

    if (get_option('display_facebook')) {
        echo '<li>
            <a href="' . get_option('facebook_url') . '" data-toggle="tooltip" title data-original-title="Facebook" target="_blank">
                <span class="fa-stack fa-lg">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
                </span>
            </a>
        </li>';
    }

    if (get_option('display_google')) {
        echo '<li>
            <a href="' . get_option('google_url') . '" data-toggle="tooltip" title data-original-title="Google+" target="_blank">
                <span class="fa-stack fa-lg">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa fa-google-plus fa-stack-1x fa-inverse"></i>
                </span>
            </a>
        </li>';
    }

    if (get_option('display_linkedin')) {
        echo '<li>
            <a href="' . get_option('linkedin_url') . '" data-toggle="tooltip" title data-original-title="LinkedIn" target="_blank">
                <span class="fa-stack fa-lg">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa fa-linkedin fa-stack-1x fa-inverse"></i>
                </span>
            </a>
        </li>';
    }

    if (get_option('display_github')) {
        echo '<li>
            <a href="' . get_option('github_url') . '" data-toggle="tooltip" title data-original-title="GitHub" target="_blank">
                <span class="fa-stack fa-lg">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa fa-github fa-stack-1x fa-inverse"></i>
                </span>
            </a>
        </li>';
    }
}

// helper to render footer info regarding options
function render_footer_info() {
    if (get_option('footer_info')) {
        echo get_option('footer_info');
    } else {
        echo 'Copyright &copy; Your Website ' . date("Y");
    }
}