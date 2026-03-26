<?php

if (!defined('ABSPATH')) {
    exit;
}

add_action('after_setup_theme', static function (): void {
    load_child_theme_textdomain('generatepress-child-poradnik', get_stylesheet_directory() . '/languages');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'gallery', 'caption', 'style', 'script']);

    register_nav_menus([
        'main' => __('Main Menu', 'generatepress-child-poradnik'),
        'mobile' => __('Mobile Menu', 'generatepress-child-poradnik'),
        'footer' => __('Footer Menu', 'generatepress-child-poradnik'),
    ]);
});

add_action('wp_enqueue_scripts', static function (): void {
    wp_enqueue_style('gp-parent-style', get_template_directory_uri() . '/style.css', [], wp_get_theme('generatepress')->get('Version'));
    wp_enqueue_style('poradnik-main', get_stylesheet_directory_uri() . '/assets/css/main.css', ['gp-parent-style'], '1.3.0');
    wp_enqueue_style('poradnik-layout', get_stylesheet_directory_uri() . '/assets/css/layout.css', ['poradnik-main'], '1.3.0');
    wp_enqueue_style('poradnik-components', get_stylesheet_directory_uri() . '/assets/css/components.css', ['poradnik-layout'], '1.3.0');
    wp_enqueue_style('poradnik-responsive', get_stylesheet_directory_uri() . '/assets/css/responsive.css', ['poradnik-components'], '1.3.0');
    wp_enqueue_style('poradnik-premium', get_stylesheet_directory_uri() . '/assets/css/premium.css', ['poradnik-responsive'], '1.3.0');
    wp_enqueue_style('poradnik-portal-pro', get_stylesheet_directory_uri() . '/assets/css/portal-pro.css', ['poradnik-premium'], '1.3.0');

    wp_enqueue_script('poradnik-main', get_stylesheet_directory_uri() . '/assets/js/main.js', [], '1.3.0', true);
    wp_enqueue_script('poradnik-search', get_stylesheet_directory_uri() . '/assets/js/search.js', ['poradnik-main'], '1.3.0', true);
    wp_enqueue_script('poradnik-ajax', get_stylesheet_directory_uri() . '/assets/js/ajax.js', ['poradnik-main'], '1.3.0', true);
    wp_enqueue_script('poradnik-filters', get_stylesheet_directory_uri() . '/assets/js/filters.js', ['poradnik-main'], '1.3.0', true);
    wp_enqueue_script('poradnik-premium', get_stylesheet_directory_uri() . '/assets/js/premium.js', ['poradnik-main'], '1.3.0', true);

    wp_localize_script('poradnik-ajax', 'poradnikAjax', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'restUrl' => esc_url_raw(rest_url('peartree/v1/')),
        'nonce' => wp_create_nonce('wp_rest'),
        'modules' => [
            'listings' => esc_url_raw(rest_url('peartree/v1/listings')),
            'leads' => esc_url_raw(rest_url('peartree/v1/leads')),
            'reviews' => esc_url_raw(rest_url('peartree/v1/reviews')),
            'affiliate' => esc_url_raw(rest_url('peartree/v1/affiliate')),
            'seo' => esc_url_raw(rest_url('peartree/v1/seo')),
            'claim' => esc_url_raw(rest_url('peartree/v1/claim')),
            'weather' => esc_url_raw(rest_url('peartree/v1/weather')),
            'map' => esc_url_raw(rest_url('peartree/v1/map')),
            'booking' => esc_url_raw(rest_url('peartree/v1/bookings')),
            'analytics' => esc_url_raw(rest_url('peartree/v1/analytics')),
            'sponsored' => esc_url_raw(rest_url('peartree/v1/advertising')),
        ],
    ]);
});

add_action('admin_enqueue_scripts', static function (): void {
    wp_enqueue_style('poradnik-admin', get_stylesheet_directory_uri() . '/assets/css/admin.css', [], '1.3.0');
});

