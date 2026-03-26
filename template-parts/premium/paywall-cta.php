<?php
/**
 * Premium Paywall CTA (v1.1.0+)
 */
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="premium-paywall">
    <div class="paywall-content">
        <h3>🌟 Pełny Dostęp Premium</h3>
        <p>Odblokuj całą zawartość i wszystkie ekskluzywe informacje</p>
        <ul class="premium-features">
            <li>✓ Pełne artykuły i porady</li>
            <li>✓ Ekskluzywne rankingi</li>
            <li>✓ Szczegółowe recenzje produktów</li>
            <li>✓ Porównania bez ograniczeń</li>
            <li>✓ Wsparcie od specjalistów</li>
        </ul>
        <button class="btn btn-premium" onclick="window.location.href='<?php echo esc_url(wp_login_url()); ?>'">
            Zaloguj się lub Dołącz Premium
        </button>
    </div>
</div>
