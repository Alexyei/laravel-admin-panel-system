<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="description" content="@yield('meta_desc','Сообщение перед редиректом')">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- fontawesome -->
    <link rel="stylesheet" href="{{asset('styles/all.css')}}">
    <link rel="stylesheet" href="{{asset('styles/auth/auth.css')}}" />
    <link rel="stylesheet" href="{{asset('styles/popup/popup.css')}}">
    <title>@yield('title',$status)</title>
</head>
<body>

<!-- --------------------------- Custom alert-message ---------------------------------------- -->

<div class="bg-modal-popup">
    <div class="popup center">
        <div class="icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <h1 class="title">
            Success!!
        </h1>
        <p class="description">
            Сообщение
        </p>
        <button id="dismiss-popup-btn"  class="btn solid">
            <i class="fas fa-spinner fa-spin del"></i><span class="text">Закрыть</span>
        </button>

    </div>
</div>

<!-- -------------x------------- Custom alert-message--------------------x------------------- -->
<!-- Jquery Library file -->
<script src="{{asset('scripts/Jquery3.4.1.min.js')}}"></script>
<!-- Custom Javascript alert-message -->
<script src="{{asset('scripts/popup/popup.js')}}"></script>
<script>
    modalAlertNotification('{{$message}}','{{$status}}','{{$redirect}}');
        //.then(result=>
        //window.location.href = '{{$redirect}}'
   // );
</script>
</body>
</html>
