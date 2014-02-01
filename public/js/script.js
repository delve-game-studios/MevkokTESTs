$(document).ready(function () {
  //  ================== TOP MENU ====================
$('#top-menu li').hover(function() {
    $('ul:first',this).css({visibility: "visible"}).fadeIn(200).show();

},function(){
     $('ul:first',this).css({visibility: "hidden",display: "hidden"}).fadeOut(200).hide();
});
  //  ================== NEWEST PRODUCTS ====================
$('.newest-products li').hover(function() {
 $(this).find('div').stop(true,true).animate({opacity: 1, top: 0},500);
 $(this).find('p').stop(true,true).delay(200).animate({opacity: 1, top: "35px"},700);

},function(){
 $(this).find('div').stop(true,true).animate({opacity: 1, top: "105px"},500);
 $(this).find('p').stop(true,true).animate({opacity: 0, top: "150px"},1000);
});
 //  ================== Read more ====================
$('.readMore, .watchVideo, .green-button').hover(function() {
    $(this).animate({opacity: 1,textShadow: "1px 1px 10px #fff"},500);

},function(){
    $(this).animate({opacity: 0.9},500);
});
  //  ================== TEXTURES ====================
$('.texture-container').hover(function() {
 $(this).find('.texture-description').stop(true,true).animate({opacity: 1, top: "0"},100);
 $(this).find('.texture-request').stop(true,true).animate({opacity: 1, bottom: "0"},100);
},function(){
 $(this).find('.texture-description').stop(true,true).animate({opacity: 0, top: "-20px"},100);
 $(this).find('.texture-request').stop(true,true).animate({opacity: 0, bottom: "-20"},100);
});



 //  ================== Read more ====================
$('.readMore, .watchVideo, .green-button').hover(function() {
    $(this).animate({opacity: 1,textShadow: "1px 1px 10px #fff"},500);

},function(){
    $(this).animate({opacity: 0.9},500);
});


  //  ================== MAIN SLIDER ====================
  $('div.jimgMenu ul li').hover(function() {
    
    // if the element is currently being animated (to a easeOut)...
    if ($(this).is(':animated')) {
      $(this).stop().animate({width: "600px"}, {duration: 450, easing:"easeOutQuad"});
      $(this).find('.slider-text').stop(true,true).animate({bottom: "0",opacity: 1},700);
      $(this).find('.caption span').stop(true,true).animate({opacity: 0},500);
    } else {
      // ease in quickly
      $(this).stop().animate({width: "600px"}, {duration: 400, easing:"easeOutQuad"});
      $(this).find('.slider-text').stop(true,true).animate({bottom: "0",opacity: 1},700);
      $(this).find('.caption span').stop(true,true).animate({opacity: 0},500);
    }
  }, function () {
    // on hovering out, ease the element out
    if ($(this).is(':animated')) {
      $(this).stop().animate({width: "100px"}, {duration: 400, easing:"easeInOutQuad"});
      $(this).find('.slider-text').stop(true,true).animate({bottom: "0",opacity: 0},700);
      $(this).find('.caption span').stop(true,true).animate({opacity: 1},500);
    } else {
      // ease out slowly
      $(this).stop('animated:').animate({width: "100px"}, {duration: 450, easing:"easeInOutQuad"});
      $(this).find('.slider-text').stop(true,true).animate({bottom: "0",opacity: 0},700);
      $(this).find('.caption span').stop(true,true).animate({opacity: 1},500);
    }
  });
});