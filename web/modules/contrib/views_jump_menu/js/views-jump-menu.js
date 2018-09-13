(function ($) {
  'use strict';

  Drupal.behaviors.viewsJumpMenu = {
    attach: function (context, settings) {
      $('.js-viewsJumpMenu').on('change', function () {
        window.location = $(this).find(':selected').data('url');
      });
    }
  };
}(jQuery));
