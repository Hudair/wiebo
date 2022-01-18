<!--====== jquery js ======-->
<script src="{{asset('assets/front/user/js/vendor/modernizr-3.6.0.min.js')}}"></script>
<script src="{{asset('assets/front/user/js/vendor/jquery-3.4.1.min.js')}}"></script>
<!--====== Bootstrap js ======-->
<script src="{{asset('assets/front/user/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/front/user/js/popper.min.js')}}"></script>
<!--====== Slick js ======-->
<script src="{{asset('assets/front/user/js/slick.min.js')}}"></script>
<!--====== Isotope js ======-->
<script src="{{asset('assets/front/user/js/isotope.pkgd.min.js')}}"></script>
<!--====== Magnific Popup js ======-->
<script src="{{asset('assets/front/user/js/jquery.magnific-popup.min.js')}}"></script>
<!--====== inview js ======-->
<script src="{{asset('assets/front/user/js/jquery.inview.min.js')}}"></script>
<!--====== counterup js ======-->
<script src="{{asset('assets/front/user/js/jquery.countTo.js')}}"></script>
<!--====== easy PieChart js ======-->
<script src="{{asset('assets/front/user/js/jquery.easypiechart.min.js')}}"></script>
<!--====== Jquery Ui ======-->
<script src="{{asset('assets/front/user/js/jquery-ui.min.js')}}"></script>

<!-- jQuery Timepicker -->
<script src="{{asset('assets/front/js/jquery.timepicker.min.js')}}"></script>
<!--====== Wow JS ======-->
<script src="{{asset('assets/front/user/js/wow.min.js')}}"></script>
<!--====== Wow JS ======-->
<script src="{{asset('assets/front/user/js/lazyload.min.js')}}"></script>

<script>
    "use strict";
    var rtl = {{$userCurrentLang->rtl}};
</script>
<!--====== Main js ======-->
<script src="{{asset('assets/front/user/js/main.js')}}"></script>
<!--====== Custom js ======-->
<script src="{{asset('assets/front/user/js/custom.js')}}"></script>



@yield('scripts')

@if (session()->has('success'))
    <script>
        "use strict";
        toastr['success']("{{ __(session('success')) }}");
    </script>
@endif

@if (session()->has('error'))
    <script>
        "use strict";
        toastr['error']("{{ __(session('error')) }}");
    </script>
@endif

@if (session()->has('warning'))
    <script>
        "use strict";
        toastr['warning']("{{ __(session('warning')) }}");
    </script>
@endif
