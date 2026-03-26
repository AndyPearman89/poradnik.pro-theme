/**
 * Premium Features JavaScript (v1.1.0+)
 */

(function() {
    'use strict';

    const PremiumTheme = {
        init() {
            this.checkPremiumContent();
            this.renderBadges();
            this.setupPaywallListeners();
        },

        checkPremiumContent() {
            const content = document.querySelector('article');
            if (!content) return;

            const isPremium = content.querySelector('.premium-lockdown');
            if (isPremium) {
                document.body.classList.add('has-premium-content');
            }
        },

        renderBadges() {
            const premium = document.querySelectorAll('[data-premium="true"]');
            premium.forEach(el => {
                const badge = document.createElement('span');
                badge.className = 'premium-badge';
                badge.innerHTML = '<i class="icon-star"></i> Premium';
                el.appendChild(badge);
            });
        },

        setupPaywallListeners() {
            const paywall = document.querySelector('.btn-premium');
            if (paywall) {
                paywall.addEventListener('click', (e) => {
                    e.preventDefault();
                    window.location.href = paywall.getAttribute('href') || '/wp-login.php';
                });
            }
        }
    };

    document.addEventListener('DOMContentLoaded', () => {
        PremiumTheme.init();
    });

})();