add_action('init', static function (): void {
    $postTypes = [
        'poradnik' => __('Poradniki', 'generatepress-child-poradnik'),
        'ranking' => __('Rankingi', 'generatepress-child-poradnik'),
        'recenzja' => __('Recenzje', 'generatepress-child-poradnik'),
        'produkt' => __('Produkty', 'generatepress-child-poradnik'),
        'porownanie' => __('Porównania', 'generatepress-child-poradnik'),
        'pytanie' => __('Pytania', 'generatepress-child-poradnik'),
        'specjalista' => __('Specjaliści', 'generatepress-child-poradnik'),
    ];

    foreach ($postTypes as $slug => $label) {
        register_post_type($slug, [
            'label' => $label,
            'public' => true,
            'show_in_rest' => true,
            'has_archive' => true,
            'supports' => ['title', 'editor', 'excerpt', 'thumbnail', 'author', 'comments'],
            'rewrite' => ['slug' => $slug],
        ]);
    }

    register_taxonomy('kategoria', ['poradnik', 'ranking', 'recenzja', 'produkt', 'porownanie', 'pytanie'], [
        'label' => __('Kategorie', 'generatepress-child-poradnik'),
        'public' => true,
        'hierarchical' => true,
        'show_in_rest' => true,
    ]);

    register_taxonomy('tag', ['poradnik', 'ranking', 'recenzja', 'produkt', 'porownanie', 'pytanie'], [
        'label' => __('Tagi', 'generatepress-child-poradnik'),
        'public' => true,
        'hierarchical' => false,
        'show_in_rest' => true,
    ]);

    register_taxonomy('miasto', ['specjalista', 'pytanie'], [
        'label' => __('Miasta', 'generatepress-child-poradnik'),
        'public' => true,
        'hierarchical' => true,
        'show_in_rest' => true,
    ]);

    register_taxonomy('usluga', ['specjalista'], [
        'label' => __('Usługi', 'generatepress-child-poradnik'),
        'public' => true,
        'hierarchical' => true,
        'show_in_rest' => true,
    ]);
});

if (!function_exists('poradnik_section_title')) {
    function poradnik_section_title(string $title): void
    {
        echo '<h2 class="section-title">' . esc_html($title) . '</h2>';
    }
}

add_action('wp_head', static function (): void {
    if (!is_front_page()) {
        return;
    }

    get_template_part('template-parts/schema/schema', 'article');
    get_template_part('template-parts/schema/schema', 'review');
    get_template_part('template-parts/schema/schema', 'product');
    get_template_part('template-parts/schema/schema', 'faq');
    get_template_part('template-parts/schema/schema', 'breadcrumb');
}, 20);

/**
 * Premium Feature Functions (v1.1.0+)
 */
if (!function_exists('poradnik_is_user_premium')) {
    function poradnik_is_user_premium(): bool
    {
        return is_user_logged_in() && current_user_can('editor') || current_user_can('administrator');
    }
}

if (!function_exists('poradnik_get_premium_badge')) {
    function poradnik_get_premium_badge(): string
    {
        return '<span class="premium-badge" title="Zawartość Premium"><i class="icon-star"></i> Premium</span>';
    }
}

if (!function_exists('poradnik_render_premium_content')) {
    function poradnik_render_premium_content(string $content, bool $is_premium = false): string
    {
        if (!$is_premium) {
            return $content;
        }

        if (poradnik_is_user_premium()) {
            return $content;
        }

        return '<div class="premium-lockdown"><p>🔒 Ta zawartość jest dostępna dla Użytkowników Premium</p>' . get_template_part('template-parts/premium/paywall-cta') . '</div>';
    }
}

/**
 * Generate Breadcrumbs (v1.2.0+)
 */
