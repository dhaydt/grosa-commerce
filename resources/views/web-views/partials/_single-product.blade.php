<style>
    .card-header {
        cursor: pointer;
        max-height: 193px;
        min-height: 193px;
        padding: 0px;
        margin-bottom: 25px;
    }
    .center-div a img {
        min-width:200px;
        width: 100%;
        min-height: 200px;
        max-height: 200px!important;
        }
    @media (max-width: 600px) {
        .card-header {
            max-height: 150px;
            min-height: 150px;
            margin-bottom: 5px;
        }
        .center-div a img {
            min-width: 100%;
            max-width: 100%;
            max-height: 150px;
            min-height: 150px;
            border-radius: 10px 10px;
        }

        .product-card.card {
            border-radius: 10px 10px;
        }

        .product-card.card .card-body-hidden {
            visibility: visible !important;
            opacity: 1 !important;
            margin-top: -28px;
            padding-top: 0;
            z-index: 2;
        }

        .product-card.card .card-body-hidden .text-center a{
            font-size:10px;
        }

        .product-title1 a{
            font-size: 14px;
        }

        .product-price .text-accent {
            font-size: 14px !important;
        }
    }
</style>
@php($overallRating = \App\CPU\ProductManager::get_overall_rating($product->reviews))
<div class="product-card card {{$product['current_stock']==0?'stock-card':''}}"
    style="margin-bottom: 40px;display: flex; align-items: center; justify-content: center;">
    @if($product['current_stock']<=0) <label style="left: 29%!important; top: 29%!important;"
        class="badge badge-danger stock-out">{{\App\CPU\translate('stock_out')}}</label>
        @endif

        <div class="card-header inline_product clickable">
            @if($product->discount > 0)
            <div class="d-flex" style="right: 0;top:0;position: absolute">
                <span class="for-discoutn-value pr-1 pl-1">
                    @if ($product->discount_type == 'percent')
                    {{round($product->discount,2)}}%
                    @elseif($product->discount_type =='flat')
                    {{\App\CPU\Helpers::currency_converter($product->discount)}}
                    @endif
                    {{\App\CPU\translate('off')}}
                </span>
            </div>
            @else
            <div class="d-flex justify-content-end for-dicount-div-null">
                <span class="for-discoutn-value-null"></span>
            </div>
            @endif
            <div class="d-flex d-block center-div element-center" style="cursor: pointer">
                <a href="{{route('product',$product->slug)}}">
                    <img src="{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$product['thumbnail']}}"
                        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'">
                </a>
            </div>
        </div>

        <div class="card-body inline_product text-center p-1 clickable" style="cursor: pointer; max-height:6.5rem; min-height:6.5rem; margin-bottom: 23px;">
            <div style="position: relative;" class="product-title1">
                <a href="{{route('product',$product->slug)}}">
                    {{ Str::limit($product['name'], 25) }}
                </a>
            </div>
            <div class="justify-content-between text-center">
                <div class="product-price text-center">
                    @if($product->discount > 0)
                    <strike style="font-size: 12px!important;color: grey!important;">
                        {{\App\CPU\Helpers::currency_converter($product->unit_price)}}
                    </strike><br>
                    @endif
                    <span class="text-accent">
                        {{\App\CPU\Helpers::currency_converter(
                        $product->unit_price-(\App\CPU\Helpers::get_product_discount($product,$product->unit_price))
                        )}}
                    </span>
                </div>
            </div>

        </div>
        {{-- <div class="d-flex justify-content-left w-100" style="position: absolute;bottom: 11px;left: 15px;z-index: 2;">
            <div class="flag">
                <img class="{{Session::get('direction') === " rtl" ? 'ml-2' : 'mr-2' }}" width="20"
                    src="{{asset('public/assets/front-end')}}/img/flags/{{ strtolower($product['country'])  }}.png"
                    alt="Eng">
            </div>
           @php($c_name = App\Country::where('country', $product['country'])->get())
            <span style="font-size: 13px; color: #616166; line-height: 1.6;">{{ $c_name[0]->country_name }}</span>
        </div> --}}

        <div class="card-body card-body-hidden" style="padding-bottom: 5px!important;">
            <div class="text-center">
                @if(Request::is('product/*'))
                <a class="btn btn-primary btn-sm btn-block mb-2" href="{{route('product',$product->slug)}}">
                    <i class="czi-forward align-middle {{Session::get('direction') === " rtl" ? 'ml-1' : 'mr-1' }}"></i>
                    {{\App\CPU\translate('View')}}
                </a>
                @else
                <a class="btn btn-primary btn-sm btn-block mb-2" href="javascript:"
                onclick="addCart({{ $product->id }})">
                    <i style="font-weight: 900;font-size: 9px; margin-top: -1px;" class="czi-add align-middle {{Session::get('direction') === " rtl" ? 'ml-1' : 'mr-1' }}"></i>
                    Keranjang
                </a>
                @endif
            </div>
        </div>
</div>
@push('script')
<script>
    function addCart(val) {
        if (checkAddToCartValidity()) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.post({
                url: '/cart/add',
                data: {'id' : val, 'quantity': 1},
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (response) {
                    // console.log(response);
                    if (response.status == 1) {
                        updateNavCart();
                        toastr.success(response.message, {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        $('.call-when-done').click();
                        return false;
                    } else if (response.status == 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Cart',
                            text: response.message
                        });
                        return false;
                    }
                },
                complete: function () {
                    $('#loading').hide();
                }
            });
        } else {
            Swal.fire({
                type: 'info',
                title: 'Cart',
                text: 'Please choose all the options'
            });
        }
    }

</script>
@endpush
