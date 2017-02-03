<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> @section('title') {{ env('CRM_COMPANY') }} @show </title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,500,700" rel="stylesheet" type="text/css">
    <link href="https://so2cloud.s3.amazonaws.com/public/assets/synergyo2corp/bootstrap_3/css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all"/>
    <link href="https://so2cloud.s3.amazonaws.com/public/assets/synergyo2corp/bootstrap_3/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" media="all"/>
    <script src="https://code.jquery.com/jquery-3.1.0.js" integrity="sha256-slogkvB1K3VOkzAI8QITxV3VzpOnkeNVsKvtkYLMjfk="   crossorigin="anonymous"></script>
    <script src="https://so2cloud.s3.amazonaws.com/public/assets/synergyo2corp/bootstrap_3/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="https://so2cloud.s3.amazonaws.com/public/assets/vendor/vuejs/vue.1_0_22.min.js" type="text/javascript"></script>
    <script src="https://so2cloud.s3.amazonaws.com/public/assets/vendor/vuejs/vue-resource.min.js" type="text/javascript"></script>
    <script src="https://npmcdn.com/vue-select@latest"></script>


    @yield('header_styles')

</head>
<body>
@section('top_navigation')
    @yield('content')
    @yield('footer_scripts')
</body>
</html>
