@extends('layouts.email_layout')

@section('content')
    <p>{{__('lang.thank_order', [], $lang)}} {{ $setting->store_name }}.
        {{__('lang.order_logging', [], $lang)}}
        <a href="{{ env('CLIENT_BASE_URL', config('env.url.CLIENT_BASE_URL')) }}/user/orders" .>{{__('lang.your_account', [], $lang)}}</a></p>

    <h3 class="mt-15">{{__('lang.your_order', [], $lang)}} #{{ $order->order }}</h3>
    <p class="mb-20">{{__('lang.placed_on', [], $lang)}} {{ $order->created }}</p>

    <table class="mb-10">
        <tr>
            <th class="pb-10">{{__('lang.ship_to', [], $lang)}}</th>
            <th class="pb-10">{{__('lang.order_method', [], $lang)}}</th>
        </tr>

        <tr>
            <td style="width: 50%;">
                <div style="max-width: 300px;">
                    <h5 style="margin-bottom: 5px">{{ $order->address->name }}</h5>
                    <p>{{ $order->formatted_address }}</p>

                    @if($order->user)
                        <p>{{__('lang.email', [], $lang)}}: {{ $order->user->email }}</p>
                    @elseif($order->guest_user)
                        <p>{{__('lang.email', [], $lang)}}: {{ $order->guest_user->email }}</p>
                    @endif

                    <p>{{__('lang.phone', [], $lang)}}: {{ $order->address->phone }}</p>
                </div>
            </td>
            <td style="width: 50%;">{{ $order->order_method }}</td>
        </tr>
    </table><!--table-->


    <table style="background: #eee; border: 1px solid #ddd; border-bottom: none" class="mt-20 main-table border-tr">
        <tr>
            <th>{{__('lang.title', [], $lang)}}</th>
            <th>{{__('lang.delivery_fee', [], $lang)}}</th>
            <th>{{__('lang.quantity', [], $lang)}}</th>
            <th>{{__('lang.price', [], $lang)}}</th>
            <th>{{__('lang.total', [], $lang)}}</th>
        </tr>

        @foreach ($order->ordered_products as $op)
            <tr style="background: #fff">
                <td>
                    <b>{{ $op->product->title }}</b>
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

    <table class="border-tr td-right-align footer-table"
           style="border: 1px solid #ddd; background: #eee; ">
        <tr>
            <td style="width: 630px" >{{__('lang.subtotal', [], $lang)}}</td>
            <td style="width: 70px;">{{ $setting->currency_icon }}{{ $order->calculated_price['subtotal'] }}</td>
        </tr>
        <tr>
            <td>{{__('lang.shipping_cost', [], $lang)}}</td>
            <td>{{ $setting->currency_icon }}{{ $order->calculated_price['shipping_price'] }}</td>
        </tr>

        @if ((int) $order->calculated_price['bundle_offer'] > 0)
            <tr>
                <td>{{__('lang.bundle_offer', [], $lang)}}</td>
                <td>{{ $setting->currency_icon }}{{ $order->calculated_price['bundle_offer'] }}</td>
            </tr>
        @endif

        @if ((int) $order->calculated_price['voucher_price'] > 0)
            <tr>
                <td>{{__('lang.voucher', [], $lang)}}</td>
                <td>{{ $setting->currency_icon }}{{ $order->calculated_price['voucher_price'] }}</td>
            </tr>
        @endif

        @if ((int) $order->calculated_price['tax'] > 0)
            <tr>
                <td>{{__('lang.tax', [], $lang)}}</td>
                <td>{{ $setting->currency_icon }}{{ $order->calculated_price['tax'] }}</td>
            </tr>
        @endif

        <tr>
            <td>{{__('lang.total', [], $lang)}}</td>
            <td>{{ $setting->currency_icon }}{{ $order->calculated_price['total_price'] }}</td>
        </tr>
    </table>
@stop
