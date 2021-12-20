<style>
    @media(max-width:600px) {
        .mobile-head{
            position: fixed;
            width: 100vw;
            z-index: 6;
        }
    }
</style>
<div class="navbar-sticky bg-dark mobile-head">
    <div class="navbar navbar-expand-md navbar-dark p-2">
        <div class="container ">
            <div class="row w-100">

                <div class="col-md-6 col-sm-10 col-10">
                    <div class="input-group-overlay" style="text-align: {{Session::get('direction') === " rtl"
                        ? 'right' : 'left' }}">
                        <form action="{{route('products')}}" type="submit" class="search_form">
                            <input class="form-control appended-form-control search-bar-input" type="text" autocomplete="off"
                                placeholder="{{\App\CPU\translate('search')}}" name="name"
                                style="border: 2px solid white; border-radius: 50px; border-top-right-radius: 50px !important; border-bottom-right-radius: 50px !important;">
                            <button class="input-group-append-overlay search_button" type="submit"
                                style="border: 2px solid white;background-color: {{ $web_config['primary_color'] }} !important; border-radius: {{Session::get('direction') === " rtl"
                                ? '50px 0px 0px 50px; right: unset; left: 0' : '0px 50px 50px 0px; left: unset; right: 0' }};">
                                <span class="input-group-text" style="font-size: 20px;">
                                    <i class="czi-search text-white"></i>
                                </span>
                            </button>
                            <input name="data_from" value="search" hidden>
                            <input name="page" value="1" hidden>
                            <diV class="card search-card"
                                style="position: absolute;background: white;z-index: 999;width: 100%;display: none">
                                <div class="card-body search-result-box" style="overflow:scroll; height:400px;overflow-x: hidden"></div>
                            </diV>
                        </form>
                    </div>
                </div>
                <div class="col-md-2 col-2">
                     <!-- Toolbar-->
                    <div class="navbar-toolbar d-flex flex-shrink-0 align-items-center">
                        <a class="navbar-tool navbar-stuck-toggler" href="#">
                            <span class="navbar-tool-tooltip">Expand menu</span>
                            <div class="navbar-tool-icon-box">
                                <i class="navbar-tool-icon czi-menu"></i>
                            </div>
                        </a>
                        {{-- <div class="navbar-tool dropdown">
                            <a class="navbar-tool-icon-box bg-secondary dropdown-toggle" href="{{route('wishlists')}}">
                                <span class="navbar-tool-label">
                                    <span class="countWishlist">{{session()->has('wish_list')?count(session('wish_list')):0}}</span>
                                </span>
                                <i class="navbar-tool-icon czi-heart"></i>
                            </a>
                        </div> --}}
                        {{-- @if(auth('customer')->check())
                        <div class="dropdown">
                            <a class="navbar-tool ml-2 mr-2 " type="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <div class="navbar-tool-icon-box bg-secondary">
                                    <div class="navbar-tool-icon-box bg-secondary">
                                        <img style="width: 40px;height: 40px"
                                            src="{{asset('storage/app/public/profile/'.auth('customer')->user()->image)}}"
                                            onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                            class="img-profile rounded-circle">
                                    </div>
                                </div>
                                <div class="navbar-tool-text">
                                    <small>Hello, {{auth('customer')->user()->f_name}}</small>
                                    Dashboard
                                </div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{route('account-oder')}}"> {{ \App\CPU\translate('my_order')}} </a>
                                <a class="dropdown-item" href="{{route('user-account')}}"> {{ \App\CPU\translate('my_profile')}}</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{route('customer.auth.logout')}}">{{ \App\CPU\translate('logout')}}</a>
                            </div>
                        </div>
                        @else
                        <div class="dropdown">
                            <a class="navbar-tool" type="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="navbar-tool-icon-box bg-secondary">
                                    <div class="navbar-tool-icon-box bg-secondary">
                                        <i class="navbar-tool-icon czi-user text-white" style="color: white !important;"></i>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu bg-white" aria-labelledby="dropdownMenuButton"
                                style="text-align: {{Session::get('direction') === " rtl" ? 'right' : 'left' }};">
                                <a class="dropdown-item" href="{{route('customer.auth.login')}}">
                                    <i class="fa fa-sign-in {{Session::get('direction') === " rtl" ? 'ml-2' : 'mr-2' }}"></i>
                                    {{\App\CPU\translate('sign_in')}}
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{route('customer.auth.register')}}">
                                    <i class="fa fa-user-circle {{Session::get('direction') === " rtl" ? 'ml-2' : 'mr-2'
                                        }}"></i>{{\App\CPU\translate('sign_up')}}
                                </a>
                            </div>
                        </div>
                        @endif --}}
                        <div id="cart_items">
                            @include('layouts.front-end.partials.cart_mobile')
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
<div class="bottom-nav" style="background-color: #f2f3f7">
    <div id="loc-mobile" class="d-flex container p-2 px-4" data-toggle="tooltip" data-placement="top" title="Location">
        <span id="nav-global-location-data-modal-action" class="a-declarative nav-progressive-attribute">
            <a id="nav-global-location-popover-link"
                class="d-flex align-items-center nav-a nav-a-2 a-popover-trigger a-declarative nav-progressive-attribute"
                tabindex="0">

            </a>
        </span>
        <div class="mr-2 d-flex align-items-center justify-content-center">
            <span class="nav-line-1 nav-progressive-content mr-2" style="color: #5a5757">Area pengiriman</span>
            <img class="mr-1" style="height: 14px; width: auto;" src="{{asset('public/assets/front-end/img/loc.png')}}" alt="">
            <span class="nav-line-2 nav-progressive-content d-flex" id="auto-loc-mobile">
                {{-- Indonesia --}}
            </span>
        </div>
    </div>
</div>


<script>

fetch('https://ipapi.co/json/')
  .then(function(response) {
    return response.json();
  })
  .then(function(data) {
    console.log('location mobile',data);

            if(data.region !== "West Java"){
                $('#auto-loc-mobile').append('Diluar jangkauan').attr('style', 'font-size: 16px; width: 120px;color: #5a5757;')
            }else{
                $('#auto-loc-mobile').append(data.city)
            }
            $('#loc-mobile').attr('data-original-title', data.country_name + ', ' + data.region);
  });
</script>
