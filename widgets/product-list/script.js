/**
 * EEFE Product List Widget — script.js
 * Handles hover-to-preview card & click-to-navigate
 */
(function ($) {
  "use strict";

  function initEEFEProduct($widget) {
    var $items = $widget.find(".eefe-product-item");
    var $card = $widget.find(".eefe-product-card");
    var $cardImg = $card.find(".eefe-card-image");
    var $cardTtl = $card.find(".eefe-card-title");
    var $cardSub = $card.find(".eefe-card-subtitle");
    var $cardPrc = $card.find(".eefe-card-price");
    var $cardSts = $card.find(".stars-inner");
    var $cardRvc = $card.find(".eefe-card-review-count");

    var showSubtitle = $widget.data("show-subtitle") !== 0;

    if (!$items.length) return;

    // ── Populate card ─────────────────────────────────
    function showCard($item) {
      var title = $item.data("title") || "";
      var subtitle = $item.data("subtitle") || "";
      var img = $item.data("image") || "";
      var price = $item.data("price") || "";
      var rating = parseFloat($item.data("rating")) || 0;
      var reviews = $item.data("reviews") || 0;

      $cardImg.attr("src", img).attr("alt", title);
      $cardTtl.text(title);
      $cardPrc.html(price);
      $cardSts.html(buildStars(rating));
      $cardRvc.text(
        reviews > 0
          ? "(" + reviews + " review" + (reviews > 1 ? "s" : "") + ")"
          : "",
      );

      if (showSubtitle) {
        $cardSub.text(subtitle);
      }

      $card.addClass("is-visible");
    }

    // ── Star builder ──────────────────────────────────
    function buildStars(rating) {
      var html = "";
      var full = Math.floor(rating);

      for (var i = 0; i < 5; i++) {
        if (i < full) {
          html += '<span class="star-filled">&#9733;</span>';
        } else {
          html += '<span class="star-empty">&#9733;</span>';
        }
      }
      return html;
    }

    // ── NEW: Set default state (First Product) ────────
    var $firstItem = $items.first();
    $firstItem.addClass("is-active");
    showCard($firstItem);

    // ── Hover ─────────────────────────────────────────
    $items.on("mouseenter", function () {
      $items.removeClass("is-active");
      $(this).addClass("is-active");
      showCard($(this));
    });

    // ── MODIFIED: Remove the "mouseleave" hide logic ──
    // We no longer call hideCard() here so the last
    // hovered product stays visible.
    $widget.on("mouseleave", function () {
      // Optional: You can keep the active class on the
      // last item so it stays highlighted in the list.
    });

    // ── Click — navigate to product page ─────────────
    $items.on("click", function (e) {
      if ($(e.target).is("a")) return;
      var url = $(this).data("permalink");
      if (url) {
        window.location.href = url;
      }
    });

    $items.css("cursor", "pointer");
  }

  // ── Init on page load ─────────────────────────────────
  function init() {
    $(".eefe-product-widget").each(function () {
      initEEFEProduct($(this));
    });
  }

  $(document).ready(init);

  // ── Re-init in Elementor editor ───────────────────────
  if (window.elementorFrontend) {
    $(window).on("elementor/frontend/init", function () {
      elementorFrontend.hooks.addAction(
        "frontend/element_ready/eefe-product.default",
        function ($scope) {
          initEEFEProduct($scope.find(".eefe-product-widget"));
        },
      );
    });
  }
})(jQuery);
