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
    wp_enqueue_style('poradnik-cpt-enterprise', get_stylesheet_directory_uri() . '/assets/css/cpt-enterprise.css', ['poradnik-portal-pro'], '1.3.0');

    wp_enqueue_script('poradnik-main', get_stylesheet_directory_uri() . '/assets/js/main.js', [], '1.3.0', true);
    wp_enqueue_script('poradnik-search', get_stylesheet_directory_uri() . '/assets/js/search.js', ['poradnik-main'], '1.3.0', true);
    wp_enqueue_script('poradnik-ajax', get_stylesheet_directory_uri() . '/assets/js/ajax.js', ['poradnik-main'], '1.3.0', true);
    wp_enqueue_script('poradnik-filters', get_stylesheet_directory_uri() . '/assets/js/filters.js', ['poradnik-main'], '1.3.0', true);
    wp_enqueue_script('poradnik-premium', get_stylesheet_directory_uri() . '/assets/js/premium.js', ['poradnik-main'], '1.3.0', true);

    $moduleRoutes = function_exists('poradnik_get_module_routes') ? poradnik_get_module_routes() : [];

    wp_localize_script('poradnik-ajax', 'poradnikAjax', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'restUrl' => esc_url_raw(rest_url('peartree/v1/')),
        'nonce' => wp_create_nonce('wp_rest'),
        'modules' => array_reduce(
            $moduleRoutes,
            static function (array $carry, array $route): array {
                $carry[$route['key']] = esc_url_raw($route['url']);
                return $carry;
            },
            []
        ),
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
        'rewrite' => [
            'slug' => 'kategorie',
            'with_front' => false,
        ],
        'query_var' => 'kategorie',
    ]);

    register_taxonomy('tag', ['poradnik', 'ranking', 'recenzja', 'produkt', 'porownanie', 'pytanie'], [
        'label' => __('Tagi', 'generatepress-child-poradnik'),
        'public' => true,
        'hierarchical' => false,
        'show_in_rest' => true,
        'rewrite' => [
            'slug' => 'tematy',
            'with_front' => false,
        ],
        'query_var' => 'tematy',
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

add_action('init', static function (): void {
    add_rewrite_rule('^kategorie/([^/]+)/?$', 'index.php?taxonomy=kategoria&term=$matches[1]', 'top');
    add_rewrite_rule('^tematy/([^/]+)/?$', 'index.php?taxonomy=tag&term=$matches[1]', 'top');
}, 20);

if (!function_exists('poradnik_section_title')) {
    function poradnik_section_title(string $title): void
    {
        echo '<h2 class="section-title">' . esc_html($title) . '</h2>';
    }
}

if (!function_exists('poradnik_get_taxonomy_archive_config')) {
    function poradnik_get_taxonomy_archive_config(string $taxonomy): array
    {
        $configs = [
            'kategoria' => [
                'label' => __('Kategoria', 'generatepress-child-poradnik'),
                'fallback_description' => __('Zbiór treści eksperckich powiązanych z tym tematem, od praktycznych poradników po rankingi i recenzje.', 'generatepress-child-poradnik'),
                'empty_title' => __('Brak wpisów w tej kategorii', 'generatepress-child-poradnik'),
                'empty_description' => __('W tej chwili nie ma jeszcze opublikowanych treści.', 'generatepress-child-poradnik'),
                'cta_url' => home_url('/poradniki/'),
                'cta_label' => __('Przejdź do poradników', 'generatepress-child-poradnik'),
            ],
            'tag' => [
                'label' => __('Tag', 'generatepress-child-poradnik'),
                'fallback_description' => __('Szybki przekrój artykułów, rankingów i materiałów produktowych związanych z tym konkretnym zagadnieniem.', 'generatepress-child-poradnik'),
                'empty_title' => __('Brak wpisów dla tego tagu', 'generatepress-child-poradnik'),
                'empty_description' => __('W tej chwili nie ma jeszcze opublikowanych treści.', 'generatepress-child-poradnik'),
                'cta_url' => home_url('/poradniki/'),
                'cta_label' => __('Przeglądaj poradniki', 'generatepress-child-poradnik'),
            ],
            'miasto' => [
                'label' => __('Miasto', 'generatepress-child-poradnik'),
                'fallback_description' => __('Specjaliści, usługi i lokalne treści przypisane do tej lokalizacji.', 'generatepress-child-poradnik'),
                'empty_title' => __('Brak wpisów dla tej lokalizacji', 'generatepress-child-poradnik'),
                'empty_description' => __('Spróbuj wybrać inne miasto lub wróć do katalogu.', 'generatepress-child-poradnik'),
                'cta_url' => home_url('/specjalisci/'),
                'cta_label' => __('Przejdź do specjalistów', 'generatepress-child-poradnik'),
            ],
            'usluga' => [
                'label' => __('Usługa', 'generatepress-child-poradnik'),
                'fallback_description' => __('Oferty, profile specjalistów i treści poradnikowe powiązane z wybraną usługą.', 'generatepress-child-poradnik'),
                'empty_title' => __('Brak wpisów dla tej usługi', 'generatepress-child-poradnik'),
                'empty_description' => __('Dodaj treści lub profile przypisane do tej usługi.', 'generatepress-child-poradnik'),
                'cta_url' => home_url('/specjalisci/'),
                'cta_label' => __('Zobacz specjalistów', 'generatepress-child-poradnik'),
            ],
        ];

        return $configs[$taxonomy] ?? [
            'label' => __('Archiwum', 'generatepress-child-poradnik'),
            'fallback_description' => __('Przegląd treści przypisanych do wybranego terminu.', 'generatepress-child-poradnik'),
            'empty_title' => __('Brak wpisów', 'generatepress-child-poradnik'),
            'empty_description' => __('W tej chwili nie ma jeszcze opublikowanych treści.', 'generatepress-child-poradnik'),
            'cta_url' => home_url('/'),
            'cta_label' => __('Powrót na stronę główną', 'generatepress-child-poradnik'),
        ];
    }
}

if (!function_exists('poradnik_get_taxonomy_related_terms')) {
    function poradnik_get_taxonomy_related_terms(
        string $taxonomy,
        int $currentTermId,
        int $limit = 8,
        int $parentId = 0
    ): array {
        $args = [
            'taxonomy' => $taxonomy,
            'hide_empty' => true,
            'exclude' => [$currentTermId],
            'number' => $limit,
            'orderby' => 'count',
            'order' => 'DESC',
        ];

        if ($parentId > 0) {
            $args['parent'] = $parentId;
        }

        $terms = get_terms($args);

        if ($parentId > 0 && (is_wp_error($terms) || empty($terms))) {
            unset($args['parent']);
            $terms = get_terms($args);
        }

        return is_wp_error($terms) ? [] : $terms;
    }
}

if (!function_exists('poradnik_get_archive_post_type_labels')) {
    function poradnik_get_archive_post_type_labels(): array
    {
        global $wp_query;

        if (!isset($wp_query->posts) || !is_array($wp_query->posts)) {
            return [];
        }

        $labels = [];

        foreach ($wp_query->posts as $post) {
            $postType = get_post_type($post);
            if (!$postType) {
                continue;
            }

            $postTypeObject = get_post_type_object($postType);
            $labels[$postType] = $postTypeObject ? $postTypeObject->labels->singular_name : ucfirst($postType);
        }

        return array_values($labels);
    }
}

if (!function_exists('poradnik_get_post_type_label')) {
    function poradnik_get_post_type_label(int $postId): string
    {
        $postType = get_post_type($postId);
        if (!$postType) {
            return '';
        }

        $postTypeObject = get_post_type_object($postType);

        return $postTypeObject ? (string) $postTypeObject->labels->singular_name : ucfirst($postType);
    }
}

if (!function_exists('poradnik_get_module_routes')) {
    function poradnik_get_module_routes(): array
    {
        return [
            ['name' => 'Listings', 'key' => 'listings', 'url' => rest_url('peartree/v1/listings')],
            ['name' => 'Leads', 'key' => 'leads', 'url' => rest_url('peartree/v1/leads')],
            ['name' => 'Reviews', 'key' => 'reviews', 'url' => rest_url('peartree/v1/reviews')],
            ['name' => 'Affiliate', 'key' => 'affiliate', 'url' => rest_url('peartree/v1/affiliate/status')],
            ['name' => 'SEO', 'key' => 'seo', 'url' => rest_url('peartree/v1/programmatic-seo/status')],
            ['name' => 'Claim', 'key' => 'claim', 'url' => rest_url('peartree/v1/claim')],
            ['name' => 'Weather', 'key' => 'weather', 'url' => rest_url('peartree/v1/weather?lat=50.0647&lng=19.9450')],
            ['name' => 'Map', 'key' => 'map', 'url' => rest_url('peartree/v1/map/search?lat=50.0647&lng=19.9450')],
            ['name' => 'Booking', 'key' => 'booking', 'url' => rest_url('peartree/v1/bookings/status')],
            ['name' => 'Analytics', 'key' => 'analytics', 'url' => rest_url('peartree/v1/analytics')],
            ['name' => 'Sponsored', 'key' => 'sponsored', 'url' => rest_url('peartree/v1/advertising/status')],
        ];
    }
}

if (!function_exists('poradnik_get_module_statuses')) {
    function poradnik_get_module_statuses(bool $forceRefresh = false): array
    {
        $cacheKey = 'poradnik_module_statuses_v1';

        if (!$forceRefresh) {
            $cached = get_transient($cacheKey);
            if (is_array($cached) && isset($cached['items'])) {
                return $cached;
            }
        }

        $items = [];
        foreach (poradnik_get_module_routes() as $route) {
            $response = wp_remote_get($route['url'], [
                'timeout' => 3,
                'redirection' => 2,
            ]);

            $statusCode = is_wp_error($response) ? 0 : (int) wp_remote_retrieve_response_code($response);
            $isOnline = !is_wp_error($response) && $statusCode >= 200 && $statusCode < 400;

            $items[$route['key']] = [
                'name' => $route['name'],
                'key' => $route['key'],
                'url' => $route['url'],
                'online' => $isOnline,
                'status_code' => $statusCode,
                'error' => is_wp_error($response) ? $response->get_error_message() : '',
            ];
        }

        $statusData = [
            'checked_at' => time(),
            'items' => $items,
        ];

        set_transient($cacheKey, $statusData, 5 * MINUTE_IN_SECONDS);

        return $statusData;
    }
}

if (!function_exists('poradnik_get_module_status_badge')) {
    function poradnik_get_module_status_badge(array $item): string
    {
        $isOnline = !empty($item['online']);
        $className = $isOnline ? 'is-online' : 'is-offline';
        $label = $isOnline ? __('ONLINE', 'generatepress-child-poradnik') : __('OFFLINE', 'generatepress-child-poradnik');

        return '<span class="poradnik-status-badge ' . esc_attr($className) . '">' . esc_html($label) . '</span>';
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

    if (function_exists('wp_doing_autosave') && wp_doing_autosave()) {
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
            $statusData = poradnik_get_module_statuses(false);
            $refreshUrl = wp_nonce_url(
                add_query_arg('poradnik_refresh_modules', '1', admin_url('index.php')),
                'poradnik_refresh_modules'
            );

            echo '<div class="poradnik-module-widget">';
            if (isset($statusData['checked_at'])) {
                echo '<p class="poradnik-module-widget__meta">' . sprintf(
                    esc_html__('Ostatnia aktualizacja: %s', 'generatepress-child-poradnik'),
                    esc_html(date_i18n('Y-m-d H:i:s', (int) $statusData['checked_at']))
                ) . '</p>';
            }
            echo '<ul>';

            foreach ($statusData['items'] as $item) {
                $codeText = $item['status_code'] > 0 ? 'HTTP ' . (int) $item['status_code'] : __('Brak odpowiedzi', 'generatepress-child-poradnik');
                $errorText = !empty($item['error']) ? ' — ' . $item['error'] : '';

                echo '<li>';
                echo '<div class="poradnik-module-widget__left"><strong>' . esc_html($item['name']) . '</strong>' . poradnik_get_module_status_badge($item) . '</div>';
                echo '<span title="' . esc_attr($item['url']) . '">' . esc_html($codeText . $errorText) . '</span>';
                echo '</li>';
            }

            echo '</ul>';
            echo '<p class="poradnik-module-widget__actions">';
            echo '<a class="button" href="' . esc_url($refreshUrl) . '">' . esc_html__('Odśwież statusy', 'generatepress-child-poradnik') . '</a> ';
            echo '<a class="button button-primary" href="' . esc_url(admin_url('post-new.php?post_type=poradnik')) . '">' . esc_html__('Dodaj poradnik', 'generatepress-child-poradnik') . '</a>';
            echo '</p>';
            echo '</div>';
        }
    );
});

add_action('admin_init', static function (): void {
    if (!is_admin() || !isset($_GET['poradnik_refresh_modules'])) {
        return;
    }

    if (!current_user_can('manage_options')) {
        return;
    }

    if (!isset($_GET['_wpnonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_GET['_wpnonce'])), 'poradnik_refresh_modules')) {
        return;
    }

    delete_transient('poradnik_module_statuses_v1');
    poradnik_get_module_statuses(true);
    wp_safe_redirect(admin_url('index.php'));
    exit;
});
