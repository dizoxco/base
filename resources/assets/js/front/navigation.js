var prevScrollpos = window.pageYOffset;
 window.onscroll = function() {
 var currentScrollPos = window.pageYOffset;
   if (prevScrollpos > currentScrollPos) {
     document.getElementById("nav").style.top = "0";
   } else {
     document.getElementById("nav").style.top = "-64px";
   }
   prevScrollpos = currentScrollPos;
 }
 
$('[glass]').click(function(e){
    e.preventDefault();
    var target = $($(this).attr('glass'));
    target.find('input').first().focus();    
    if (target.hasClass('over-glass')) {
        $('.glass').removeClass('active');
        $('body').removeClass('overflow-hidden');
        target.removeClass('over-glass');
    }else{
        $('.glass').addClass('active');
        $('body').addClass('overflow-hidden');
        target.addClass('over-glass');
    }
});
$('.glass').click(function(){
    $(this).removeClass('active');
    $('body').removeClass('overflow-hidden');
    $('.over-glass').removeClass('over-glass');
});
 
$('[side-content]').click(function(){
    $('.side .side-content.active').removeClass('active');
    $($(this).attr('side-content')).addClass('active');
});

 document.querySelector(".nav-mobile__bar-menu-btn").addEventListener("click", function () {
    document.querySelector(".nav-mobile__bar-burger").classList.toggle("active");
  });
  
  document.querySelector(".nav-mobile__bar-menu-btn").addEventListener("click", function () {
    document.querySelector(".nav-mobile").classList.toggle("active");
  
  });

$('.nav-mobile a').click(function(e){
  
  if($(this).parent().find('ul')[0]){
    e.preventDefault();
    // $('.nav-mobile .active').removeClass('active');
    $(this).parent().toggleClass('active');
  }
});

$('#srch').keyup(function(){
  if ($(this).val()) {
    $.get( "/srch/"+$(this).val(), function( data ) {
      $( ".mega-search__result" ).html( data );
    }, 'html').fail(function(){
      console.log('srch error');
    });
  }else {
    $( ".mega-search__result" ).html("");
  }
});