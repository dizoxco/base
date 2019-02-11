<nav class="nav fixed w-full flex items-center z-50" id="nav">
  <div class="container justify-between flex items-center relative">
   <ul class="nav__icons pin-l absolute md:relative md:pin-r">
     <li class="cart-icon"><a href="#"><i class="material-icons" glass=".side" side-content=".side-content.cart">shopping_basket</i></a></li>
     <li class="wishlist-icon hidden"><a href="#"><i class="material-icons" glass=".side" side-content=".side-content.wishlist">favorite_border</i></a></li>
     <li class="login-icon hidden"><a href="#"><i class="material-icons" glass=".side" side-content=".side-content.login">person_outline</i></a></li>
     <li class="search-icon"><a href="#"><i class="material-icons" glass=".mega-search">search</i></a></li>
   </ul>
   {{nav('main', 'nav__menu w-full text-center hidden md:block')}}
   <div class="nav-mobile__bar-menu-btn toggler md:hidden" id="menu-btn" glass=".side" side-content=".side-content.mobile-menu">
    <div class="nav-mobile__bar-burger  menu-toggle ">
      <span>&nbsp;</span>
    </div>
    </div>
    <div class="nav__logo-box  w-24 absolute m-auto pin-x md:w-48 md:relative md:">
     <a href="#"><img src="/images/menu-logo.png" alt="" class="nav__logo"></a>
    </div>
  </div>
</nav>



<div class="glass fixed t-0 r-0 w-full h-full z-60 "></div>

