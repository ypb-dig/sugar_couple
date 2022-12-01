<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @foreach ($pre_orders as $order)
        <section>
            <h2>Refrência: {{ $order->id }}</h2>
            <p>Status Code: {{ $order->status_order_code_id }}</p>
        </section>
        
    @endforeach
</body>
</html>