/**
 * EEFE Slider Widget — script.js
 * Handles slider navigation, auto-play, and transitions
 */
(function ($) {
  "use strict";

  function initEEFESlider($wrapper) {
    var $slider = $wrapper.find(".eefe-slider");
    var $slidesContainer = $slider.find(".eefe-slides-container");
    var $slides = $slidesContainer.find(".eefe-slide");
    var $prevBtn = $slider.find(".eefe-slider-prev");
    var $nextBtn = $slider.find(".eefe-slider-next");
    var $dots = $wrapper.find(".eefe-pagination-dot");
    var $thumbnails = $wrapper.find(".eefe-thumbnail");

    var currentSlide = 0;
    var autoPlayInterval = null;
    var isTransitioning = false;

    // Data attributes
    var slidesPerView = parseInt($wrapper.data("slides-per-view")) || 1;
    var spaceBetween = parseInt($wrapper.data("space-between")) || 20;
    var autoPlay = $wrapper.data("auto-play") === 1;
    var autoPlaySpeed = parseInt($wrapper.data("auto-play-speed")) || 5000;
    var speed = parseInt($wrapper.data("speed")) || 600;
    var loop = $wrapper.data("loop") === 1;
    var thumbnailTrigger = $wrapper.data("thumbnail-trigger") || "click";

    if (!$slides.length) return;

    // ── Show specific slide ──────────────────────
    function goToSlide(index) {
      if (isTransitioning) return;

      isTransitioning = true;

      // Handle loop
      if (!loop) {
        if (index < 0) index = 0;
        if (index >= $slides.length) index = $slides.length - 1;
      } else {
        if (index < 0) index = $slides.length - 1;
        if (index >= $slides.length) index = 0;
      }

      var prevSlide = currentSlide;
      currentSlide = index;

      // Update slide state
      $slides.removeClass("active prev-active");
      $slides.eq(currentSlide).addClass("active");
      if (prevSlide !== currentSlide) {
        $slides.eq(prevSlide).addClass("prev-active");
      }

      // Update pagination dots
      $dots.removeClass("active");
      $dots.eq(currentSlide).addClass("active");

      // Update thumbnails
      $thumbnails.removeClass("active");
      $thumbnails.eq(currentSlide).addClass("active");

      setTimeout(function () {
        isTransitioning = false;
      }, speed);
    }

    // ── Next slide ───────────────────────────────
    function nextSlide() {
      var next = currentSlide + 1;
      if (next >= $slides.length && !loop) return;
      goToSlide(next);
      resetAutoPlay();
    }

    // ── Previous slide ───────────────────────────
    function prevSlide() {
      var prev = currentSlide - 1;
      if (prev < 0 && !loop) return;
      goToSlide(prev);
      resetAutoPlay();
    }

    // ── Auto play functionality ──────────────────
    function startAutoPlay() {
      if (!autoPlay) return;

      autoPlayInterval = setInterval(function () {
        var next = currentSlide + 1;
        if (next >= $slides.length) {
          if (loop) {
            goToSlide(0);
          } else {
            stopAutoPlay();
          }
        } else {
          nextSlide();
        }
      }, autoPlaySpeed);
    }

    function stopAutoPlay() {
      if (autoPlayInterval) {
        clearInterval(autoPlayInterval);
        autoPlayInterval = null;
      }
    }

    function resetAutoPlay() {
      stopAutoPlay();
      startAutoPlay();
    }

    // ── Event listeners ──────────────────────────

    // Navigation arrows
    $prevBtn.on("click", function () {
      prevSlide();
    });

    $nextBtn.on("click", function () {
      nextSlide();
    });

    // Pagination dots
    $dots.on("click", function () {
      var slideIndex = $(this).data("slide");
      goToSlide(slideIndex);
      resetAutoPlay();
    });

    // Thumbnails
    if (thumbnailTrigger === "click") {
      $thumbnails.on("click", function () {
        var slideIndex = $(this).data("slide");
        goToSlide(slideIndex);
        resetAutoPlay();
      });
    } else if (thumbnailTrigger === "hover") {
      $thumbnails.on("mouseenter", function () {
        var slideIndex = $(this).data("slide");
        goToSlide(slideIndex);
        resetAutoPlay();
      });
    }

    // Keyboard navigation
    $(document).on("keydown", function (e) {
      if (e.key === "ArrowLeft") {
        prevSlide();
      } else if (e.key === "ArrowRight") {
        nextSlide();
      }
    });

    // Pause auto-play on hover
    $slider.on("mouseenter", function () {
      stopAutoPlay();
    });

    $slider.on("mouseleave", function () {
      if (autoPlay) {
        startAutoPlay();
      }
    });

    // Initialize
    startAutoPlay();
  }

  // ── Init on page load ────────────────────────
  function init() {
    $(".eefe-slider-wrapper").each(function () {
      initEEFESlider($(this));
    });
  }

  $(document).ready(init);

  // ── Re-init in Elementor editor ──────────────
  if (window.elementorFrontend) {
    $(window).on("elementor/frontend/init", function () {
      elementorFrontend.hooks.addAction(
        "frontend/element_ready/eefe-slider.default",
        function ($scope) {
          initEEFESlider($scope.find(".eefe-slider-wrapper"));
        }
      );
    });
  }
})(jQuery);