<div class="side fixed t0 r0 w-full bg-white h-full z-70">

    <div class="close" glass=".side">
        <span class="close__cross"></span>
    </div>

    <div class="side-content empty-cart flex h-full p-16 pt-32 hidden">
        <div class="side__cart-empty-container w-full text-center">
            <h6 class="mb-8">سبد خرید شما خالی است</h6>
            <div class="side__cart-empty-img">
                <img src="/images/empty-cart.png" alt="">
            </div>
        </div>
    </div>

    <div class="side-content cart flex h-full p-8 pt-32 hidden overflow-auto">
        <div class="side__cart-container w-full text-center ">
            <div>
                <div class="flex justify-around bg-black h-12 items-center rounded-full">
                    <span class="text-white">مبلغ کل خرید:</span><span class="font-bold text-white">۲٫۴۹۵٫۰۰۰<span>&ThickSpace;</span><span>تومان</span></span>
                </div>
            </div>
            <div class="side__cart-product mt-2 flex py-5 px-5">
                <div class="side__cart-product-img w-1/3">
                    
                </div>
                <div class="side__cart-product-detail caption pr-2">
                    <div class="side__cart-product-name">
                        دامن کوتاه خال خالی
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="side-content wishlist flex h-full p-16 pt-32">
        <div class="side__wishlist-container w-full text-center">
            <h6 class="mb-8">کمد لباس شما خالی است</h6>
            <div class="side__wishlist-empty-img">
                <img src="/images/empty-wishlist.png" alt="">
            </div>
        </div>
    </div>

    <div class="side-content login flex h-full p-10 pt-32">
        <div class="side__login-container w-full text-center">
            <h6 class="mb-8">به حساب کاربری خود وارد شوید</h6>
            <form action="{{ route("login") }}" method="post" id="frm_side_login">
                {{ csrf_field() }}
                @component('components.form.text',[
                  'label' => 'ایمیل',
                  'full' => true,
                  'name' => 'login_email',
                ])
                @endcomponent
                @component('components.form.text',[
                  'label' => 'رمز عبور',
                  'full' => true,
                  'name' => 'login_password',
                  'type' => 'password'
                ])
                @endcomponent
                <div class="flex justify-between">
                    <div><input type="checkbox">مرا به خاطربسپار<br></div>
                    <a href="#" side-content=".side-content.forgot">فراموشی رمز عبور</a>
                </div>
                @component('components.form.button',[
                  'label' => 'اینجا کلیک کنید',
                  'full' => true,
                  'name' => 'btn_side_login'
                ])
                @endcomponent
                @component('components.form.button',[
                  'label' => 'وارد شوید',
                  'full' => true,
                  'checkbox' => true,
                ])
                @endcomponent
            </form>
            @component('components.form.button',[
              'label' => 'ورود با گوگل',
              'full' => true,
              'dense' => true,
            ])
            @endcomponent
            <br>
            <span side-content=".side-content.register">
        @component('components.form.button',[
          'label' => 'ثبت نام',
          'full' => true,
          'type' => 'text',
        ])
                @endcomponent
      </span>
        </div>
    </div>

    <div class="side-content register flex h-full p-10 pt-32">
        <div class="side__register-container w-full text-center">
            <h6 class="mb-8">ثبت نام</h6>
            <form id="frm_side_register" action="{{ route('register') }}" method="post">
                {{ csrf_field() }}
                @component('components.form.text',[
                  'label' => 'نام',
                  'full' => true,
                  'name' => 'register_name',
                  'value' => 'name',
                ])
                @endcomponent
                @component('components.form.text',[
                  'label' => 'ایمیل',
                  'full' => true,
                  'name' => 'register_email',
                  'value' => 'nonsense@email.com',
                ])
                @endcomponent
                @component('components.form.text',[
                  'label' => 'رمز عبور',
                  'full' => true,
                  'name' => 'register_password',
                  'type' => 'password',
                  'value' => 'password',
                ])
                @endcomponent
                @component('components.form.text',[
                  'label' => 'رمز عبور',
                  'full' => true,
                  'name' => 'register_password_confirmation',
                  'type' => 'password',
                  'value' => 'password',
                ])
                @endcomponent
                <div class="flex">
                    <div><input type="checkbox"><span><a href="#">شرایط و قوانین</a>  را قبول دارم</span><br></div>
                </div>
                @component('components.form.button',[
                  'label' => 'ثبت نام',
                  'full' => true,
                  'name' => 'btn_side_register'
                ])
                @endcomponent
            </form>
            <span side-content=".side-content.login">
              @component('components.form.button',[
                'label' => 'وارد شوید',
                'full' => true,
                'type' => 'text',
              ])
                    @endcomponent
            </span>
            </div>
        </div>

    <div class="side-content forgot flex h-full p-10 pt-32">
        <div class="side__forgot-container w-full text-center">
            <h6 class="mb-8">بازیابی رمز عبور</h6>
            <form action="">
                @component('components.form.text',[
                  'label' => 'ایمیل',
                  'full' => true
                ])
                @endcomponent
                @component('components.form.button',[
                  'label' => 'ارسال لینک بازیابی',
                  'full' => true
                ])
                @endcomponent
            </form>
            <span side-content=".side-content.login">
              @component('components.form.button',[
                'label' => 'بازگشت',
                'full' => true,
                'type' => 'text',
              ])
                @endcomponent
            </span>
        </div>
    </div>

    <div class="side-content reset-password flex h-full p-10 pt-32">
        <div class="side__reset-password-container w-full text-center">
            <h6 class="mb-8">تغییر رمز عبور</h6>
            <form action="">
                <div><input type="text" placeholder="ایمیل"></div>
                <div><input type="text" placeholder="رمز عبور"></div>
                <div><input type="text" placeholder="تکرار رمز عبور"></div>
                <button>تغییر رمز عبور</button>
            </form>
            <div>
                <button side-content=".side-content.login">بازگشت به ورود</button>
            </div>
        </div>
    </div>

    <div class="side-content mobile-menu flex h-full pt-32 overflow-auto">
      <div class="mobile-menu-container w-full">
          {{nav('main', 'nav-mobile')}}
      </div>
    </div>

</div>



<div class="mega-search  fixed flex justify-center t0 r0 w-full z-90 bg-white">

    <div class="close" glass=".mega-search">
        <span class="close__cross"></span>
    </div>

    <div class="mega-search__container ">
        <div class="search__box">
            <input id="srch" type="text" placeholder="جستجو کنید: دامن، لباس مجلسی، مزون ژولی و ..." class="w-full pb-4">
        </div>
        <div class="mega-search__result flex ">

        </div>
    </div>
</div>
 
 
 {{-- <header class="header-mobile">
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
 </nav> --}}
