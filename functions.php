<?php
/**
 * DevLite Theme Functions
 * 
 * @package DevLite
 * @version 1.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 */
function devlite_theme_setup() {
    // Add theme support for various features
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    
    // Add theme support for selective refresh for widgets
    add_theme_support('customize-selective-refresh-widgets');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'devlite'),
        'footer' => esc_html__('Footer Menu', 'devlite'),
    ));
    
    // Set content width
    $GLOBALS['content_width'] = 800;
    
    // Add support for editor styles
    add_theme_support('editor-styles');
    add_editor_style('editor-style.css');
}
add_action('after_setup_theme', 'devlite_theme_setup');

/**
 * Enqueue Styles and Scripts
 */
function devlite_scripts() {
    // Main stylesheet
    wp_enqueue_style(
        'devlite-style', 
        get_stylesheet_uri(), 
        array(), 
        wp_get_theme()->get('Version')
    );
    
    // Google Fonts
    wp_enqueue_style(
        'devlite-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Fira+Code:wght@400;500&display=swap',
        array(),
        null
    );
    
    // Theme JavaScript
    wp_enqueue_script(
        'devlite-script',
        get_template_directory_uri() . '/js/main.js',
        array(),
        wp_get_theme()->get('Version'),
        true
    );
    
    // Comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'devlite_scripts');

/**
 * Register Widget Areas
 */
function devlite_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Primary Sidebar', 'devlite'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here.', 'devlite'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'devlite_widgets_init');

/**
 * Custom Excerpt Length
 */
function devlite_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'devlite_excerpt_length');

/**
 * Custom Excerpt More
 */
function devlite_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'devlite_excerpt_more');

/**
 * Add SEO Meta Tags
 */
function devlite_seo_meta() {
    if (is_single() || is_page()) {
        global $post;
        
        // Get post excerpt or create one from content
        $description = get_the_excerpt($post->ID);
        if (empty($description)) {
            $description = wp_trim_words(strip_tags($post->post_content), 30);
        }
        
        // Meta description
        echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
        
        // Open Graph tags
        echo '<meta property="og:title" content="' . esc_attr(get_the_title()) . '">' . "\n";
        echo '<meta property="og:description" content="' . esc_attr($description) . '">' . "\n";
        echo '<meta property="og:type" content="article">' . "\n";
        echo '<meta property="og:url" content="' . esc_url(get_permalink()) . '">' . "\n";
        echo '<meta property="og:site_name" content="' . esc_attr(get_bloginfo('name')) . '">' . "\n";
        
        // Featured image for Open Graph
        if (has_post_thumbnail()) {
            $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
            if ($thumbnail) {
                echo '<meta property="og:image" content="' . esc_url($thumbnail[0]) . '">' . "\n";
                echo '<meta property="og:image:width" content="' . esc_attr($thumbnail[1]) . '">' . "\n";
                echo '<meta property="og:image:height" content="' . esc_attr($thumbnail[2]) . '">' . "\n";
            }
        }
        
        // Twitter Card tags
        echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
        echo '<meta name="twitter:title" content="' . esc_attr(get_the_title()) . '">' . "\n";
        echo '<meta name="twitter:description" content="' . esc_attr($description) . '">' . "\n";
    }
}
add_action('wp_head', 'devlite_seo_meta');

/**
 * Custom Post Navigation
 */
function devlite_post_navigation() {
    $prev_post = get_previous_post();
    $next_post = get_next_post();
    
    if ($prev_post || $next_post) {
        echo '<nav class="post-navigation">';
        
        if ($prev_post) {
            echo '<div class="nav-previous">';
            echo '<a href="' . esc_url(get_permalink($prev_post)) . '">';
            echo '&larr; ' . esc_html(get_the_title($prev_post));
            echo '</a>';
            echo '</div>';
        }
        
        if ($next_post) {
            echo '<div class="nav-next">';
            echo '<a href="' . esc_url(get_permalink($next_post)) . '">';
            echo esc_html(get_the_title($next_post)) . ' &rarr;';
            echo '</a>';
            echo '</div>';
        }
        
        echo '</nav>';
    }
}

/**
 * Add Read Time Estimate
 */
function devlite_reading_time() {
    global $post;
    
    if (!$post) {
        return '';
    }
    
    $content = get_post_field('post_content', $post->ID);
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // Average reading speed: 200 words per minute
    
    if ($reading_time == 1) {
        return $reading_time . ' minute read';
    } else {
        return $reading_time . ' minutes read';
    }
}

/**
 * Custom Logo Setup
 */
function devlite_custom_logo_setup() {
    $defaults = array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array('site-title', 'site-description'),
    );
    add_theme_support('custom-logo', $defaults);
}
add_action('after_setup_theme', 'devlite_custom_logo_setup');

/**
 * Customizer additions
 */
function devlite_customize_register($wp_customize) {
    // Add color scheme option
    $wp_customize->add_section('devlite_colors', array(
        'title'    => __('DevLite Colors', 'devlite'),
        'priority' => 30,
    ));
    
    $wp_customize->add_setting('accent_color', array(
        'default'           => '#4299e1',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'accent_color', array(
        'label'    => __('Accent Color', 'devlite'),
        'section'  => 'devlite_colors',
        'settings' => 'accent_color',
    )));
}
add_action('customize_register', 'devlite_customize_register');

/**
 * Output custom CSS for customizer
 */
function devlite_customizer_css() {
    $accent_color = get_theme_mod('accent_color', '#4299e1');
    
    if ($accent_color !== '#4299e1') {
        echo '<style type="text/css">';
        echo '.site-title:hover, .main-navigation a:hover, .post-title a:hover, .read-more, .pagination a:hover, .pagination .current, .post-navigation a { color: ' . esc_attr($accent_color) . '; }';
        echo '.pagination a:hover, .pagination .current { background-color: ' . esc_attr($accent_color) . '; }';
        echo '</style>';
    }
}
add_action('wp_head', 'devlite_customizer_css');

/**
 * Add theme support for block editor
 */
function devlite_block_editor_setup() {
    // Add support for editor color palette
    add_theme_support('editor-color-palette', array(
        array(
            'name'  => __('Primary', 'devlite'),
            'slug'  => 'primary',
            'color' => '#1a202c',
        ),
        array(
            'name'  => __('Accent', 'devlite'),
            'slug'  => 'accent',
            'color' => '#4299e1',
        ),
        array(
            'name'  => __('Light Gray', 'devlite'),
            'slug'  => 'light-gray',
            'color' => '#f7fafc',
        ),
    ));
    
    // Add support for wide and full alignment
    add_theme_support('align-wide');
}
add_action('after_setup_theme', 'devlite_block_editor_setup');