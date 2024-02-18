<div style="max-width: 600px; ">
    {{__('lang.hello', [], $lang)}} <i>{{ $data->receiver }}</i>,
    <h1>{{__('lang.almost_there', [], $lang)}}</h1>
    <p>{{__('lang.copy_code', [], $lang)}}</p>

    <p>
        <span style="background: #39AEA4; padding: 10px 30px; margin: 20px 0; display: inline-block;
                        border-radius: 100px; font-size: 20px; color: #fff; letter-spacing: 1px;">
            <b>{{ $data->code }}</b>
        </span>
    </p>

    {{__('lang.thank_you', [], $lang)}}
    <h3>{{ $data->store_name  }}</h3>

    <div style="margin-top: 20px; border-top: 1px solid #eee;">
        <p>{{ $data->address }}</p>
        <p>{{__('lang.phone', [], $lang)}}: <a href="tel:{{ $data->phone}}">{{ $data->phone}}</a></p>
    </div>

</div>
