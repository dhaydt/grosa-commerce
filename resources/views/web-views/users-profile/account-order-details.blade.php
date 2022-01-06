@extends('layouts.front-end.app')

@section('title',\App\CPU\translate('Order Details'))

@push('css_or_js')
    <style>
        .page-item.active .page-link {
            background-color: {{$web_config['primary_color']}}            !important;
        }

        .page-item.active > .page-link {
            box-shadow: 0 0 black !important;
        }

        .widget-categories .accordion-heading > a:hover {
            color: #FFD5A4 !important;
        }

        .widget-categories .accordion-heading > a {
            color: #FFD5A4;
        }

        body {
            font-family: 'Titillium Web', sans-serif
        }

        .card {
            border: none
        }


        .totals tr td {
            font-size: 13px
        }

        .footer span {
            font-size: 12px
        }

        .product-qty span {
            font-size: 14px;
            color: #6A6A6A;
        }

        .spanTr {
            color: #FFFFFF;
            font-weight: 900;
            font-size: 13px;

        }

        .spandHeadO {
            color: #FFFFFF !important;
            font-weight: 400;
            font-size: 13px;

        }

        .font-name {
            font-weight: 600;
            font-size: 12px;
            color: #030303;
        }

        .amount {
            font-size: 15px;
            color: #030303;
            font-weight: 600;
            margin- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 60px;

        }

        a {
            color: {{$web_config['primary_color']}};
            cursor: pointer;
            text-decoration: none;
            background-color: transparent;
        }

        a:hover {
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .for-tab-img {
                width: 100% !important;
            }

            .for-glaxy-name {
                display: none;
            }
        }

        @media (max-width: 360px) {
            .for-mobile-glaxy {
                display: flex !important;
            }

            .for-glaxy-mobile {
                margin- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 6px;
            }

            .for-glaxy-name {
                display: none;
            }
        }

        @media (max-width: 600px) {
            .sidebar_heading {
                background: #1B7FED;
            }

            .sidebar_heading h1 {
                text-align: center;
                color: aliceblue;
                padding-bottom: 17px;
                font-size: 19px;
            }
            .for-mobile-glaxy {
                display: flex !important;
                position: fixed;
                justify-content: center;
                bottom: 57px;
                padding: 10px;
                background-color: #fff;
                width: 100%;
                left: 0;
            }

            .for-glaxy-mobile {
                margin- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 6px;
            }

            .for-glaxy-name {
                display: none;
            }

            .order_table_tr {
                display: grid;
            }

            .order_table_td {
                border-bottom: 1px solid #fff !important;
            }

            .order_table_info_div {
                width: 100%;
                display: flex;
            }

            .order_table_info_div_2 {
                width: 49%;
                text-align: {{Session::get('direction') === "rtl" ? 'left' : 'right'}}        !important;
            }

            .spandHeadO {
                font-size: 16px;
                margin- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 16px;
            }

            .spanTr {
                font-size: 16px;
                margin- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 16px;
                margin-top: 10px;
            }

            .amount {
                margin- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 0px;
                font-size: 13px;
            }

            .order_table_info_div_1 {
                width: 50%;
            }

            .mobile-order {
                margin-top: -26px !important;
            }

        }
    </style>
@endpush

