<nav class="nav fixed w-full flex items-center z-50" id="nav">
  <div class="container justify-between flex items-center relative">
    <ul class="nav__icons pin-l absolute md:relative md:pin-r">
      <li class="cart-icon hidden"><a href="#"><i class="material-icons" glass=".side" side-content=".side-content.cart">card_travel</i></a></li>
      <li class="wishlist-icon hidden"><a href="#"><i class="material-icons" glass=".side" side-content=".side-content.wishlist">favorite_border</i></a></li>
      <li class="login-icon hidden"><a href="#"><i class="material-icons" glass=".side" side-content=".side-content.login">person_outline</i></a></li>
      <li class="search-icon"><a href="#"><i class="material-icons" glass=".mega-search">search</i></a></li>
    </ul>
    {{nav('main', 'nav__menu w-full text-center hidden md:block')}}
    <div class="nav-mobile__bar-menu-btn md:hidden" id="menu-btn" glass=".side" side-content=".side-content.mobile-menu">
    <div class="nav-mobile__bar-burger menu-toggle ">
      <span>&nbsp;</span>
    </div>
    </div>
    <div class="nav__logo-box  w-24 absolute m-auto pin-x md:w-48 md:relative md:">
      <a href="#"><img src="/images/menu-logo.png" alt="" class="nav__logo"></a>
    </div>
  </div>
