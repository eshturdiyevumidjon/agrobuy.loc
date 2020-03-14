$(document).ready(function () {

  // $('.form-group.password_hidden').after($('span#password_hidden_show'))

  $('span#password_hidden_show').on('click', function(){
    $(this).toggleClass('active');
    if($(this).hasClass('active')){
      $(this).prev().find('input').attr('type', 'text'); 
    }
    else{
      $(this).prev().find('input').attr('type', 'password'); 
    }
  })


	var minh = $(window).height() - $('header').height() - $('footer').height() - 40 +'px';

	$('.content_class').css('min-height', minh);

	var swiper_recl = new Swiper('.swiper-container.reclama', {
      loop: true,
      autoplay: {
        delay: 5000
      },
      simulateTouch: true
    });

  $('.fileinput-button.dz-clickable').on('click', function(event){
    event.stopPropagation()
    $('input#ads-imagefiles').trigger('click')
  })

  $('.fileinput-button.dz-clickable.passport_image').on('click', function(event){
    event.stopPropagation()
    $('input#users-passport_image').trigger('click')
  })

  $('.fileinput-button.dz-clickable.company_image').on('click', function(event){
    event.stopPropagation()
    $('input#users-company_image').trigger('click')
  })

  /*$('#ads_file_a_teg').on('click', function(e){
    e.preventDefault()
    $('button#ads_file').trigger('click')
  })*/

  $('#ads_file_a_teg1').on('click', function(e){
    e.preventDefault()
    $('button#ads_file1').trigger('click')
  })

  $('[data-fancybox]').fancybox();

  $('.category-main-item').on('click', function(){
    if($(this).next().hasClass('opened-cat')){
        $(this).parent().find('.select-category-popup').removeClass('opened-cat')
        // $(this).next('.select-category-popup').toggleClass('opened-cat')
    }
    else {
      $(this).parent().find('.select-category-popup').removeClass('opened-cat')
        $(this).next('.select-category-popup').toggleClass('opened-cat')
    }

  })

  if ($(window).width() < 1023) {

    // $('.chat-main-left .item-chat a.chat_12').on('click', function(e){
    //   e.preventDefault()
    //   $('.chat-main').addClass('visible-chat')
    // })

    $('.mob-back-chat a').on('click', function(e){
      // e.preventDefault()
      $('.chat-main').removeClass('visible-chat')
    })

  }

  if ($(window).width() > 767) {
    if($('div').hasClass('fixed-baner')){
      var fixed_block = $('.fixed-baner').offset().top;
      $(window).scroll(function() {    
          var scroll = $(window).scrollTop()
          // console.log(fixed_block)
          if (scroll >= fixed_block) {
              $('.fixed-baner').addClass("fixed-go");
              $('.category-body-left-in').addClass("fixed-got")
          }
          else {
              $('.fixed-baner').removeClass("fixed-go");
              $('.category-body-left-in').removeClass("fixed-got")
          }
      })
    }
  }

  $('.cat-open').on('click', function(){
    $(this).parent().toggleClass('actived')
    $(this).parent().find('ul').slideToggle(300)
    $(this).parent().siblings().removeClass('actived')
    $(this).parent().siblings().find('ul').slideUp(300)
  })

  $('input[type=text][name=secondname]').tooltip({ /*or use any other selector, class, ID*/
      placement: "top",
      trigger: "focus"
  });

  $('.main-list-of-required p').on('click', function(){
    $(this).next().slideToggle()
    $(this).toggleClass('active')
  })

  var textarea = document.querySelector('.chat-main-right textarea');

  if(textarea){
    textarea.addEventListener('keydown', autosize);
  }

  $('.mob-language>span').on('click', function(){
    $(this).parent().toggleClass('actived')
  })

  $('body').click(function(e){
      if(!$(e.target).is('.mob-language>span')) {
          $('.mob-language').removeClass('actived');
      }
  })
             
  function autosize(){
    var el = this;
    setTimeout(function(){
      el.style.cssText = 'height:auto; padding:0';
      el.style.cssText = 'height:' + el.scrollHeight + 'px';
    },0);
  }
  
  $(".js-select2").select2();
  
  $('span.star-item').on('click', function(){
    $(this).toggleClass('active')
  })

  /*$('span#dropdownMenuButton').on('click', function(){
    $(this).toggleClass('actived');
    $('.drops').slideToggle(100);
  })*/

  // $('.pp span:nth-child(5)').trigger('click')

  var swiper1 = new Swiper('.main-slider', {
    effect: 'fade',
    navigation: {
      nextEl: '.main-slider .swiper-button-next',
      prevEl: '.main-slider .swiper-button-prev',
    },
    pagination: {
      clickable: true,
      el: '.main-slider .swiper-pagination',
    },
    loop: true,
    coverflowEffect: {
      rotate: 30,
      slideShadows: false,
    }
  });

  var swiper2 = new Swiper('.swiper-news.swiper-container', {
      slidesPerView: 3,
      spaceBetween: 20,
      loop: true,
      navigation: {
        nextEl: '.for-swiper-container .swiper-button-next',
        prevEl: '.for-swiper-container .swiper-button-prev',
      },
      breakpoints:{
        320:{
          centeredSlides: true,
          slidesPerView: 'auto'
        },
        991:{
          centeredSlides: true,
          slidesPerView: 'auto',
          navigation: 'none',
          autoplay: true
        },
      }
    });

  var swiper3 = new Swiper('.growing .swiper-container', {
      slidesPerView: 4,
      spaceBetween: 20,
      loop: true,

      navigation: {
        nextEl: '.growing .swiper-button-next',
        prevEl: '.growing .swiper-button-prev',
      },
      breakpoints:{
        320:{
          centeredSlides: true,
          slidesPerView: 'auto'
        },
        991:{
          centeredSlides: true,
          slidesPerView: 3,
          navigation: 'none',
          autoplay: {
            delay: 5000
          },
        },
      }
    });

  var swiper4 = new Swiper('section.similar-ads .swiper-container', {
      slidesPerView: 4,
      spaceBetween: 20,
      loop: true,
      navigation: {
        nextEl: 'section.similar-ads .swiper-button-next',
        prevEl: 'section.similar-ads .swiper-button-prev',
      },
      breakpoints:{
        767:{
          slidesPerView: 2,
          slidesPerColumn: 2,
          loop: false,
          pagination: {
            el: 'section.similar-ads .swiper-pagination',
            clickable: true,
            renderBullet: function (index, className) {
              return '<span class="' + className + '">' + (index + 1) + '</span>';
            },
          },

        },
        1023:{
          centeredSlides: true,
          slidesPerView: 2.2,
        },
        1200:{
          slidesPerView: 3,
          autoplay: {
            delay: 5000
          },
        },
      }
    });

  var galleryThumbs = new Swiper('.gallery-thumbs', {
      spaceBetween: 25,
      slidesPerView: 3,
      freeMode: true,
      watchSlidesVisibility: true,
      watchSlidesProgress: true,
      breakpoints:{
        767:{
          direction: 'vertical',
          spaceBetween: 10
        }
      },

    });

    var galleryTop = new Swiper('.gallery-top', {
      spaceBetween: 10,
      autoplay: {
        delay: 3000
      },
      breakpoints:{
        767:{
          spaceBetween: 0,
        }
      },
      // navigation: {
      //   nextEl: '.gallery-top .swiper-button-next',
      //   prevEl: '.gallery-top .swiper-button-prev',
      // },
      thumbs: {
        swiper: galleryThumbs
      }
    });

  if ($(window).width() < 768) {

    $('.similar-ads .swiper-pagination').append($('.similar-ads.pagination-styles .swiper-button-next'))

    $('.similar-ads .swiper-pagination').append($('.similar-ads.pagination-styles .swiper-button-prev'))

    $('.ftr-bottom .container>.row').append($('a.privacy-policy'))

    $('.hdr-bottom ul').after($('header a.btn-template'))

    $('.user-li').append($('a.entor-to-site'))

    $('header').append($('form.form-search'))

    // $('header .logo').after($('.languages-group'));

    $('.open-filter').on('click', function(e){
      e.preventDefault();
      $('form.form-search').slideToggle()
    })

    // $('.open-filter').trigger('click')

    $('form.form-search').css('display', 'none')

    $('.category-body-left-in .category-title').on('click', function(){
      $(this).next().slideToggle()
      $(this).toggleClass('open')
    })

    $('body').click(function(e){
        if(!$(e.target).is('.category-body-left-in .category-title, .category-body-left-in ul.categ *')) {
            $('.category-body-left-in .category-title').next().slideUp()
            $('.category-body-left-in .category-title').removeClass('open');
        }
    })

  }
})


/******************************CAPTCHA**************************************/
if($('#registration-2').find('#captcha').length !== 0){
  var code;
    function createCaptcha() {
      //clear the contents of captcha div first 
      document.getElementById('captcha').innerHTML = "";
      var charsArray =
      "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@!#$%^&*";
      var lengthOtp = 5;
      var captcha = [];
      for (var i = 0; i < lengthOtp; i++) {
        //below code will not allow Repetition of Characters
        var index = Math.floor(Math.random() * charsArray.length + 1); //get the next character from the array
        if (captcha.indexOf(charsArray[index]) == -1)
          captcha.push(charsArray[index]);
        else i--;
      }
      var canv = document.createElement("canvas");
      canv.id = "captcha2";
      canv.width = 100;
      canv.height = 50;
      var ctx = canv.getContext("2d");
      ctx.font = "25px Georgia";
      ctx.strokeText(captcha.join(""), 0, 30);
      //storing captcha so that can validate you can save it somewhere else according to your specific requirements
      code = captcha.join("");
      document.getElementById("captcha").appendChild(canv); // adds the canvas to the body element
    }
    createCaptcha();
}
/******************************CAPTCHA**************************************/
