<?php
/**
 * New Kid Theme Functions
 * NeoBrutalism WordPress Block Theme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register custom block styles for NeoBrutalism
 */
function new_kid_register_block_styles() {
    
    // NeoBrutalist styles for Groups
    register_block_style(
        'core/group',
        array(
            'name'  => 'highlight',
            'label' => 'Highlight',
        )
    );
    
    register_block_style(
        'core/group',
        array(
            'name'  => 'alert',
            'label' => 'Alert',
        )
    );
    
    register_block_style(
        'core/group',
        array(
            'name'  => 'success',
            'label' => 'Success',
        )
    );
    
    // Apply same styles to Columns
    register_block_style(
        'core/columns',
        array(
            'name'  => 'highlight',
            'label' => 'Highlight',
        )
    );
    
    register_block_style(
        'core/columns',
        array(
            'name'  => 'alert',
            'label' => 'Alert',
        )
    );
    
    register_block_style(
        'core/columns',
        array(
            'name'  => 'success',
            'label' => 'Success',
        )
    );
    
    // Apply same styles to individual Columns
    register_block_style(
        'core/column',
        array(
            'name'  => 'highlight',
            'label' => 'Highlight',
        )
    );
    
    register_block_style(
        'core/column',
        array(
            'name'  => 'alert',
            'label' => 'Alert',
        )
    );
    
    register_block_style(
        'core/column',
        array(
            'name'  => 'success',
            'label' => 'Success',
        )
    );
    
    // Apply to many more block types
    $all_blocks = array(
        'core/paragraph', 
        'core/heading', 
        'core/quote', 
        'core/image', 
        'core/button',
        'core/navigation',
        'core/list',
        'core/cover',
        'core/media-text',
        'core/gallery',
        'core/table',
        'core/code',
        'core/preformatted',
        'core/verse',
        'core/pullquote',
        'core/separator',
        'core/spacer',
        'core/embed',
        'core/video',
        'core/audio',
        'core/file',
        'core/calendar',
        'core/search',
        'core/social-links',
        'core/tag-cloud',
        'core/categories',
        'core/archives',
        'core/latest-posts',
        'core/latest-comments',
        'core/rss'
    );
    
    $styles = array(
        array('name' => 'highlight', 'label' => 'Highlight'),
        array('name' => 'alert', 'label' => 'Alert'),
        array('name' => 'success', 'label' => 'Success')
    );
    
    foreach ($all_blocks as $block) {
        foreach ($styles as $style) {
            register_block_style($block, $style);
        }
    }
}
add_action('init', 'new_kid_register_block_styles');

/**
 * Enqueue NeoBrutalismCSS Google Fonts
 */
function new_kid_enqueue_fonts() {
    // Enqueue NeoBrutalismCSS recommended Google Fonts
    wp_enqueue_style(
        'neo-brutalism-fonts',
        'https://fonts.googleapis.com/css2?family=Stint+Ultra+Expanded:wght@400&family=Lexend+Mega:wght@400;700;900&family=Proza+Libre:wght@400;600;700&family=Public+Sans:wght@400;600;700;900&display=swap',
        array(),
        date('YmdHis') // Cache bust with current timestamp for external fonts
    );
}
add_action('wp_enqueue_scripts', 'new_kid_enqueue_fonts');
add_action('enqueue_block_editor_assets', 'new_kid_enqueue_fonts');

/**
 * Add theme support for various features
 */
function new_kid_theme_support() {
    // Add support for block styles
    add_theme_support('wp-block-styles');
    
    // Add support for full and wide align images
    add_theme_support('align-wide');
    
    // Add support for editor styles
    add_theme_support('editor-styles');
    
    // Add support for responsive embedded content
    add_theme_support('responsive-embeds');
    
    // Add support for custom line height
    add_theme_support('custom-line-height');
    
    // Add support for custom units
    add_theme_support('custom-units');
    
    // Add support for custom spacing
    add_theme_support('custom-spacing');
    
    // Add accessibility features
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'script',
        'style'
    ));
    
    // Add support for title tag
    add_theme_support('title-tag');
    
    // Add support for post thumbnails
    add_theme_support('post-thumbnails');
    
    // Add support for automatic feed links
    add_theme_support('automatic-feed-links');
    
    // Add support for navigation menus
    add_theme_support('menus');
    
    // Register navigation menu locations
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'new-kid'),
    ));
    
    // Make theme available for translation
    load_theme_textdomain('new-kid', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'new_kid_theme_support');

