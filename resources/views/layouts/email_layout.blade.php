<html>
<head>
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
            width: 100%;
            box-sizing: border-box;
        }

        body {
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

        b {
            display: inline-block;
            font-weight: 500;
        }

        .f-9{
            font-size: .9em;
            color: #666
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

        .p-30 {
            padding: 30px;
        }

        table {
            font-family: inherit;
            border-collapse: collapse;
            width: 100%;
        }

        table tr {
            font-family: inherit;
            vertical-align: top;
        }

        table th {
            font-family: inherit;
            font-size: .9em;
            text-align: left;
        }

        .table-c tr th {
            background: #486FF0;
            color: #fff;
            text-align: left;
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

        .main-table tr th{
            padding: 10px;
        }

        .main-table tr td{
            padding: 15px 10px;
        }

        .footer-table tr td{
            padding: 5px 10px;
            width: auto;
        }

        .footer-table tr td:first-child{
            width: 600px;
        }

        .pb-10 {
            padding-bottom: 10px;
        }

        .mt-5 {
            margin-top: 5px;
        }

        .mt-15 {
            margin-top: 15px;
        }

        .mb-10 {
            margin-bottom: 10px;
        }

        .mb-20 {
            margin-bottom: 20px;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .mtb-20 {
            margin-bottom: 20px;
            margin-top: 20px;
        }

        .btn{
            font-weight: 500;
            display: inline-block;
            border-radius: 5px;
            text-decoration: none;
            padding: 12.5px 40px;
            background: #486FF0;
            color: #fff!important;
        }
    </style>
</head>
<body>
<div style="max-width: 700px; margin: 20px auto; ">

    <img style="height: 25px; width: auto; margin-bottom: 10px; display: block;"
         src="{{ $setting->logo }}"
         alt="{{ $setting->store_name  }}">

    <p class="mt-15 mb-10">{{__('lang.hello', [], $lang)}} <i>{{ $setting->receiver }}</i>,</p>

    @yield('content')

    <p class="mt-20">{{__('lang.thank_you', [], $lang)}}</p>
    <h3>{{ $setting->store_name  }}</h3>

    <div style="margin-top: 15px; padding-top: 10px; border-top: 1px solid #eee;">
        <p>{{ $setting->address }}</p>
        <p>{{__('lang.phone', [], $lang)}}: <a href="tel:{{ $setting->phone}}">{{ $setting->phone}}</a></p>
    </div>

</div>
</body>
</html>

