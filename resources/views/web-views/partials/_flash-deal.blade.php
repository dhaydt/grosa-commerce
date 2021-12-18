<style>
    .bandiv{
            min-height: 400px;
            max-height: 400px;
            width: 96%;
            background-color: {{ $web_config['primary_color'] }};
            border-radius:10px;
        }
    .bandiv img {
        max-height: 400px;
        min-height: 400px;
    }

    .flash_deal_product {
        cursor: pointer;
        min-height: 335px;
        border-radius: 10px;
        overflow:hidden;
    }

    .deal-product-col {
        margin-left: -105px
    }
    @media (max-width: 600px) {
        .bandiv{
            min-height: 300px !important;
        }
        .bandiv .img {
            max-height: 300px;
            min-height: 300px;
        }

        .flash_deal_product {
            cursor: pointer;
            max-height: 235px;
            border-radius: 10px;
            overflow:hidden;
        }
        .deal-product-col {
            margin-left: 0px
        }
    }
</style>
<div class="row mb-4" style="max-height: 400px">
    <div class="banner col-md-3 col-6">
        <a href="/" class="h-100">
            <div class="bandiv">
                <img src="{{asset("storage/app/public/company")."/".$web_config['flash_banner']->value}}" alt="">
            </div>
        </a>
    </div>
    <div class="col-md-10 col-6 d-flex align-items-center deal-product-col">
        <div class="owl-carousel owl-theme mt-2" id="flash-deal-slider">
            @foreach($flash_deals->products as $key=>$deal)
            @if( $deal->product)
            @php($overallRating = \App\CPU\ProductManager::get_overall_rating(isset($deal)?$deal->product->reviews:null))
            <div class="flash_deal_product rtl"
              onclick="location.href='{{route('product',$deal->product->slug)}}'">
              @if($deal->product->discount > 0)
              <div class=" discount-top-f">
                <span class="for-discoutn-value">
                  @if ($deal->product->discount_type == 'percent')
                  {{round($deal->product->discount)}}%
                  @elseif($deal->product->discount_type =='flat')
                  {{\App\CPU\Helpers::currency_converter($deal->product->discount)}}
                  @endif OFF
                </span>
              </div>
              @else
              {{-- <div class="">
                <span class="for-discoutn-value-null"></span>
              </div> --}}
              @endif
              <div class="d-flex flex-column">
                <div class="d-flex align-items-center justify-content-center div-flash">
                  <img class="w-100"
                    src="{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$deal->product['thumbnail']}}"
                    onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'" />
                </div>
                <div class="flash_deal_product_details pl-2 pr-1 py-2 d-flex align-items-center">
                  <div>
                    <h6 class="flash-product-title">
                      {{$deal->product['name']}}
                    </h6>
                    <div class="flash-product-price">
                      {{\App\CPU\Helpers::currency_converter($deal->product->unit_price-\App\CPU\Helpers::get_product_discount($deal->product,$deal->product->unit_price))}}
                      @if($deal->product->discount > 0)
                      <strike style="font-size: 12px!important;color: grey!important;">
                        {{\App\CPU\Helpers::currency_converter($deal->product->unit_price)}}
                      </strike>
                      @endif
                    </div>
                    <h6 class="flash-product-review">
                      @for($inc=0;$inc<5;$inc++) @if($inc<$overallRating[0]) <i class="sr-star czi-star-filled active">
                        </i>
                        @else
                        <i class="sr-star czi-star"></i>
                        @endif
                        @endfor
                        <label class="badge-style2">
                          ( {{$deal->product->reviews()->count()}} )
                        </label>
                    </h6>
                  </div>
                </div>
              </div>
            </div>
            @endif
            @endforeach
          </div>


    </div>
    </div>