@section('content')

    <!-- Page Content-->
    <div class="container mobile-order pb-5 mb-2 mb-md-4 mt-3 rtl"
         style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
            <!-- Sidebar-->
            @include('web-views.partials._profile-aside')

            {{-- Content --}}
            <section class="col-lg-9 col-md-9">
                <div class="row d-none d-md-block">
                    <div class="col-md-6 mb-4">
                        <a class="page-link" href="{{ route('account-oder') }}">
                            <i class="czi-arrow-{{Session::get('direction') === "rtl" ? 'right ml-2' : 'left mr-2'}}"></i>{{\App\CPU\translate('back')}}
                        </a>
                    </div>
                </div>


                <div class="card box-shadow-sm">
                    @if(\App\CPU\Helpers::get_business_settings('order_verification'))
                        <div class="card-header">
                            <h4>{{\App\CPU\translate('order_verification_code')}} : {{$order['verification_code']}}</h4>
                        </div>
                    @endif
                    <div class="payment mb-3  table-responsive">
                        @if(isset($order['seller_id']) != 0)
                            @php($shopName=\App\Model\Shop::where('seller_id', $order['seller_id'])->first())
                        @endif
                        <table class="table table-borderless">
                            <thead>
                            <tr class="order_table_tr" style="background: {{$web_config['primary_color']}}">
                                <td class="order_table_td">
                                    <div class="order_table_info_div">
                                        <div class="order_table_info_div_1 py-2">
                                            <span class="d-block spandHeadO">{{\App\CPU\translate('order_no')}}: </span>
                                        </div>
                                        <div class="order_table_info_div_2">
                                            <span class="spanTr"> {{$order->id}} </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="order_table_td">
                                    <div class="order_table_info_div">
                                        <div class="order_table_info_div_1 py-2">
                                            <span
                                                class="d-block spandHeadO">{{\App\CPU\translate('order_date')}}: </span>
                                        </div>
                                        <div class="order_table_info_div_2">
                                            <span
                                                class="spanTr"> {{date('d M, Y',strtotime($order->created_at))}} </span>
                                        </div>
                                    </div>
                                </td>

                                @if (isset($order->delivery_date))
                                <td class="order_table_td">
                                    <div class="order_table_info_div">
                                        <div class="order_table_info_div_1 py-2">
                                            <span
                                            class="d-block spandHeadO">{{\App\CPU\translate('delivery_date')}}: </span>
                                        </div>
                                        <div class="order_table_info_div_2">
                                            <span
                                            class="spanTr"> {{date('d M, Y',strtotime($order->delivery_date))}} </span>
                                        </div>
                                    </div>
                                </td>
                                @endif

                                <td class="order_table_td">
                                    <div class="order_table_info_div">
                                        <div class="order_table_info_div_1 py-2">
                                            <span
                                                class="d-block spandHeadO">{{\App\CPU\translate('shipping_address')}}: </span>
                                        </div>

                                        @if($order->shippingAddress)
                                            @php($shipping=$order->shippingAddress)
                                        @else
                                            @php($shipping=json_decode($order['shipping_address_data']))
                                        @endif

                                        <div class="order_table_info_div_2">
                                            <span class="spanTr">
                                                @if($shipping)
                                                    {{$shipping->address}}
                                                    , {{$shipping->city}}
                                                    , {{$shipping->zip}}@php($c_name = App\Country::where('country', $shipping->country)->first())
                                                    , {{$c_name->country_name}}
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="order_table_td">
                                    <div class="order_table_info_div">
                                        <div class="order_table_info_div_1 py-2">
                                            <span
                                                class="d-block spandHeadO">{{\App\CPU\translate('Status')}}: </span>
                                        </div>

                                        <div class="order_table_info_div_2">
                                            <span class="spanTr">
                                                @if($order->payment_status == 'paid')
                                                <span class="text-success capitalize">
                                                    {{\App\CPU\translate($order->payment_status)}}
                                                </span>
                                                @else($order['order_status']=='confirmed' || $order['order_status']=='processing' || $order['order_status']=='delivered')
                                                <span class="text-info">
                                                    {{\App\CPU\translate($order->payment_status)}}
                                                </span>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </thead>
                        </table>

                        <table class="table table-borderless">
                            <tbody>
                            @foreach ($order->details as $key=>$detail)
                                @php($product=json_decode($detail->product_details,true))
                                <tr>
                                    <div class="row">
                                        <div class="col-md-6"
                                             onclick="location.href='{{route('product',$product['slug'])}}'">
                                            <td width="20%" class="for-tab-img">
                                                <img class="d-block"
                                                     onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                     src="{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$product['thumbnail']}}"
                                                     alt="VR Collection" width="60">
                                            </td>
                                            <td width="80%" class="for-glaxy-name" style="vertical-align:middle">
                                                <a href="{{route('product',[$product['slug']])}}">
                                                    {{isset($product['name']) ? $product['name'] : ''}}
                                                </a><br>
                                               <span>{{\App\CPU\translate('variant')}} : </span>
                                                {{$detail->variant}}<br>
                                                <span>{{\App\CPU\translate('Seller')}} : </span>
                                                @php($shop=App\Model\Shop::where('seller_id', $detail->seller_id)->first())
                                                {{-- {{$shop->name}} --}}
                                                {{ env('APP_NAME') }}
                                            </td>
                                        </div>
                                        <div class="col-md-6">
                                            <td width="100%">
                                                <div
                                                    class="text-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}">
                                                    <span
                                                        class="font-weight-bold amount">{{\App\CPU\Helpers::currency_converter($detail->price)}} </span>
                                                    <br>
                                                    <span>{{\App\CPU\translate('qty')}}: {{$detail->qty}}</span>

                                                </div>
                                            </td>
                                        </div>
                                    </div>
                                    <td>
                                        {{-- @if($order->order_status=='delivered')
                                            <a href="javascript:" class="btn btn-primary btn-sm" data-toggle="modal"
                                               data-target="#review-{{$detail->id}}">{{\App\CPU\translate('review')}}</a>
                                        @else
                                            <label class="badge badge-secondary">
                                                <a href="javascript:" onclick="review_message()"
                                                   class="btn btn-primary btn-sm">{{\App\CPU\translate('review')}}</a>
                                            </label>
                                        @endif --}}
                                    </td>
                                </tr>
                            @endforeach
                            @php($summary=\App\CPU\OrderManager::order_summary($order))
                            </tbody>
                        </table>
                    </div>
                </div>

                {{--Calculation--}}
                <div class="row d-flex justify-content-end">
                    <div class="col-md-8 col-lg-5">
                        <table class="table table-borderless">
                            <tbody class="totals">
                            <tr>
                                <td>
                                    <div class="text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}"><span
                                            class="product-qty ">{{\App\CPU\translate('Item')}}</span></div>
                                </td>
                                <td>
                                    <div class="text-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}">
                                        <span>{{$order->details->count()}}</span>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}"><span
                                            class="product-qty ">{{\App\CPU\translate('Subtotal')}}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}">
                                        <span>{{\App\CPU\Helpers::currency_converter($summary['subtotal'])}}</span>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}"><span
                                            class="product-qty ">{{\App\CPU\translate('text_fee')}}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}">
                                        <span>{{\App\CPU\Helpers::currency_converter($summary['total_tax'])}}</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}"><span
                                            class="product-qty ">{{\App\CPU\translate('Shipping')}} {{\App\CPU\translate('Fee')}}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}">
                                        <span>{{\App\CPU\Helpers::currency_converter($summary['total_shipping_cost'])}}</span>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}"><span
                                            class="product-qty ">{{\App\CPU\translate('Discount')}} {{\App\CPU\translate('on_product')}}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}">
                                        <span>- {{\App\CPU\Helpers::currency_converter($summary['total_discount_on_product'])}}</span>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}"><span
                                            class="product-qty ">{{\App\CPU\translate('Coupon')}} {{\App\CPU\translate('Discount')}}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}">
                                        <span>- {{\App\CPU\Helpers::currency_converter($order->discount_amount)}}</span>
                                    </div>
                                </td>
                            </tr>

                            <tr class="border-top border-bottom">
                                <td>
                                    <div class="text-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}"><span
                                            class="font-weight-bold">{{\App\CPU\translate('Total')}}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}"><span
                                            class="font-weight-bold amount ">{{\App\CPU\Helpers::currency_converter($order->order_amount)}}</span>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="justify-content-around d-flex mt-4 for-mobile-glaxy ">
                    @if ($order->payment_status != 'unpaid' || $order->payment_method == 'cash_on_delivery')
                    <a href="{{route('generate-invoice',[$order->id])}}" class="btn btn-primary for-glaxy-mobile col-md-5"
                       style="">
                        {{\App\CPU\translate('generate_invoice')}}
                    </a>
                    <a class="btn btn-secondary col-md-5" type="button"
                       href="{{route('track-order.result',['order_id'=>$order['id']])}}"
                       style="color: white">
                        {{\App\CPU\translate('Track')}} {{\App\CPU\translate('Order')}}
                    </a>
                    @endif
                    @if ($order->payment_status == 'unpaid' && $order->payment_method != 'cash_on_delivery')
                    <a class="col-md-12">
                        <form class="needs-validation" method="POST" id="payment-form"
                    action="{{route('xendit-payment.vaInvoice')}}">
                        <input type="hidden" name="type" value="{{ $order->payment_method }}">
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        {{ csrf_field() }}
                        <button class="btn btn-danger w-100" type="submit">
                            {{\App\CPU\translate('pay_now')}}
                        </button>
                    </form>
                    </a>
                    @endif
                </div>
            </section>
        </div>
    </div>

    <!-- Modal -->
    @foreach ($order->details as $key=>$detail)
        @if($order->order_status=='delivered')
            @php($product=json_decode($detail->product_details,true))
            <div class="modal fade rtl" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                 id="review-{{$detail->id}}" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">
                                {{$product['name']}}
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{route('review.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">

                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{\App\CPU\translate('rating')}}</label>
                                    <select class="form-control" name="rating">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{\App\CPU\translate('comment')}}</label>
                                    <input name="product_id" value="{{$detail->product_id}}" hidden>
                                    <textarea class="form-control" name="comment"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{\App\CPU\translate('attachment')}}</label>
                                    <div class="row coba"></div>
                                </div>

                            </div>
                            <div class="modal-footer mobile-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{\App\CPU\translate('close')}}</button>
                                <button type="submit" class="btn btn-primary">{{\App\CPU\translate('submit')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

@endsection


@push('script')
    <script src="{{asset('public/assets/front-end/js/spartan-multi-image-picker.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            $(".coba").spartanMultiImagePicker({
                fieldName: 'fileUpload[]',
                maxCount: 5,
                rowHeight: '150px',
                groupClassName: 'col-md-4',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{asset('public/assets/front-end/img/image-place-holder.png')}}',
                    width: '100%'
                },
                dropFileLabel: "{{\App\CPU\translate('drop_here')}}",
                onAddRow: function (index, file) {

                },
                onRenderedPreview: function (index) {

                },
                onRemoveRow: function (index) {

                },
                onExtensionErr: function (index, file) {
                    toastr.error('{{\App\CPU\translate('input_png_or_jpg')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function (index, file) {
                    toastr.error('{{\App\CPU\translate('file_size_too_big')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });
    </script>
    <script>
        function review_message() {
            toastr.info('{{\App\CPU\translate('you_can_review_after_the_product_is_delivered!')}}', {
                CloseButton: true,
                ProgressBar: true
            });
        }
    </script>
@endpush