</nav>
  
  <div class="glass fixed t-0 r-0 w-full h-full z-60 @if(session('side_content')) active @endif"></div>
  
  <div class="side fixed t0 r0 w-full bg-white h-full z-70 @if(session('side_content')) over-glass @endif">
  
      <div class="side-top-nav absolute bg-white w-full z-80 flex items-center">
        <div class="close" glass=".side">
          <span class="close__cross"></span>
        </div>
        <ul class="nav__icons mobile-menu pin-l absolute md:relative md:pin-r md:hidden">
          <li class="cart-icon pl-4 "><a class="text-black" href="#"><i class="material-icons"side-content=".side-content.mobile-menu">menu</i></a></li>
          <li class="cart-icon pl-4 "><a class="text-black" href="#"><i class="material-icons"side-content=".side-content.cart">card_travel</i></a></li>
          <li class="wishlist-icon pl-4"><a class="text-black" href="#"><i class="material-icons"  side-content=".side-content.wishlist">favorite_border</i></a></li>
          <li class="login-icon pl-4"><a class="text-black" href="#"><i class="material-icons" side-content=".side-content.login">person_outline</i></a></li>
        </ul>
      </div>
  
      <div class="side-content cart flex h-full p-8 overflow-auto @if(session('side_content')=='cart') active @endif">
        @if (empty($cart))
          <div class="side__cart-empty-container w-full text-center">
              <h6 class="mb-8">سبد خرید شما خالی است</h6>
              <div class="side__cart-empty-img w-4/5 text-center m-auto pin-x">
                  <img src="/images/empty-cart.png" alt="">
              </div>
          </div>
        @else
          <div class="text-center">
              <h6 class="mb-4">سبد خرید من</h6>
              <div class="flex justify-around h-12 items-center">
                  <span class="text-black">مبلغ کل خرید:</span><span class="font-bold text-black">۲٫۴۹۵٫۰۰۰<span>&ThickSpace;</span><span>تومان</span></span>
              </div>
              <a href="{{ route('shipping.index') }}" class="text-white flex justify-around bg-indigo h-12 items-center rounded-full">ثبت سفارش و شیوه ارسال</a>
          </div>
          <div class="side__cart-container w-full mt-8">
            @foreach ($cart as $cart_item)
              <div class="side__cart-product flex py-3 relative">
                <div class="side__cart-product-img w-1/3 ">
                  <img src="{{optional($cart_item->product->getFirstMedia(enum('media.product.banner')))->getFullUrl()}}" class="w-24">
                </div>
                <div class="side__cart-product-detail caption pr-2 w-2/3">
                  <div class="side__cart-product-name text-sm text-black">
                    <div>{{$cart_item->product->title}}</div>
                    <div class="font-bold text-black text-lg mt-3">{{$cart_item->price}} <span class="text-sm font-normal text-black">تومان</span> </div>
                    <a href="{{route('cart.destroy', $cart_item)}}"><i class="material-icons absolute pin-l pin-t text-black -ml-4 p-1 text-grey-dark">close</i></a>
                  </div>
                </div>
              </div>
            @endforeach
            <div class="text-center mt-4">
              @component('components.form.field')
              <a href="/cart">
                @component('components.form.button',[
                  'label' => 'مشاهده سبد خرید',
                  'full' => true,
                  'name' => 'btn_side_cart',
                  'type' => 'text',
                ])
                @endcomponent
              </a>
              @endcomponent
            </div>
          </div>
        @endif
      </div>
  
      <div class="side-content wishlist flex h-full p-8 pt-4 overflow-auto @if(session('side_content')=='wishlist') active @endif">
        @if (empty($wishlist))
          <div class="side__wishlist-container w-full text-center">
              <h6 class="mb-8">کمد لباس شما خالی است</h6>
              <div class="side__wishlist-empty-img w-4/5 text-center m-auto pin-x">
                  <img src="/images/empty-wishlist.png" alt="">
              </div>
          </div>
        @else
          <div class="text-center">
            <h6 class="mb-4">کمد لباس‌های من</h6>
          </div>
          <div class="side__cart-container w-full mt-8">  
            @foreach ($wishlist as $wish_item)
              <div class="side__cart-product flex py-3 relative">
                <div class="side__cart-product-img w-1/3 ">
                  <img src="{{optional($wish_item->getFirstMedia(enum('media.product.banner')))->getFullUrl()}}" class="w-24">
                </div>
                <div class="side__cart-product-detail caption pr-2 w-2/3">
                  <div class="side__cart-product-name text-sm text-black">
                    <div>{{$wish_item->title}}</div>
                    <div class="font-bold text-black text-lg mt-3">{{$wish_item->price}} <span class="text-sm font-normal text-black">تومان</span> </div>
                    <a href="{{route('wishlist.destroy', $wish_item->slug)}}"><i class="material-icons absolute pin-l pin-t text-black -ml-4 p-1 text-grey-dark">close</i></a>
                  </div>
                </div>
              </div>
            @endforeach
            <div class="text-center mt-4">
              @component('components.form.field')
              <a href="/wishlist">
                @component('components.form.button',[
                  'label' => 'مشاهده کمد لباس',
                  'full' => true,
                  'name' => 'btn_side_cart',
                  'type' => 'text',
                ])
                @endcomponent
              </a>
              @endcomponent
            </div>
          </div>
        @endif
      </div>
  
      <div class="side-content login flex h-full p-10 pt-4 overflow-auto @if(session('side_content')=='login') active @endif">
        @if (auth()->check())
          <div class="side__loged-container w-full">
            @foreach (auth()->user()->businesses as $business)
              <a class="-mr-8 bg-grey-lighter rounded-l-full flex items-center" href="{{route('profile.businesses.show', $business->slug)}}">
                <div class="w-5/6 pr-8">{{$business->brand}}</div>
                {{-- <img class="w-1/6 h-auto rounded-full m-2 " src="{{$business->getFirstMedia(enum('media.business.logo')) ? $business->getFirstMedia(enum('media.business.logo'))->getUrl('thumb') : '/images/avatar.jpg'}}" alt=""> --}}
              </a>
              <div class="side__loged-container-menu mt-2">
                <a class="relative" href="{{route('profile.businesses.orders.index', $business->slug)}}">
                  <i class="material-icons">room_service</i> سفارشات <span class="rounded-full bg-indigo-light text-white absolute pin-l h-8 px-3 flex justify-center ml-2">3</span>
                </a>
                <a class="relative" href="{{route('profile.businesses.products', $business->slug)}}">
                  <i class="material-icons">room_service</i> محصولات <span class="rounded-full bg-indigo-light text-white absolute pin-l h-8 px-3 flex justify-center ml-2">3</span>
                </a>
                <a class="relative" href="{{route('profile.businesses.chats.index', $business->slug)}}">
                  <i class="material-icons">chat</i> چت ها <span class="rounded-full bg-pink-light text-white absolute pin-l h-8 px-3 flex justify-center ml-2">25</span>
                </a>
              </div>
              <hr class="border border-solid border-grey-lighter my-0 -mx-10">
            @endforeach
            <div class="mt-2 relative">
                <div class="side__loged-user text-left -mr-16 bg-grey-lighter rounded-l-full flex items-center justify-end">
                      <a href="#" class="text-white bg-grey-dark rounded-full py-2 px-5 pl-12 -ml-6 text-sm">پروفایل  نیما  قدمی</a>
                      <img class="w-24 rounded-full h-full border-8 border-solid border-grey-lighter " src="/images/avatar.jpg" alt="">
                    
                  </div>
                  <div class="side__loged-container-menu mt-2">
                    <a href="#"><span><i class="material-icons">attach_money</i></span><span>سفارش‌های من</span></a>
                    <a href="#"><span><i class="material-icons">card_travel</i></span><span>سبد خرید</span></a>
                    <a href="#"><span><i class="material-icons">favorite_border</i></span><span>کُمد لباس هایم</span></a>
                    <a href="#"><span><i class="material-icons">power_settings_new</i></span><span>خروج از حساب کاربری</span></a>
                  </div>
                  <div>
                      <a 
                              href="{{ route('logout') }}"
                              onclick="
                                event.preventDefault();
                                gapi.auth2.getAuthInstance().signOut();
                                document.getElementById('logout').submit()"
                      >
                          خروج
                      </a>
                      <form id="logout" action="{{ route('logout') }}" method="post" style="display:none">
                          {{ csrf_field() }}
                      </form>
                  </div>
            </div>
          </div>
        @else
          <div class="side__login-container w-full text-center">
              <h6 class="mb-8">به حساب کاربری خود وارد شوید</h6>
              <form id="frm_side_login" action="{{ route('login') }}" method="POST">
                  {{ csrf_field() }}
                  @component('components.form.text',[
                    'label' => 'ایمیل یا تلفن همراه',
                    'full' => true,
                    'name' => 'service',
                    'value' => 'akbarjimi@yahoo.com',
                  ])
                  @endcomponent
                  @component('components.form.text',[
                    'label' => 'رمز عبور',
                    'full' => true,
                    'name' => 'password',
                    'type' => 'password',
                    'value' => '123456',
                  ])
                  @endcomponent
                  <div class="flex justify-between items-center py-4">
                      <div>
                        @component('components.form.checkbox',[
                          'label' => 'dd',
                          'name' => 'remember',
                        ])
                        @endcomponent<br>
                      </div>
                      <a class="pl-3" href="#" side-content=".side-content.forgot">فراموشی رمز عبور</a>
                  </div>
                  @component('components.form.field')
                    @component('components.form.button',[
                      'label' => 'وارد شوید',
                      'full' => true,
                      'name' => 'btn_side_login'
                    ])
                    @endcomponent
                  @endcomponent
              </form>
              <div class="g-signin2" data-onsuccess="onSignIn"></div>
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
        @endif   
      </div>
  
      <div class="side-content register flex h-full p-10 pt-4 overflow-auto">
        <div class="side__register-container w-full text-center">
          <h6 class="mb-8">ثبت نام</h6>
            <form id="frm_side_register" action="/register" method="post">
              {{ csrf_field() }}
              @component('components.form.text',[
                'label' => 'نام',
                'full' => true,
                'name' => 'name',
                'value' => 'name',
              ])
              @endcomponent
              @component('components.form.text',[
                'label' => 'ایمیل یا تلفن همراه',
                'full' => true,
                'name' => 'service',
                'value' => 'nonsense@service.com',
              ])
              @endcomponent
              @component('components.form.text',[
                'label' => 'رمز عبور',
                'full' => true,
                'name' => 'password',
                'type' => 'password',
                'value' => 'password',
              ])
              @endcomponent
              @component('components.form.text',[
                'label' => 'تکرار رمز عبور',
                'full' => true,
                'name' => 'password_confirmation',
                'type' => 'password',
                'value' => 'password',
              ])
              @endcomponent
              <div class="flex">
                  <div class="py-4">
                      @component('components.form.checkbox',[
                        'label' => 'dd',
                        'name' => 'terms',
                      ])
                      @endcomponent
                    <span><a href="#">شرایط و قوانین</a>  را قبول دارم</span><br></div>
              </div>
              @component('components.form.field')
                @component('components.form.button',[
                  'label' => 'ثبت نام',
                  'full' => true,
                  'name' => 'btn_side_register'
                ])
                @endcomponent
              @endcomponent
              
          </form>
            <span side-content=".side-content.login">
            @component('components.form.field')
              @component('components.form.button',[
                'label' => 'وارد شوید',
                'full' => true,
                'type' => 'text',
              ])
              @endcomponent
            @endcomponent
            
          </span>
        </div>
      </div>
  
      <div class="side-content forgot flex h-full p-10 pt-4 overflow-auto">
          <div class="side__forgot-container w-full text-center">
              <h6 class="mb-8">بازیابی رمز عبور</h6>
              <form action="{{ route('password.email') }}" method="POST">
                  {{ csrf_field() }}
                  @component('components.form.text',[
                    'label' => 'ایمیل یا تلفن همراه یا شماره تلفن همراه',
                    'name' => 'service',
                    'full' => true
                  ])
                  @endcomponent
                  @component('components.form.field')
                    @component('components.form.field')
                      @component('components.form.button',[
                        'label' => 'ارسال لینک بازیابی',
                        'full' => true
                      ])
                      @endcomponent
                    @endcomponent
                  @endcomponent
              </form>
              <span side-content=".side-content.login">
                @component('components.form.field')
                  @component('components.form.button',[
                    'label' => 'بازگشت',
                    'full' => true,
                    'type' => 'text',
                  ])
                  @endcomponent
                @endcomponent
              </span>
          </div>
      </div>
  
      <div class="side-content reset-password flex h-full p-10 pt-32 overflow-auto">
          <div class="side__reset-password-container w-full text-center">
              <h6 class="mb-8">تغییر رمز عبور</h6>
              <form action="">
                  <div><input type="text" placeholder="ایمیل یا تلفن همراه"></div>
                  <div><input type="text" placeholder="رمز عبور"></div>
                  <div><input type="text" placeholder="تکرار رمز عبور"></div>
                  <button>تغییر رمز عبور</button>
              </form>
              <div>
                  <button side-content=".side-content.login">بازگشت به ورود</button>
              </div>
          </div>
      </div>
  
      <div class="side-content mobile-menu flex h-full overflow-auto">
        <div class="mobile-menu-container w-full text-black">
            {{nav('main', 'nav-mobile')}}
        </div>
      </div>
  
  </div>
  
  <div class="mega-search fixed flex justify-center t0 r0 w-full z-90 bg-white">
  
      <div class="close pin-l md:pin-r" glass=".mega-search">
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



    <script>
        $(document).ready(function () {
            gapi.load('auth2', function() {
                gapi.auth2.init();
            });

            function onSignIn(googleUser) {
                var xhr;
                var id_token = googleUser.getAuthResponse().id_token;
                xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('google') }}');
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.setRequestHeader('X-CSRF-Token', "{{ csrf_token() }}");
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        window.location.reload();
                    } else if(xhr.status === 404) {
                        alert('invalid person');
                    } else if(xhr.status === 500) {
                        alert(' server error = ' + xhr.responseText);
                    } else {
                        alert(' unknown');
                    }
                };
                xhr.send('token=' + id_token);
            }

            $('#btn_side_login').click(function (event) {
                event.preventDefault();
                $.post( "{{ route('api.auth.login') }}", {
                    service : $("#frm_side_login").find("input[name='service']").val(),
                    password : $("#frm_side_login").find("input[name='password']").val(),
                    remember : $("#frm_side_login").find("input[name='remember']").val()
                }).done(function (data) {
                    document.cookie = "token="+data.access_token+";path=/";
                    $("#frm_side_login").submit();
                }).fail(function (data) {
                    alert(data.responseText)
                });
            });

            $('#btn_side_register').click(function (event) {
                event.preventDefault();
                $.post( "{{ route('api.auth.register') }}", {
                    name : $("#frm_side_register").find("input[name='name']").val(),
                    service : $("#frm_side_register").find("input[name='service']").val(),
                    password : $("#frm_side_register").find("input[name='password']").val(),
                    password_confirmation : $("#frm_side_register").find("input[name='password_confirmation']").val(),
                    terms : $("#frm_side_register").find("input[name='terms']").val(),
                }).done(function (data) {
                    $("#frm_side_login").find("input[name='service']").val(
                        $("#frm_side_register").find("input[name='service']").val(),
                    );

                    $("#frm_side_login").find("input[name='password']").val(
                        $("#frm_side_register").find("input[name='password']").val(),
                    );

                    $("#frm_side_login").submit();
                }).fail(function (data) {
                    alert(data.responseText)
                });
            });
        });
    </script>

