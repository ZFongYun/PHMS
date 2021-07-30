<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <title>@yield('title')</title>

    {{--    <!-- Date picker css -->--}}
    <link href="{{ URL::asset('../plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">

    {{--    <!-- Time picker css -->--}}
    <link href="{{ URL::asset('../plugins/timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet">

    <!-- form Uploads -->
    <link href="{{ URL::asset('../plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ URL::asset('assets_member/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets_member/css/icons.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets_member/css/style.css') }}" rel="stylesheet" type="text/css" />

    <script src="{{ URL::asset('assets_member/js/modernizr.min.js') }}"></script>

</head>

<body>

<!-- Begin page -->
<div class="wrapper">

    @include('member_frontend.layout.header')

    @yield('content')

</div>
<!-- END wrapper -->

<script>
    var resizefunc = [];
</script>

<!-- jQuery  -->
<script src="{{ URL::asset('assets_member/js/jquery.min.js') }}"></script>
<script src="{{ URL::asset('assets_member/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ URL::asset('assets_member/js/detect.js') }}"></script>
<script src="{{ URL::asset('assets_member/js/fastclick.js') }}"></script>
<script src="{{ URL::asset('assets_member/js/jquery.slimscroll.js') }}"></script>
<script src="{{ URL::asset('assets_member/js/jquery.blockUI.js') }}"></script>
<script src="{{ URL::asset('assets_member/js/waves.js') }}"></script>
<script src="{{ URL::asset('assets_member/js/wow.min.js') }}"></script>
<script src="{{ URL::asset('assets_member/js/jquery.nicescroll.js') }}"></script>
<script src="{{ URL::asset('assets_member/js/jquery.scrollTo.min.js') }}"></script>

<!-- App js -->
<script src="{{ URL::asset('assets_member/js/jquery.core.js') }}"></script>
<script src="{{ URL::asset('assets_member/js/jquery.app.js') }}"></script>

<!-- Plugins Js -->
<script src="{{ URL::asset('../plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
<script src="{{ URL::asset('../plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ URL::asset('../plugins/dropify/js/dropify.min.js') }}"></script>

<script>
    // Date Picker
    jQuery('#datepicker-project-start').datepicker(); //專案開始日期
    jQuery('#datepicker-project-end').datepicker(); //專案結束日期
    jQuery('#datepicker_schdl_start').datepicker(); //進度開始日期
    jQuery('#datepicker_schdl_end').datepicker(); //進度結束日期
    jQuery('#datepicker_limit_end').datepicker(); //考核結束日期

    // Time Picker
    jQuery('#timepicker_limit_end').timepicker({
        showMeridian : false
    });

    $('.dropify').dropify({
        messages: {
            'default': '請將文件拖放到此處或單擊該區域上傳文件。',
            'replace': '請將文件拖放到此處或單擊該區域上傳文件。',
            'remove': '移除',
            'error': '發生錯誤，請重新上傳。'
        },
        error: {
            'fileSize': '檔案大小超出規定。'
        }
    });
</script>

</body>
</html>
