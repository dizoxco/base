<nav class="nav fixed w-full flex items-center z-50" id="nav">
  <div class="container flex items-center">
   <ul class="nav__icons w-1/5">
     <li><a href="#"><i class="material-icons cart-icon">shopping_basket</i></a></li>
     <li><a href="#"><i class="material-icons wishlist-icon">favorite_border</i></a></li>
     <li><a href="#"><i class="material-icons login-icon">person_outline</i></a></li>
     <li><a href="#"><i class="material-icons search-icon">search</i></a></li>
   </ul>
   <ul class="nav__menu w-full text-center">
     <li class="nav__item">
       <a href="#">Home</a>
         <ul class="nav__sheet-col">
           <li class="nav__list">
             <a href="#">کتگوری ۱</a>
             <ul>
               <li><a href="#">آیتم اول</a></li>
               <li><a href="#">آیتم دوم</a></li>
               <li><a href="#">آیتم سوم</a></li>
               <li><a href="#">fourth item</a></li>
               <li><a href="#">fifth item</a></li>
               <li><a href="#">sixth item</a></li>
               <li><a href="#">seventh item</a></li>
             </ul>
           </li>
           <li class="nav__list">
             <a href="#">کتگوری ۲</a>
             <ul>
               <li><a href="#">آیتم اول</a></li>
               <li><a href="#">آیتم دوم</a></li>
               <li><a href="#">آیتم سوم</a></li>
               <li><a href="#">fourth item</a></li>
               <li><a href="#">fifth item</a></li>
               <li><a href="#">sixth item</a></li>
               <li><a href="#">seventh item</a></li>
             </ul>
           </li>
           <li class="nav__list">
             <a href="#">کتگوری ۳</a>
             <ul>
               <li><a href="#">آیتم اول</a></li>
               <li><a href="#">آیتم دوم</a></li>
               <li><a href="#">آیتم سوم</a></li>
               <li><a href="#">fourth item</a></li>
               <li><a href="#">fifth item</a></li>
               <li><a href="#">sixth item</a></li>
               <li><a href="#">seventh item</a></li>
             </ul>
           </li>
           <li class="nav__list">
             <a href="#">کتگوری ۴</a>
             <ul>
               <li><a href="#">آیتم اول</a></li>
               <li><a href="#">آیتم دوم</a></li>
               <li><a href="#">آیتم سوم</a></li>
               <li><a href="#">fourth item</a></li>
               <li><a href="#">fifth item</a></li>
               <li><a href="#">sixth item</a></li>
               <li><a href="#">seventh item</a></li>
             </ul>
           </li>
         </ul>
     </li>
     <li class="nav__item"><a href="#">Woman</a></li>
     <li class="nav__item"><a href="#">Men</a></li>
     <li class="nav__item"><a href="#">Children</a></li>
     <li class="nav__item"><a href="#">Contact</a></li>
   </ul>
   <div class="nav__logo-box w-1/3 text-left">
     <a href="#"><img src="/images/menu-logo.png" alt="" class="nav__logo"></a>
   </div>
  </div>
 </nav>
 




<div class="glass fixed t-0 r-0 w-full h-full z-60 "></div>

