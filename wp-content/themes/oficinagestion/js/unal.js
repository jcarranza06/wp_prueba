/*Buscador*/
"use strict";
(function() {
  var cx = '008572255874373046644:chip1p1uf-4';
  var gcse = document.createElement('script');
  gcse.type = 'text/javascript';
  gcse.async = true;
  gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
    '//www.google.com/cse/cse.js?cx=' + cx;
  var s = document.getElementsByTagName('script')[0];
  s.parentNode.insertBefore(gcse, s);
})();

function checkBck() {
  if (jQuery('.gsc-search-button input').attr('src')) {
    jQuery('.gsc-search-button input').attr('src', 'https://unal.edu.co/fileadmin/templates/images/search.png');
    jQuery('.gsc-input input').attr('placeholder', 'Buscar en la Universidad');
  } else {
    window.setTimeout(function() { checkBck(); }, 100);
  }
}
checkBck();

jQuery(document).ready(function($) {
  $('#unalOpenMenuServicios, #unalOpenMenuPerfiles').on('click',function(e) {
    var $target = $(this).data('target');
    var $mOffset = $(this).offset();
    $($target)
      .css({ top: $mOffset.top + $(this).outerHeight(), left: $mOffset.left })
  });
  function serviceMenuStatus() {
    var $s = $('#services');
    $s.height($(window).height());
    $('ul', $s).height($(window).height());

    if ($('.indicator', '#services').hasClass('active')) {
      $s.css({ 'right': 0 });
    } else {
      $s.css({ 'right': parseInt($('#services').width()) * -1 });
    }
  }

  $('.indicator', '#services').click(function() {
    $(this).toggleClass('active');
    serviceMenuStatus();
  });

  $(window).resize(function() {
    $('.open').removeClass('open');
    if ($(window).width() > 767) {
      $('#services').css({ 'right': parseInt($('#services').width()) * -1, left: 'auto', top: 'auto' });
      $('#bs-navbar').removeClass('in')
      serviceMenuStatus();
    } else {
      $('.indicator', '#services').removeClass('active');
    }
  });
  $('#services').css({ 'right': parseInt($('#services').width()) * -1 })
  serviceMenuStatus();

  //Sliders
  $('.slides-home').bxSlider({
      auto:true,
      pause:6000,
      adaptiveHeight: true,
      mode: 'fade',
      pager: false
  });

  // Efecto de submenu
  // $('#menu-menu-principal .menu-item-has-children').each(() => {
  //   console.log('Tengo un submenuuuuuu');
  //   $(this).hover(() => {
  //     console.log('Hover in item');
  //     $(this).find('.dropdown-menu').toggleClass('show-submenu');
  //   });
  // });

  $('#menu-menu-principal .menu-item-has-children').hover(function() {
    $(this).toggleClass('selected');
  });

  //Menu BS
  var linkMenu = $('.navbar-nav>li'),
      windowWd = $(window).width(),
      linkMenuHref = $('.navbar-nav>li>a');

      // $('.menu-item-has-children').hover(() => {
      //   $(this).find('.dropdown-menu').toggleClass('show-submenu');
      // })

      // if (windowWd >= 768){
      //     linkMenu.hover(function(e) {
      //       e.stopPropagation();
      //       $(this).children('ul.dropdown-menu').slideDown(400);
      //     }, function(e) {
      //       e.stopPropagation();
      //       $(this).children('ul.dropdown-menu').slideUp(400);
      //     });
      // }else {
      //   linkMenuHref.click(function(event) {
      //     event.preventDefault();
      //     $(this).siblings('ul.dropdown-menu').slideToggle();
      //   });
      // }
      //console.log('Hacer efecto con CSS');
      //Click toggle
      $('.navbar-toggle').click(function(event) {
        $('#bs-navbar').slideToggle(400);
      });
});


