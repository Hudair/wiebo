<!--====== Favicon Icon ======-->
<link rel="shortcut icon" href="{{!empty($userBs->favicon) ? asset('assets/front/img/user/'.$userBs->favicon) : ''}}" type="img/png" />
<!--====== Animate Css ======-->
<link rel="stylesheet" href="{{asset('assets/front/user/css/animate.min.css')}}">
<!--====== Bootstrap css ======-->
<link rel="stylesheet" href="{{asset('assets/front/user/css/bootstrap.min.css')}}" />
<!--====== Fontawesome css ======-->
<link rel="stylesheet" href="{{asset('assets/front/user/css/font-awesome.min.css')}}" />
<!--====== Flaticon css ======-->
<link rel="stylesheet" href="{{asset('assets/front/user/css/flaticon.css')}}" />
<!--====== Magnific Popup css ======-->
<link rel="stylesheet" href="{{asset('assets/front/user/css/magnific-popup.css')}}" />
<!--====== Slick  css ======-->
<link rel="stylesheet" href="{{asset('assets/front/user/css/slick.css')}}" />
<!--====== Jquery ui ======-->
<link rel="stylesheet" href="{{asset('assets/front/user/css/jquery-ui.min.css')}}" />
<link rel="stylesheet" href="{{asset('assets/admin/css/jquery.timepicker.min.css')}}">
<!--====== Style css ======-->
<link rel="stylesheet" href="{{asset('assets/front/user/css/style.css')}}" />

@if($userCurrentLang->rtl == 1) 
<link rel="stylesheet" href="{{asset('assets/front/user/css/rtl-style.css')}}" />
<link rel="stylesheet" href="{{asset('assets/front/user/css/rtl-responsive.css')}}" />
@endif

<!--====== Base color ======-->
@php
    if(!empty($userBs->base_color)) {
        $baseColor = $userBs->base_color;
    } else {
        $baseColor = '';
    }
@endphp
<link rel="stylesheet" href="{{asset('assets/front/user/css/base-color.php?color=' . $baseColor)}}">

@yield('styles')