/**
 * Create default navigation menu on theme activation
 */
function new_kid_create_default_menu() {
    // Check if a menu already exists
    $menu_exists = wp_get_nav_menu_object('Primary Menu');
    
    if (!$menu_exists) {
        // Create the menu
        $menu_id = wp_create_nav_menu('Primary Menu');
        
        // Add default menu items
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('Home', 'new-kid'),
            'menu-item-url' => home_url('/'),
            'menu-item-status' => 'publish'
        ));
        
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('About', 'new-kid'),
            'menu-item-url' => home_url('/about/'),
            'menu-item-status' => 'publish'
        ));
        
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('Blog', 'new-kid'),
            'menu-item-url' => home_url('/blog/'),
            'menu-item-status' => 'publish'
        ));
        
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('Contact', 'new-kid'),
            'menu-item-url' => home_url('/contact/'),
            'menu-item-status' => 'publish'
        ));
        
        // Assign the menu to the primary location
        $locations = get_theme_mod('nav_menu_locations');
        $locations['primary'] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);
    }
}
add_action('after_switch_theme', 'new_kid_create_default_menu');


/**
 * Add accessibility improvements to WordPress
 */
function new_kid_accessibility_improvements() {
    // Add skip link to admin bar
    if (is_admin_bar_showing()) {
        echo '<style>
            #wpadminbar { 
                position: fixed !important; 
            }
            .skip-link { 
                z-index: 999999; 
            }
        </style>';
    }
}
add_action('wp_head', 'new_kid_accessibility_improvements');

/**
 * Register block patterns for translatable content
 */
function new_kid_register_block_patterns() {
    
    // 404 Error Heading Pattern
    register_block_pattern(
        'new-kid/404-heading',
        array(
            'title'       => __('404 Error Heading', 'new-kid'),
            'description' => __('Large 404 error message with NeoBrutalism styling', 'new-kid'),
            'categories'  => array('text'),
            'content'     => '<!-- wp:group {"className":"is-style-alert","layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-alert">
<!-- wp:heading {"textAlign":"center","level":1,"fontSize":"huge"} -->
<h1 class="wp-block-heading has-text-align-center has-huge-font-size">404</h1>
<!-- /wp:heading -->

<!-- wp:heading {"textAlign":"center","level":2,"fontSize":"large"} -->
<h2 class="wp-block-heading has-text-align-center has-large-font-size">' . esc_html__('PAGE NOT FOUND!', 'new-kid') . '</h2>
<!-- /wp:heading -->
</div>
<!-- /wp:group -->'
        )
    );
    
    // Navigation Buttons Pattern
    register_block_pattern(
        'new-kid/navigation-buttons',
        array(
            'title'       => __('Navigation Buttons', 'new-kid'),
            'description' => __('Home and back navigation buttons with NeoBrutalism styling. Back button uses JavaScript.', 'new-kid'),
            'categories'  => array('buttons'),
            'content'     => '<!-- wp:group {"layout":{"type":"flex","justifyContent":"center","flexWrap":"wrap"}} -->
<div class="wp-block-group">
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"className":"is-style-highlight"} -->
<div class="wp-block-button is-style-highlight"><a class="wp-block-button__link wp-element-button" href="/">' . esc_html__('← GO HOME', 'new-kid') . '</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->

<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"className":"is-style-success"} -->
<div class="wp-block-button is-style-success"><a class="wp-block-button__link wp-element-button" href="#">' . esc_html__('← GO BACK', 'new-kid') . '</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->'
        )
    );
}
add_action('init', 'new_kid_register_block_patterns');

/**
 * Register additional block patterns
 */
