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
    </style>
</head>
<body>
    @foreach($pricing as $type)
        @if ($type->count() > 0)
        <h2>
            {{ $type[0]->name }}
        </h2>

        <div id="chart{{ $loop->index }}" style="height:{{ 100 / $pricing->count() - 1 }}vh"></div>
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
                // The name of the data record attribute that contains x-values.
                xkey: 'date',
                // A list of names of data record attributes that contain y-values.
                ykeys: ['value'],
                // Labels for the ykeys -- will be displayed when you hover over the
                // chart.
                labels: ['Value']
            });
        </script>
        @endif
    @endforeach
</body>
</html>