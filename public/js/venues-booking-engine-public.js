(function($) {
  'use strict';

  /**
   * All of the code for your public-facing JavaScript source
   * should reside in this file.
   *
   * Note: It has been assumed you will write jQuery code here, so the
   * $ function reference has been prepared for usage within the scope
   * of this function.
   *
   * This enables you to define handlers, for when the DOM is ready:
   *
   * $(function() {
   *
   * });
   *
   * When the window is loaded:
   *
   * $( window ).load(function() {
   *
   * });
   *
   * ...and/or other possibilities.
   *
   * Ideally, it is not considered best practise to attach more than a
   * single DOM-ready or window-load handler for a particular page.
   * Although scripts in the WordPress core, Plugins and Themes may be
   * practising this, we should strive to set a better example in our own work.
   */

  $(function() {
    var sale_price = $("[name='sp']");
    var price = $("[name='p']");
    var price_val = price.val();
    var sp_val = sale_price.val();
    var realPrice,
      total = $('.total_price_cart'),
      currC = $('.cseess-urrency').text();
    var total_oldVal = total.text();
    var qtyV = $('.min-witty');

    $(".cart-btn-cheesz[type='submit']").attr('disabled', 'disabled');

    if (sp_val > price_val) {
      realPrice = sp_val;
    } else {
      realPrice = price_val;
    }

    qtyV.on('change', function() {
      var newToal = realPrice * $(this).val();
      if (newToal <= 0)
        $(".cart-btn-cheesz[type='submit']").attr('disabled', 'disabled');
      if (newToal > 0) {
        total.text(currC + newToal);
        $(".cart-btn-cheesz[type='submit']").removeAttr('disabled');
      } else {
        total.text(total_oldVal);
      }
    });
  });
})(jQuery);