function new_kid_register_hero_patterns() {
    
    // NeoBrutalism Hero Pattern
    register_block_pattern(
        'new-kid/hero-section',
        array(
            'title'       => __('NeoBrutalism Hero', 'new-kid'),
            'description' => __('Bold hero section with large typography, call-to-action buttons, and NeoBrutalism styling', 'new-kid'),
            'categories'  => array('featured', 'header'),
            'content'     => '<!-- wp:group {"className":"is-style-alert","layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-alert"><!-- wp:heading {"textAlign":"center","level":1,"fontSize":"huge"} -->
<h1 class="wp-block-heading has-text-align-center has-huge-font-size">' . esc_html__('BOLD & BRUTAL', 'new-kid') . '</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","fontSize":"large"} -->
<p class="has-text-align-center has-large-font-size">' . esc_html__('Make a statement with NeoBrutalism design. Sharp edges, bold colors, and unapologetic style.', 'new-kid') . '</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-success"} -->
<div class="wp-block-button is-style-success"><a class="wp-block-button__link wp-element-button">' . esc_html__('GET STARTED', 'new-kid') . '</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-highlight"} -->
<div class="wp-block-button is-style-highlight"><a class="wp-block-button__link wp-element-button">' . esc_html__('LEARN MORE', 'new-kid') . '</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"className":"is-style-highlight"} -->
<div class="wp-block-column is-style-highlight"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">' . esc_html__('STAND OUT', 'new-kid') . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>' . esc_html__('Break free from boring design. Make your mark with bold, unapologetic styling that demands attention.', 'new-kid') . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"is-style-success"} -->
<div class="wp-block-column is-style-success"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">' . esc_html__('BE BOLD', 'new-kid') . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>' . esc_html__('Embrace the power of contrast, thick borders, and dramatic shadows. Your website, your rules.', 'new-kid') . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">' . esc_html__('MAKE IMPACT', 'new-kid') . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>' . esc_html__('Every element tells a story. Sharp typography, vibrant colors, and structured chaos create unforgettable experiences.', 'new-kid') . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->'
        )
    );
    
    // NeoBrutalism CTA Section Pattern
    register_block_pattern(
        'new-kid/cta-section',
        array(
            'title'       => __('NeoBrutalism Call-to-Action', 'new-kid'),
            'description' => __('Attention-grabbing CTA section with bold messaging and action buttons', 'new-kid'),
            'categories'  => array('call-to-action'),
            'content'     => '<!-- wp:group {"className":"is-style-success","layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-success"><!-- wp:heading {"textAlign":"center","level":2,"fontSize":"huge"} -->
<h2 class="wp-block-heading has-text-align-center has-huge-font-size">' . esc_html__('READY TO GO BRUTAL?', 'new-kid') . '</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","fontSize":"large"} -->
<p class="has-text-align-center has-large-font-size">' . esc_html__('Join the design revolution. Embrace bold, unapologetic aesthetics.', 'new-kid') . '</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-alert"} -->
<div class="wp-block-button is-style-alert"><a class="wp-block-button__link wp-element-button">' . esc_html__('START NOW!', 'new-kid') . '</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->'
        )
    );
}
add_action('init', 'new_kid_register_hero_patterns');

/**
 * Customize link underline appearance
 */
