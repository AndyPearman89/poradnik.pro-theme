<?php
/**
 * Breadcrumbs Navigation (v1.2.0+)
 */
if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('poradnik_breadcrumbs')) {
    return;
}

$breadcrumbs = poradnik_breadcrumbs();
if (empty($breadcrumbs)) {
    return;
}
?>
<nav aria-label="Breadcrumb" class="breadcrumbs">
    <ul itemscope itemtype="https://schema.org/BreadcrumbList">
        <?php foreach ($breadcrumbs as $index => $crumb): ?>
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <?php if (!empty($crumb['url'])): ?>
                    <a itemprop="item" href="<?php echo esc_url($crumb['url']); ?>">
                        <span itemprop="name"><?php echo esc_html($crumb['title']); ?></span>
                    </a>
                <?php else: ?>
                    <span itemprop="name"><?php echo esc_html($crumb['title']); ?></span>
                <?php endif; ?>
                <meta itemprop="position" content="<?php echo esc_attr($index + 1); ?>">
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
