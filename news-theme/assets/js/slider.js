(function ($) {
  function NewsSlider($root) {
    this.$root = $root;
    this.$track = $root.find('.news-slider-track');
    this.$slides = $root.find('.news-slide');
    this.$prev = $root.find('.nav.prev');
    this.$next = $root.find('.nav.next');
    this.$dots = $root.find('.news-dots');
    this.index = 0;
    this.count = this.$slides.length;
    this.autoplay = $root.data('autoplay') !== false;
    this.interval = null;

    this.init();
  }

  NewsSlider.prototype.init = function () {
    var self = this;
    // Build dots
    this.$dots.empty();
    for (var i = 0; i < this.count; i++) {
      var $btn = $('<button aria-label="Go to slide ' + (i + 1) + '"></button>');
      (function (idx) {
        $btn.on('click', function () { self.goTo(idx); });
      })(i);
      this.$dots.append($btn);
    }

    this.$prev.on('click', function () { self.prev(); });
    this.$next.on('click', function () { self.next(); });

    $(window).on('resize', function () { self.update(); });

    this.update();
    if (this.autoplay) {
      this.start();
      this.$root.on('mouseenter', function () { self.stop(); });
      this.$root.on('mouseleave', function () { self.start(); });
    }
  };

  NewsSlider.prototype.update = function () {
    this.width = this.$root.innerWidth();
    this.$slides.css('min-width', this.width + 'px');
    this.goTo(this.index, true);
  };

  NewsSlider.prototype.goTo = function (idx, immediate) {
    if (idx < 0) idx = this.count - 1;
    if (idx >= this.count) idx = 0;
    this.index = idx;
    var offset = -this.width * this.index;
    this.$track.css('transition-duration', immediate ? '0ms' : '400ms');
    this.$track.css('transform', 'translate3d(' + offset + 'px,0,0)');
    var self = this;
    this.$dots.children().each(function (i, el) {
      $(el).toggleClass('active', i === self.index);
    });
  };

  NewsSlider.prototype.prev = function () { this.goTo(this.index - 1); };
  NewsSlider.prototype.next = function () { this.goTo(this.index + 1); };

  NewsSlider.prototype.start = function () {
    var self = this;
    if (this.interval) return;
    this.interval = setInterval(function () { self.next(); }, 5000);
  };

  NewsSlider.prototype.stop = function () {
    if (!this.interval) return;
    clearInterval(this.interval);
    this.interval = null;
  };

  $(function () {
    $('.news-slider').each(function () { new NewsSlider($(this)); });
  });
})(jQuery);
