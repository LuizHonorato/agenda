<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ mix("css/app.css") }}">
    <link rel="stylesheet" href="{{ mix("css/custom.css") }}">
    <title>{{$title ?? 'Agenda'}}</title>
</head>
<body>

<div id="app">
    @yield('content')
</div>

<script src="{{ mix("js/app.js") }}"></script>
<script src="https://unpkg.com/feather-icons"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace()
</script>
</body>
</html>
