(function($) {
  'use strict';

  /**
   * All of the code for your admin-facing JavaScript source
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
    // store the variables for the application
    var repeaterWrapper = $('#repeater-wrapper');

    /**
     * repeatable rows
     */
    repeaterWrapper.on('click', '[data-repeater]', function(e) {
      var template = $(this).data('template');

      // traverse the dom tree to find the repeatable elements
      var repeatableRow = $(this)
        .parent()
        .parent()
        .parent()
        .parent()
        .find('.container#repeater-wrapper-inside');

      // apend the row on click
      repeatableRow.append(template);

      return false;
    });

    /**
     * delete repeated rows
     */
    repeaterWrapper.on('click', '[data-repeater-delete]', function(e) {
      // traverse the dom tree to find the repeatable elements
      var repeatableRow = $(this)
        .parent()
        .parent()
        .parent()
        .closest('.container#repeater-wrapper-inside .repeater-wrapper');

      console.log(repeatableRow);

      // apend the row on click
      repeatableRow.remove();

      return false;
    });

    /**
     * activate select2 on select fields
     */
    if ($.fn.select2) $('.cc_select2_args').select2();

    /**
     * made sure the date and time fields are readonly
     */
    $('#date_sent, #time_sent').attr('readonly', '');
  });
})(jQuery);
