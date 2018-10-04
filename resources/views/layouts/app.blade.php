<!DOCTYPE html>
<html dir="ltr" lang="id" >
<!--<![endif]-->
<head>
<title>{{ $title }}</title>
<meta charset="UTF-8" />
<meta name="generator" content="JASTEK">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#fff">
<meta name="title" content="{{ $title }}" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<base href="jastek-service.com" />
<meta name="description" content="Semua service ada disini" />
<meta name="keywords" content="Services pekanbaru" />
@if ($url_login)
<link href="{{ getStatic('css/style.css') }}" rel="stylesheet">
<link href="{{ getStatic('vendors/pace-progress/css/pace.min.css') }}" rel="stylesheet">
@else
<link href="{{ getStatic('css/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ getStatic('css/stylesheet/stylesheet.css') }}" rel="stylesheet">
<link href="{{ getStatic('css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ getStatic('css/jquery/owl-carousel/owl.carousel.css') }}" rel="stylesheet" type="text/css"/>
<link href="//fonts.googleapis.com/css?family=Roboto:400,400i,300,700,500" rel="stylesheet" type="text/css"/>
@endif
</head>
@if ($url_login)
<body class="app flex-row align-items-center">
@else
<body class="common-home" >
@endif
@if (!$url_login)
<script type="text/javascript" src="{{ getStatic('css/jquery/jquery-2.1.1.min.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ getStatic('css/bootstrap/js/bootstrap.min.js') }}" type="text/javascript" ></script>
<script type="text/javascript" src="{{ getStatic('css/jquery/owl-carousel/owl.carousel.min.js') }}" type="text/javascript" ></script>
<script type="text/javascript" src="{{ getStatic('js/vue.min.js') }}" type="text/javascript" ></script>
<script type="text/javascript" src="{{ getStatic('js/main.js') }}" type="text/javascript" ></script>
@endif
@yield('content')
</body>

</html>
