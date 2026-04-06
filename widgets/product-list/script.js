/**
 * EEFE Product List Widget — script.js
 * Handles hover-to-preview card & click-to-navigate
 */
(function ($) {
    'use strict';

    function initEEFEProduct($widget) {
        var $items   = $widget.find('.eefe-product-item');
        var $card    = $widget.find('.eefe-product-card');
        var $cardImg = $card.find('.eefe-card-image');
        var $cardTtl = $card.find('.eefe-card-title');
        var $cardPrc = $card.find('.eefe-card-price');
        var $cardSts = $card.find('.stars-inner');
        var $cardRvc = $card.find('.eefe-card-review-count');

        if (!$items.length) return;

        // ── Populate card ─────────────────────────────────
        function showCard($item) {
            var title   = $item.data('title')     || '';
            var img     = $item.data('image')     || '';
            var price   = $item.data('price')     || '';
            var rating  = parseFloat($item.data('rating')) || 0;
            var reviews = $item.data('reviews')   || 0;

            $cardImg.attr('src', img).attr('alt', title);
            $cardTtl.text(title);
            $cardPrc.html(price);
            $cardSts.html(buildStars(rating));
            $cardRvc.text(reviews > 0 ? '(' + reviews + ' review' + (reviews > 1 ? 's' : '') + ')' : '');

            $card.addClass('is-visible');
        }

        function hideCard() {
            $card.removeClass('is-visible');
        }

        // ── Star builder ──────────────────────────────────
        function buildStars(rating) {
            var html  = '';
            var full  = Math.floor(rating);
            var empty = 5 - Math.ceil(rating);

            for (var i = 0; i < 5; i++) {
                if (i < full) {
                    html += '<span class="star-filled">&#9733;</span>';
                } else {
                    html += '<span class="star-empty">&#9733;</span>';
                }
            }
            return html;
        }

        // ── Hover ─────────────────────────────────────────
        $items.on('mouseenter', function () {
            $items.removeClass('is-active');
            $(this).addClass('is-active');
            showCard($(this));
        });

        $widget.on('mouseleave', function () {
            $items.removeClass('is-active');
            hideCard();
        });

        // ── Click — navigate to product page ─────────────
        $items.on('click', function (e) {
            // Allow normal anchor clicks on the <a> inside
            if ($(e.target).is('a')) return;
            var url = $(this).data('permalink');
            if (url) {
                window.location.href = url;
            }
        });

        // Pointer cursor on list items
        $items.css('cursor', 'pointer');
    }

    // ── Init on page load ─────────────────────────────────
    function init() {
        $('.eefe-product-widget').each(function () {
            initEEFEProduct($(this));
        });
    }

    $(document).ready(init);

    // ── Re-init in Elementor editor ───────────────────────
    if (window.elementorFrontend) {
        $(window).on('elementor/frontend/init', function () {
            elementorFrontend.hooks.addAction(
                'frontend/element_ready/eefe-product.default',
                function ($scope) {
                    initEEFEProduct($scope.find('.eefe-product-widget'));
                }
            );
        });
    }

}(jQuery));
