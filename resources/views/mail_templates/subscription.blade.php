<div style="max-width: 600px; margin: 0 auto;">
    {!! $body  !!}

    <div style="margin-top: 20px; border-top: 1px solid #eee;">
        <p>{{ $setting->address }}</p>
        <p>{{__('lang.phone', [], $lang)}}: <a href="tel:{{ $setting->phone}}">{{ $setting->phone}}</a></p>
    </div>

</div>
