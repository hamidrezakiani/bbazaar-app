<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        * {
            box-sizing: border-box;
        }

        body,
        html {
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 100%;
            vertical-align: baseline;
            min-height: 100%;
            max-width: 100%;
            box-sizing: border-box;
        }

        body {
            font-size: 14px;
            font-family: DejaVu Sans, sans-serif;
            font-weight: 400;
            color: #444;
        }

        h1, h2, h3, h4, h5, h6, p, ul, span, li, input, button {
            margin: 0;
            padding: 0;
            line-height: 1.4;
            box-sizing: border-box;
        }

        span {
            font-family: DejaVu Sans, sans-serif;
            line-height: inherit;
        }

        h1, h2, h3, h4, h5, h6 {
            font-weight: inherit;
        }

        p {
            line-height: 1.8;
            font-size: 1em;
            font-weight: 400;
            color: #112211;
        }

        h1 {
            font-size: 3.5em;
        }

        h2 {
            font-size: 2.5em;
        }

        h3 {
            font-size: 1.8em;
        }

        h4 {
            font-size: 1.3em;
        }

        h5 {
            font-size: 1.1em;
        }

        h6 {
            font-size: .95em;
            letter-spacing: 1px;
            line-height: 1.6;
        }

        strong {
            font-weight: 700;
        }

        img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        li {
            display: block;
            list-style: none;
            font-size: 1em;
        }

        i, span {
            display: inline-block;
        }

        b {
            display: inline-block;
            font-weight: 500;
        }

        .p-30 {
            padding: 30px;
        }


        table {
            width: 100%;
            font-family: inherit;
        }

        table tr {
            vertical-align: top;
        }

        table td {
            font-family: inherit;
        }

        table th {
            font-family: inherit;
            text-align: left;
        }

        .table-c tr th {
            background: #ef4444;
            color: #fff;
            text-align: left;
            font-size: .9em;
            font-weight: 400;
            padding: 10px;
        }

        .border-tr tr td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        .border-tr tr:last-child td {
            border-bottom: none;
        }

        .table-c tr td {
            padding: 5px 10px;
        }

        .td-right-align tr td {
            text-align: right;
            padding: 5px 0;
        }

        .main-table tr td{
            padding: 15px 10px;
        }

        .mt-10 {
            margin-top: 10px;
        }

        .mb-5 {
            margin-bottom: 5px;
        }

        .mb-10 {
            margin-bottom: 10px;
        }

        .mb-20 {
            margin-bottom: 20px;
        }

        .ml-10 {
            margin-left: 10px;
        }

        .block {
            display: block;
        }

        .mt-5 {
            margin-top: 5px;
        }

        .f-9{
            font-size: .9em;
            color: #666
        }

    </style>
</head>
<body style="padding: 30px;">
<table class="mb-20">
    <tr>
        <td>
            <div style="max-width: 350px;">
                <img style="height: 25px; width: auto; margin-bottom: 10px"
                     src="data:image/png;base64,{{$setting->logo_base64}}">
                <h4 class="mt-10 mb-10">{{ $setting->store_name }}</h4>
                <p> {{$setting->address}}</p>
                <p>{{__('lang.phone')}}: {{ $setting->phone }}</p>
            </div>
        </td>
        <td>
            <h3 class="mb-10 ml-10">Invoice</h3>
            <table style="max-width: 400px;">
                <tr>
                    <td>{{__('lang.order')}}</td>
                    <td>#{{ $order->order }}</td>
                </tr>
                <tr>
                    <td>{{__('lang.order_date')}}</td>
                    <td>{{ $order->created }}</td>
                </tr>
                <tr>
                    <td>{{__('lang.order_amount')}}</td>
                    <td>{{ $setting->currency_icon }}{{ $order->calculated_price['total_price'] }}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table class="mb-20 table-c">
    <tr>
        <th style="text-align: left;">{{__('lang.ship_to')}}</th>
        <th style="text-align: left;">{{__('lang.order_method')}}</th>
    </tr>

    <tr>
        <td style="width: 50%;">
            <div style="max-width: 300px;">
                <h5 class="mb-5">{{ $order->address->name }}</h5>
                <p>{{ $order->formatted_address }}</p>

                @if($order->user)
                    <p>{{__('lang.email')}}: {{ $order->user->email }}</p>
                @elseif($order->guest_user)
                    <p>{{__('lang.email')}}: {{ $order->guest_user->email }}</p>
                @endif


                <p>{{__('lang.phone')}}: {{ $order->address->phone }}</p>
            </div>
        </td>
        <td style="width: 50%;">{{ $order->order_method }}</td>
    </tr>
