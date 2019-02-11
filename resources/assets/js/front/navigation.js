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
 // document.querySelector('#menu-btn').addEventListener('click', function () {
 //   document.querySelector('.nav-mobile').style.right = 0;
 //   document.querySelector('.nav-mobile__utility').style.right = 0;
 // });
 
 // document.querySelector('.toggler').addEventListener('click', function () {
 //   var list = document.getElementsByClassName(this.getAttribute('toggle'));
 //   for (let item of list) {
 //     item.classList.toggle('active');
 //   }  
 // });
 
//  var search = document.querySelectorAll(".search-icon");
//  for (var i=0; i<search.length; i++){
//    search[i].addEventListener("click", function () {
//      document.querySelector(".nav__search-box").classList.toggle("active");
//      document.querySelector(".nav__search").classList.toggle("active");
//    });
//  }
 
//  document.querySelector(".nav__search").addEventListener("click", function (e) {
//    console.log(e.target);
   
//    var searchBox = document.querySelector(".nav__search-box");
//    if (e.target !== searchBox) {
//      document.querySelector(".nav__search-box").classList.toggle("active");
//    document.querySelector(".nav__search").classList.toggle("active");
//    }
   
//  });
 

 
//  document.querySelector(".cart-icon").addEventListener("click", function (e) {
//    console.log("cart");
 
//    document.querySelector(".side").classList.toggle("active");
//    document.querySelector(".side__cart").classList.toggle("active");
//    document.querySelector(".glass").classList.toggle("active");

//   });

//  document.querySelector(".glass").addEventListener("click", function(e){
//         document.querySelector(".side").classList.toggle("active");
//         document.querySelector(".side__cart").classList.toggle("active");
//         document.querySelector(".glass").classList.toggle("active");
//         console.log("cart");
//  });

//  document.querySelector(".close").addEventListener("click", function(e){
//         document.querySelector(".side").classList.toggle("active");
//         document.querySelector(".side__cart").classList.toggle("active");
//         document.querySelector(".glass").classList.toggle("active");
//         console.log("cart");
//  });
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

// $(".search-icon").click(function () {
//   $(".mega-search").addClass("active");
//   $(".glass").addClass("active");
// });

 document.querySelector(".nav-mobile__bar-menu-btn").addEventListener("click", function () {
    document.querySelector(".nav-mobile__bar-burger").classList.toggle("active");
  });
  
  document.querySelector(".nav-mobile__bar-menu-btn").addEventListener("click", function () {
    document.querySelector(".nav-mobile").classList.toggle("active");
  
  });

//  var menuItem = document.querySelectorAll(".nav-mobile__list a");
//  for (var i=0; i<menuItem.length; i++) {
//   //  console.log(menuItem[i]);
   
//    menuItem[i].addEventListener("click", function(e){
//     $('.nav-mobile__list .active').removeClass('active');
//      this.parentNode.querySelector("ul").classList.toggle("active");
//     //  this.parentNode.querySelector("i").classList.toggle("active");
//    });
//  }
 
 
//  var menuFlesh = document.querySelectorAll(".nav-mobile__list a");
//  for (var i=0; i<menuFlesh.length; i++) {
//    // console.log(menuFlesh[i]);
//  }

$('.nav-mobile a').click(function(e){
  
  if($(this).parent().find('ul')[0]){
    e.preventDefault();
    // $('.nav-mobile .active').removeClass('active');
    $(this).parent().toggleClass('active');
  }
})

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