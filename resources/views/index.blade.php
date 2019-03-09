<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ARAL pricing data (Elten)</title>

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">

    <style>
        @import url('https://fonts.googleapis.com/css?family=Roboto');

        html, body {
            min-height: 100vh;
            font-family: 'Roboto', sans-serif;
        }

        .logo {
            position: absolute;
            right: 0;
            top: 0;
            padding: 8px 8px;
        }
    </style>
</head>
<body>
    <div class="logo">
        <a href="https://webarray.nl" target="_blank">
            <img height="64" src="/img/logo.png" alt="Logo">
        </a>
    </div>

    @foreach($pricing as $type)
        @if ($type->count() > 0)
        <h2>
            {{ $type[0]->product->station->name }} - {{ $type[0]->product->name }} ({{ $type->last()->price / 100 }} EUR/L)
        </h2>

        <div id="chart{{ $loop->index }}" style="max-height:{{ 100 / $pricing->count() - 1 }}vh"></div>
        @endif
    @endforeach

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

    @foreach($pricing as $type)
        @if ($type->count() > 0)
        <script>
            new Morris.Line({
                element: 'chart{{ $loop->index }}',
                data: [
                @foreach($type as $item)
                    { date: '{{ $item->created_at }}', value: {{ $item->price }} },
                @endforeach
                ],
                ymin: {{ $type->min('price') - 2 }},
                ymax: {{ $type->max('price') + 2}},
                xkey: 'date',
                ykeys: ['value'],
                labels: ['Value']
            });
        </script>
        @endif
    @endforeach
</body>
</html>