<div class="side absolute t0 r0 w-full bg-white h-full z-70">
    <div class="close">
      <span class="close__cross"></span>
    </div>
    <div class="side__cart">
      <div class="side__cart-container">
        cart
      </div>
    </div>

    <div class="side__wishlist">
      <div class="side__wishlist-container">
        wishlist
      </div>
    </div>

    <div class="side__login flex h-full p-16 pt-32">
      <div class="side__login-container w-full text-center">
        <h6 class="mb-8">به حساب کاربری خود وارد شوید</h6>
        <form action="">
          <div><input type="text" placeholder="ایمیل"></div>
          <div><input type="text" placeholder="رمز عبور"></div>
          <div class="flex justify-between">
              <div><input type="checkbox">مرا به خاطربسپار<br></div>
              <a href="#">فراموشی رمز عبور</a>
          </div>
          <button>وارد شوید</button>
        </form>
        <div><button>با گوگل وارد شوید</button></div>
        <div><button>ثبت نام</button></div>
      </div>
    </div>

    <div class="side__register flex h-full p-16 pt-32">
      <div class="side__register-container w-full text-center">
          <h6 class="mb-8">ثبت نام</h6>
          <form action="">
              <div><input type="text" placeholder="ایمیل"></div>
              <div><input type="text" placeholder="رمز عبور"></div>
              <div class="flex">
                  <div><input type="checkbox"><span><a href="#">شرایط و قوانین</a>  را قبول دارم</span><br></div>
              </div>
              <button>ثبت نام</button>
            </form>
            <div><button>وارد شوید</button></div>
      </div>
    </div>

    <div class="side__forgot flex h-full p-16 pt-32">
      <div class="side__forgot-container w-full text-center">
          <h6 class="mb-8">بازیابی رمز عبور</h6>
          <form action="">
              <div><input type="text" placeholder="ایمیل"></div>
              <button>ارسال لینک بازیابی</button>
            </form>
            <div><button>بازگشت</button></div>
      </div>
    </div>

    <div class="side__reset-password flex h-full p-16 pt-32">
        <div class="side__reset-password-container w-full text-center">
            <h6 class="mb-8">تغییر رمز عبور</h6>
            <form action="">
                <div><input type="text" placeholder="ایمیل"></div>
                <div><input type="text" placeholder="رمز عبور"></div>
                <div><input type="text" placeholder="تکرار رمز عبور"></div>
                <button>تغییر رمز عبور</button>
              </form>
              <div><button>بازگشت به ورود</button></div>
        </div>
      </div>


  </div>

 
 
 {{-- <div class="nav__search">
   <div class="nav__search-div">
       <input type="text" placeholder="جستجو" class="nav__search-box">
       <div class="nav__search-result">
         <ul class="nav__search-result-list">
           <li class="nav__search-result-item">
             <img src="/images/product.jpg" alt="">
             <a href="#"> display product number one </a>
           </li>
           <li class="nav__search-result-item">
             <img src="/images/product.jpg" alt="">
             <a href="#"> display product number one </a>
           </li>
           <li class="nav__search-result-item">
             <img src="/images/product.jpg" alt="">
             <a href="#"> display product number one </a>
           </li>
           <li class="nav__search-result-item">
             <img src="/images/product.jpg" alt="">
             <a href="#"> display product number one </a>
           </li>
           <li class="nav__search-result-item">
             <img src="/images/product.jpg" alt="">
             <a href="#"> display product number one </a>
           </li>
           <li class="nav__search-result-item">
             <img src="/images/product.jpg" alt="">
             <a href="#"> display product number one </a>
           </li>
         </ul>
       </div>
   </div>
 </div> --}}
 
 
 <header class="header-mobile">
   <div class="nav-mobile__bar">
     <div class="nav-mobile__bar-container">
       <div class="nav-mobile__bar-menu-btn toggler" toggle="menu-toggle" id="menu-btn">
         <div class="nav-mobile__bar-burger  menu-toggle">
           <span>&nbsp;</span>
         </div>
       </div>
       <img src="/images/menu-logo.png" alt="">
       <div class="nav-mobile__bar-search">
         <ul>
           <li><a href="#"><i class="material-icons search-icon">search</i></a></li>
           <li><a href="#"><i class="material-icons">shopping_basket</i></a></li>
         </ul>
       </div>
     </div>
   </div>
 </header>
 <nav class="nav-mobile menu-toggle">
   <div class="nav-mobile__utility menu-toggle">
     <ul>
       <li><a href="#"><i class="material-icons">favorite_border</i></a></li>
       <li><a href="#"><i class="material-icons">person_outline</i></a></li>
     </ul>
   </div>
   <div class="nav-mobile__main">
     <ul class="nav-mobile__list">
       <li>
         <a class="js-open" href="#">کتگوری شماره ۱</a>
         <i class="material-icons">add_circle_outline</i>
         <i class="material-icons">remove_circle_outline</i>
         <ul class="nav-mobile__list-sub1">
           <li>
             <i class="material-icons">add_circle_outline</i>
             <i class="material-icons">remove_circle_outline</i>
             <a  href="#">زیر دسته سطح ۱</a>
             <ul class="nav-mobile__list-sub2">
               <li><a href="#">زیر دسته سطح ۲</a></li>
               <li><a href="#">زیر دسته سطح ۲</a></li>
               <li><a href="#">زیر دسته سطح ۲</a></li>
             </ul>
           </li>
         </ul>
       </li>
       <li>
         <a class="js-open" href="#">کتگوری شماره ۲</a>
         <i class="material-icons">add_circle_outline</i>
         <i class="material-icons">remove_circle_outline</i>
         <ul class="nav-mobile__list-sub1">
           <li>
             <a href="#">زیر دسته سطح ۱</a>
             <i class="material-icons">add_circle_outline</i>
             <i class="material-icons">remove_circle_outline</i>
             <ul class="nav-mobile__list-sub2">
               <li><a href="#">زیر دسته سطح ۲</a></li>
               <li><a href="#">زیر دسته سطح ۲</a></li>
               <li><a href="#">زیر دسته سطح ۲</a></li>
             </ul>
           </li>
         </ul>
       </li>
       <li>
         <a class="js-open" href="#">کتگوری شماره ۳</a>
           <i class="material-icons">add_circle_outline</i>
           <i class="material-icons">remove_circle_outline</i>
         <ul class="nav-mobile__list-sub1">
           <li>
             <a href="#">زیر دسته سطح ۱</a>
             <i class="material-icons">add_circle_outline</i>
             <i class="material-icons">remove_circle_outline</i>
             <ul class="nav-mobile__list-sub2">
               <li><a href="#">زیر دسته سطح ۲</a></li>
               <li><a href="#">زیر دسته سطح ۲</a></li>
               <li><a href="#">زیر دسته سطح ۲</a></li>
             </ul>
           </li>
         </ul>
       </li>
     </ul>
   </div>
 </nav>
     
 
 <script>
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
 
 document.querySelector(".nav-mobile__bar-menu-btn").addEventListener("click", function () {
   document.querySelector(".nav-mobile__bar-burger").classList.toggle("active");
 });
 
 document.querySelector(".nav-mobile__bar-menu-btn").addEventListener("click", function () {
   document.querySelector(".nav-mobile").classList.toggle("active");
 
 });
 
 document.querySelector(".cart-icon").addEventListener("click", function (e) {
   console.log("cart");
 
   document.querySelector(".side").classList.toggle("active");
   document.querySelector(".side__cart").classList.toggle("active");
   document.querySelector(".glass").classList.toggle("active");

  });

 document.querySelector(".glass").addEventListener("click", function(e){
        document.querySelector(".side").classList.toggle("active");
        document.querySelector(".side__cart").classList.toggle("active");
        document.querySelector(".glass").classList.toggle("active");
        console.log("cart");
 });

 document.querySelector(".close").addEventListener("click", function(e){
        document.querySelector(".side").classList.toggle("active");
        document.querySelector(".side__cart").classList.toggle("active");
        document.querySelector(".glass").classList.toggle("active");
        console.log("cart");
 });
 
 var menuItem = document.querySelectorAll(".nav-mobile__list a");
 for (var i=0; i<menuItem.length; i++) {
   menuItem[i].addEventListener("click", function(e){
     this.parentNode.querySelector("ul").classList.toggle("active");
     this.parentNode.querySelector("i").classList.toggle("active");
   });
 }
 
 
 var menuFlesh = document.querySelectorAll(".nav-mobile__list a");
 for (var i=0; i<menuFlesh.length; i++) {
   // console.log(menuFlesh[i]);
 }
 

 
 </script>