function new_kid_customize_register($wp_customize) {
    
    // Add NeoBrutalism Links Section
    $wp_customize->add_section('neo_brutalism_links', array(
        'title'    => __('NeoBrutalism Links', 'new-kid'),
        'priority' => 40,
    ));
    
    // Link Underline Color
    $wp_customize->add_setting('neo_link_underline_color', array(
        'default'           => '#ff0000',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'neo_link_underline_color', array(
        'label'    => __('Link Underline Color', 'new-kid'),
        'section'  => 'neo_brutalism_links',
        'settings' => 'neo_link_underline_color',
    )));
    
    // Link Underline Thickness
    $wp_customize->add_setting('neo_link_underline_thickness', array(
        'default'           => '3',
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('neo_link_underline_thickness', array(
        'label'    => __('Link Underline Thickness (px)', 'new-kid'),
        'section'  => 'neo_brutalism_links',
        'type'     => 'range',
        'input_attrs' => array(
            'min'  => 1,
            'max'  => 10,
            'step' => 1,
        ),
    ));
    
    // Navigation Link Underline Thickness
    $wp_customize->add_setting('neo_nav_link_underline_thickness', array(
        'default'           => '2',
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('neo_nav_link_underline_thickness', array(
        'label'    => __('Navigation Link Underline Thickness (px)', 'new-kid'),
        'section'  => 'neo_brutalism_links',
        'type'     => 'range',
        'input_attrs' => array(
            'min'  => 1,
            'max'  => 8,
            'step' => 1,
        ),
    ));
    
    // Link Underline Style
    $wp_customize->add_setting('neo_link_underline_style', array(
        'default'           => 'solid',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('neo_link_underline_style', array(
        'label'    => __('Link Underline Style', 'new-kid'),
        'section'  => 'neo_brutalism_links',
        'type'     => 'select',
        'choices'  => array(
            'solid'  => __('Solid', 'new-kid'),
            'dashed' => __('Dashed', 'new-kid'),
            'dotted' => __('Dotted', 'new-kid'),
            'double' => __('Double', 'new-kid'),
            'wavy'   => __('Wavy', 'new-kid'),
        ),
    ));
}
add_action('customize_register', 'new_kid_customize_register');

/**
 * Output custom CSS for link underline customization
 */
function new_kid_customize_css() {
    $underline_color = get_theme_mod('neo_link_underline_color', '#ff0000');
    $underline_thickness = get_theme_mod('neo_link_underline_thickness', '3');
    $nav_underline_thickness = get_theme_mod('neo_nav_link_underline_thickness', '2');
    $underline_style = get_theme_mod('neo_link_underline_style', 'solid');
    
    echo '<style type="text/css">';
    echo ':root {';
    echo '--neo-link-underline-color: ' . esc_attr($underline_color) . ';';
    echo '--neo-link-underline-thickness: ' . esc_attr($underline_thickness) . 'px;';
    echo '--neo-nav-link-underline-thickness: ' . esc_attr($nav_underline_thickness) . 'px;';
    echo '--neo-link-underline-style: ' . esc_attr($underline_style) . ';';
    echo '}';
    echo '</style>';
}
add_action('wp_head', 'new_kid_customize_css');
add_action('admin_head', 'new_kid_customize_css');

/**
 * Enqueue theme JavaScript
 */
function new_kid_enqueue_scripts() {
    $js_file = get_template_directory() . '/assets/js/theme.js';
    $js_version = file_exists($js_file) ? filemtime($js_file) : wp_get_theme()->get('Version');
    
    wp_enqueue_script(
        'new-kid-theme',
        get_template_directory_uri() . '/assets/js/theme.js',
        array(),
        $js_version,
        true
    );
}
add_action('wp_enqueue_scripts', 'new_kid_enqueue_scripts');

/**
 * Enqueue block editor scripts
 */
function new_kid_enqueue_block_editor_scripts() {
    $js_file = get_template_directory() . '/assets/js/theme.js';
    $js_version = file_exists($js_file) ? filemtime($js_file) : wp_get_theme()->get('Version');
    
    wp_enqueue_script(
        'new-kid-block-editor',
        get_template_directory_uri() . '/assets/js/theme.js',
        array('wp-blocks', 'wp-hooks'),
        $js_version,
        true
    );
}
add_action('enqueue_block_editor_assets', 'new_kid_enqueue_block_editor_scripts');



/**
 * Enqueue editor styles for the block editor
 */
function new_kid_editor_styles() {
    // Add the main stylesheet to the editor
    add_editor_style('style.css');
}
add_action('after_setup_theme', 'new_kid_editor_styles');


/**
 * Enqueue theme styles with cache busting
 */
function new_kid_enqueue_styles() {
    // Main theme stylesheet
    $style_file = get_template_directory() . '/style.css';
    $style_version = file_exists($style_file) ? filemtime($style_file) : wp_get_theme()->get('Version');
    
    // NeoBrutalism CSS file - enqueued first as dependency
    $neo_css_file = get_template_directory() . '/assets/css/neobrutalismcss.css';
    $neo_css_version = file_exists($neo_css_file) ? filemtime($neo_css_file) : wp_get_theme()->get('Version');
    
    wp_enqueue_style(
        'neo-brutalism-css',
        get_template_directory_uri() . '/assets/css/neobrutalismcss.css',
        array(),
        $neo_css_version
    );
    
    // Main theme stylesheet - depends on NeoBrutalismCSS
    wp_enqueue_style(
        'new-kid-style',
        get_stylesheet_uri(),
        array('neo-brutalism-css'),
        $style_version
    );
    
}
add_action('wp_enqueue_scripts', 'new_kid_enqueue_styles');