</table><!--table-->

<table class="border-tr table-c main-table">
    <tr>
        <th>{{__('lang.title')}}</th>
        <th>{{__('lang.delivery_fee')}}</th>
        <th>{{__('lang.quantity')}}</th>
        <th>{{__('lang.price')}}</th>
        <th>{{__('lang.total')}}</th>
    </tr>

    @foreach ($order->ordered_products as $op)
        <tr>
            <td>
               {{ $op->product->title }}
                <span class="mt-5 f-9 block">{{ \App\Models\Helper\MailHelper::generatingAttribute($op) }}</span>
            </td>
            <td>
                {{ $setting->currency_icon }}
                {{ \App\Models\Helper\MailHelper::shippingPrice($op->shipping_place, $op->shipping_type) }}
            </td>
            <td>{{ $op->quantity }}</td>

            <td>{{ $setting->currency_icon }}{{ $op->selling }}</td>
            <td>{{ $setting->currency_icon }}{{ $op->selling * $op->quantity }}</td>
        </tr>

    @endforeach
</table><!--table-->

<div style="width: 100%; clear: both; display: block;">
    <table class="border-tr td-right-align" style="margin-left: auto; width: 180px; max-width: 180px;">
        <tr>
            <td style="min-width: 110px">{{__('lang.subtotal')}}</td>
            <td style="min-width: 40px">{{ $setting->currency_icon }}{{ $order->calculated_price['subtotal'] }}</td>
        </tr>
        <tr>
            <td>{{__('lang.shipping_cost')}}</td>
            <td>{{ $setting->currency_icon }}{{ $order->calculated_price['shipping_price'] }}</td>
        </tr>

        @if ((int) $order->calculated_price['bundle_offer'] > 0)
            <tr>
                <td>{{__('lang.bundle_offer')}}</td>
                <td>{{ $setting->currency_icon }}{{ $order->calculated_price['bundle_offer'] }}</td>
            </tr>
        @endif

        @if ((int) $order->calculated_price['voucher_price'] > 0)
            <tr>
                <td>{{__('lang.voucher')}}</td>
                <td>{{ $setting->currency_icon }}{{ $order->calculated_price['voucher_price'] }}</td>
            </tr>
        @endif

        @if ((int) $order->calculated_price['tax'] > 0)
            <tr>
                <td>{{__('lang.tax')}}</td>
                <td>{{ $setting->currency_icon }}{{ $order->calculated_price['tax'] }}</td>
            </tr>
        @endif

        <tr>
            <td>{{__('lang.total')}}</td>
            <td>{{ $setting->currency_icon }}{{ $order->calculated_price['total_price'] }}</td>
        </tr>
    </table>
</div>



<div style="width: 100%; clear: both; display: block; padding-top: 150px;">
    <table class="table-c" style="width: 50%;">
        <tr>
            <th>{{__('lang.notes')}}</th>
        </tr>

        <tr>
            <td style="width: 50%;">
                <p style="margin-bottom: 10px; font-style: italic;">
                    {{__('lang.order_number')}}
                </p>
                <p>
                    {{__('lang.question_str')}}: {{ $setting->phone }}
                </p>
            </td>
        </tr>
    </table><!--table-->
</div>



</body>
