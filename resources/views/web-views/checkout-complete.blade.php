@extends('layouts.front-end.app')

@section('title',\App\CPU\translate('Order Complete'))

@push('css_or_js')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');

        body {
            font-family: 'Montserrat', sans-serif
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
            color: {{$web_config['primary_color']}};
            font-weight: 700;

        }

        .spandHeadO {
            color: #030303;
            font-weight: 500;
            font-size: 20px;

        }

        .font-name {
            font-weight: 600;
            font-size: 13px;
        }

        .amount {
            font-size: 17px;
            color: {{$web_config['primary_color']}};
        }

        @media (max-width: 600px) {
            .orderId {
                margin- {{Session::get('direction') === "rtl" ? 'left' : 'right'}}: 91px;
            }
            .p-5 {
                padding: 2% !important;
            }
            .spanTr {
                font-weight: 400 !important;
                font-size: 12px;
            }
            .spandHeadO {
                font-weight: 300;
                font-size: 12px;
            }
            .table th, .table td {
                padding: 5px;
            }
            .mobile-checkout-complete{
                position: fixed;
                background-color: #fff;
                left: 0;
                right: 0;
                bottom: 0;
                padding: 10px;
            }
            .mobile-checkout-complete a, .mobile-checkout-complete .btn{
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 13px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container mt-5 mb-5 rtl"
         style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row d-flex justify-content-center">
            <div class="col-md-10 col-lg-10">
                <div class="card">
                    @if(auth('customer')->check())
                        <div class=" p-5">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 style="font-size: 20px; font-weight: 900">{{\App\CPU\translate('your_order_has_been_placed_successfully!')}}
                                        !</h5>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-12">
                                    <center>
                                        <i style="font-size: 100px; color: #0f9d58" class="fa fa-check-circle"></i>
                                    </center>
                                </div>
                            </div>

                            <span class="font-weight-bold d-block mt-4" style="font-size: 17px;">{{\App\CPU\translate('Hello')}}, {{auth('customer')->user()->f_name}}</span>
                            <span>{{\App\CPU\translate('You order has been confirmed and will be shipped according to the method you selected!')}}</span>

                            <div class="row mt-4 justify-content-between mobile-checkout-complete">
                                    <a href="{{route('home')}}" class="btn btn-primary col-md-4 col-4">
                                        {{\App\CPU\translate('go_to_shopping')}}
                                    </a>

                                @if (session()->get('payment') != 'cash_on_delivery' && session()->get('payment_status') != 'success')
                                    <form class="needs-validation col-md-4 col-4" target="_blank" method="POST" id="payment-form"
                                    action="{{route('xendit-payment.vaInvoice')}}">
                                        <input type="hidden" name="type" value="{{ session()->get('payment') }}">
                                        <input type="hidden" name="order_id" value="{{ session()->get('orderID') }}">
                                        {{ csrf_field() }}
                                        <button class="btn btn-danger w-100" id="pay-btn" type="submit" onclick="hidePay()">
                                            {{\App\CPU\translate('pay_now')}}
                                        </button>
                                    </form>
                                @endif

                                    <a href="{{route('account-oder')}}"
                                       class="btn btn-secondary pull-{{Session::get('direction') === "rtl" ? 'left' : 'right'}} col-md-4 col-4">
                                        {{\App\CPU\translate('check_orders')}}
                                    </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
    function hidePay(){
        $('#pay-btn').attr('class', 'd-none');
    }
</script>
@endpush
