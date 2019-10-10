<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="{{ env('APP_NAME') }}">
    <meta name="keywords" content="{{ env('APP_NAME') }}">
    <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css"
          rel="stylesheet">

    <title>{{ env('APP_NAME') }}</title>


    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/css/bundle.main.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/css/bundle.vendor.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/css/custom.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Comfortaa:300,400,500,600,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,700" rel="stylesheet">

    @yield('styles')

</head>
