
/*** Created by **************************************
Matthieu Bresson <bresson-matthieu_AT_orange_DOT_fr>
*************************************************/

/*
 * Many thanks to the people behind the JS libraries I have used:
 * - jQuery (http://jquery.com/)
 * - html5shiv (https://code.google.com/p/html5shiv/)
 * - jquery.validate (http://jqueryvalidation.org/)
 * - Magnific Popup (http://dimsemenov.com/plugins/magnific-popup/)
 */

(function ($) {


  /********************
  MAIN INITIALIZERS
  ********************/

  function on_document_ready() {
    var page = $('body').attr('id');

    $('header .menu-toggle').click(on_menu_toggle_click);

    switch(page) {
      case 'page-contact':
        page_contact_init();
        break;

      case 'page-works':
        page_works_init();
        break;

      case 'page-work':
        page_work_init();
        break;
    }
  }

  function page_contact_init() {
    var $form = $('#form-contact');

    $form.validate({
      errorClass: 'invalid',

      errorPlacement: function(error, element) {
        return; // hide inline elements
      },

      submitHandler: function(form) {
        on_form_submit($(form));
        return false;
      }
    });
  }

  function page_works_init() {
    $('.filters select').each(function() {
      $(this).change(on_filter_select_change);

      /*
       * Trigger the event in case the page was refreshed
       * and the selects have other values than 'all'.
       */
      $(this).change();
    });
  }

  function page_work_init() {
    if($('body').hasClass('category-photo')) {
      var src_object = $('a.album-link').data('link');

      $('a.album-link').magnificPopup({
        items: src_object,
        gallery: {
          enabled: true,
          preload: [1, 3]
        },

        type: 'image',

        retina: {
          ratio: 2,
        }
      });
    } else if($('body').hasClass('category-programming')) {
      $('.screenshots').magnificPopup({
        delegate: 'a',
        type: 'image',

        gallery: {
          enabled: true,
          preload: [1, 3]
        }
      });
    }
  }


  /********************
  FORM HANDLERS
  ********************/

  function form_get_data($form) {
    var $fields = $form.find("input, select, textarea");

    var data = {};

    $fields.each(function() {
      data[$(this).attr('name')] = $(this).val();
    });

    return data;
  }

  // this function hides the $form and shows the result $message
  function form_terminate($form, $message) {
    $form.slideUp(300, function() {
      $message.removeClass('hidden');
    }).removeClass('waiting');
  }

  // this function adds .invalid class to all given fields
  function form_update_fields($form, fields) {
    $form.find('input.invalid, textarea.invalid').removeClass('invalid');

 
    // if the captcha hasn't been correctly filled, change it with the new one sent by the server
    if($.inArray('mq', fields)) {
      $form.find('label[for="fi_mq"] img')
        .attr('src', 'data:image/png;base64,' + fields.mq);

      delete fields.mq;
    }

    $.each(fields, function(key, value) {
      $form.find(
        'input[name="' + value + '"], textarea[name="' + value + '"]'
      )
        .val("")
        .addClass('invalid');
    });

    $form
      .removeClass('waiting')
      .find('input, textarea').attr('readonly', false);

    // give focus to the first invalid or missing field
    $form.find('input[name="' + fields[0] + '"]').focus();
  }

  function on_form_submit($form) {
    var data = form_get_data($form);
    if (data === null) {
      return false;
    }

    data.form_id = $form.attr('id');

    // add active class to the form waiting for an AJAX answer
    $form.addClass('waiting');

    // make the whole form readonly
    $form.find('input, textarea').attr('readonly', true);

    // post the data
    $.ajax({
      url: "contact/post",
      error: on_form_ajax_error,
      success: on_form_result,
      timeout: on_form_ajax_error,
      type: "POST",
      dataType: "json",
      'data': data
    });

    return false;
  }

  function on_form_ajax_error(t, n, r) {
    $("form.waiting").slideUp(300, function () {
      $("#failure_connection").removeClass('hidden');
    }).removeClass('waiting');
  }

  function on_form_result(t, n) {
    var $form = $('form.waiting');

    /*
     * This function removes the form in case of success or critical error
     * (then it displays the corresponding success or error message).
     *
     * If the error is not critical (a field is missing or is invalid, e.g. the captcha is wrong),
     * the form is updated to inform the user about the fields he must correctly fill.
     */

    if(t.ok) {
      form_terminate($form, $('.hidden.success'));
    } else {
      switch(t.error) {
        case 'session expired':
          form_terminate($form, $('#failure_session'));
          break;

        case 'server':
          form_terminate($form, $('#failure_server'));
          break;

        case 'missing fields':
          form_update_fields($form, t.missing);
          break;

        case 'invalid fields':
          form_update_fields($form, t.invalid);
          break;
      }
    }
  }


  /********************
  WORKS FILTERS UTILITIES
  ********************/

  /*
   * This function returns the name of the $filter
   * e.g. we have a select filter with the following classes:
   * .classA .filter-name-category .classC
   * this function will return 'category'.
   */
  function filter_get_name($filter) {
    var classes = $filter.attr('class');
    var name_delim = 'filter-name-';

    var index_start = classes.search(name_delim) + name_delim.length;
    var first_slice = classes.substr(index_start);

    var index_stop = first_slice.search(' ');
    if(index_stop < 0) { // no other classes after 'filter-name-*'
      return first_slice;
    } else {
      return first_slice.substr(0, index_stop);
    }
  }

  function on_filter_select_change() {
    var filter = filter_get_name($(this));
    if(filter === 'category') {
      // display the description of the category
      $('.category-description').hide();
      $('.category-description.category-' + $(this).val()).show();
    }

    // build a jQuery selector based on classes
    var selector = $('.filters select').map(function() {

      var value = $(this).val();
      if(value === 'all') {
        return;
      }

      var filter = filter_get_name($(this));

      return '.' + filter + '-' + value;
    }).get().join('');

    var $showcase = $('.showcase');

    if(selector === '') {
      $showcase.children('li').fadeIn(200);
      return;
    }

    if($showcase.children('li' + selector).length === 0) {
      $('#no_result').show();
    } else {
      $('#no_result').hide();
    }

    $showcase.children('li:not(' + selector + ')').hide();
    $showcase.children('li' + selector).fadeIn(200);
  }


  /********************
  EVENT LISTENERS
  ********************/

  function on_menu_toggle_click() {
    $('nav').slideToggle(300);
  }


  /********************
  SET INIT HANDLERS
  ********************/

  $(document).ready(on_document_ready);

})(jQuery);