if (!function_exists('poradnik_breadcrumbs')) {
    function poradnik_breadcrumbs(): array
    {
        $crumbs = [];

        if (is_home() || is_front_page()) {
            $crumbs[] = ['title' => 'Strona główna', 'url' => home_url()];
        } elseif (is_page() || is_single()) {
            $crumbs[] = ['title' => 'Strona główna', 'url' => home_url()];

            if (is_single()) {
                $post_type = get_post_type();
                $post_type_obj = get_post_type_object($post_type);
                if ($post_type_obj) {
                    $crumbs[] = ['title' => $post_type_obj->label, 'url' => get_post_type_archive_link($post_type)];
                }
                $crumbs[] = ['title' => get_the_title(), 'url' => ''];
            } else {
                $crumbs[] = ['title' => get_the_title(), 'url' => ''];
            }
        } elseif (is_category() || is_tax()) {
            $crumbs[] = ['title' => 'Strona główna', 'url' => home_url()];
            $crumbs[] = ['title' => single_term_title('', false), 'url' => ''];
        } elseif (is_archive()) {
            $crumbs[] = ['title' => 'Strona główna', 'url' => home_url()];
            $crumbs[] = ['title' => post_type_archive_title('', false) ?: 'Archiwum', 'url' => ''];
        }

        return apply_filters('poradnik_breadcrumbs', $crumbs);
    }
}

add_filter('the_content', static function (string $content): string {
    if (is_singular(['poradnik', 'ranking', 'recenzja', 'produkt'])) {
        $is_premium = get_post_meta(get_the_ID(), '_poradnik_is_premium', true);
        return poradnik_render_premium_content($content, (bool)$is_premium);
    }
    return $content;
});

add_action('add_meta_boxes', static function (): void {
    $screens = ['poradnik', 'ranking', 'recenzja', 'produkt'];

    foreach ($screens as $screen) {
        add_meta_box(
            'poradnik_premium_meta',
            __('Ustawienia Premium', 'generatepress-child-poradnik'),
            static function (\WP_Post $post): void {
                wp_nonce_field('poradnik_premium_meta', 'poradnik_premium_meta_nonce');
                $enabled = (bool) get_post_meta($post->ID, '_poradnik_is_premium', true);
                echo '<label><input type="checkbox" name="poradnik_is_premium" value="1" ' . checked($enabled, true, false) . ' /> ' . esc_html__('Treść premium', 'generatepress-child-poradnik') . '</label>';
            },
            $screen,
            'side',
            'high'
        );
    }
});

add_action('save_post', static function (int $postId): void {
    if (!isset($_POST['poradnik_premium_meta_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['poradnik_premium_meta_nonce'])), 'poradnik_premium_meta')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $postId)) {
        return;
    }

    $isPremium = isset($_POST['poradnik_is_premium']) && (int) $_POST['poradnik_is_premium'] === 1;
    update_post_meta($postId, '_poradnik_is_premium', $isPremium ? '1' : '0');
});

add_action('wp_dashboard_setup', static function (): void {
    wp_add_dashboard_widget(
        'poradnik_module_status_widget',
        __('Poradnik.pro — Status modułów', 'generatepress-child-poradnik'),
        static function (): void {
            $routes = [
                'Listings' => rest_url('peartree/v1/listings'),
                'Leads' => rest_url('peartree/v1/leads'),
                'Reviews' => rest_url('peartree/v1/reviews'),
                'SEO' => rest_url('peartree/v1/seo'),
                'Claim' => rest_url('peartree/v1/claim'),
                'Weather' => rest_url('peartree/v1/weather'),
                'Map' => rest_url('peartree/v1/map'),
                'Booking' => rest_url('peartree/v1/bookings'),
            ];

            echo '<div class="poradnik-module-widget">';
            echo '<ul>';

            foreach ($routes as $name => $url) {
                echo '<li><strong>' . esc_html($name) . '</strong><span>' . esc_html($url) . '</span></li>';
            }

            echo '</ul>';
            echo '<p><a class="button button-primary" href="' . esc_url(admin_url('post-new.php?post_type=poradnik')) . '">' . esc_html__('Dodaj poradnik', 'generatepress-child-poradnik') . '</a></p>';
            echo '</div>';
        }
    );
});
