<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <title>@yield('title')</title>

    {{--    <!-- Custom box css -->--}}
    {{--    <link href="{{ URL::asset('../plugins/custombox/dist/custombox.min.css') }}" rel="stylesheet">--}}

    {{--    <!-- Date picker css -->--}}
{{--    <link href="{{ URL::asset('../plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">--}}

{{--    <!-- Time picker css -->--}}
{{--    <link href="{{ URL::asset('../plugins/timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet">--}}

<!-- form Uploads -->
{{--    <link href="{{ URL::asset('../plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" type="text/css" />--}}

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

<!-- Modal-Effect -->
{{--<script src="{{ URL::asset('../plugins/custombox/dist/custombox.min.js') }}"></script>--}}

<!-- App js -->
<script src="{{ URL::asset('assets_member/js/jquery.core.js') }}"></script>
<script src="{{ URL::asset('assets_member/js/jquery.app.js') }}"></script>

<!-- Plugins Js -->
{{--<script src="{{ URL::asset('../plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>--}}
{{--<script src="{{ URL::asset('../plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>--}}

<!-- file uploads js -->
{{--<script src="{{ URL::asset('../plugins/dropify/js/dropify.min.js') }}"></script>--}}

<script>
    // Date Picker
    // jQuery('#datepicker-project-start').datepicker();
    // jQuery('#datepicker-project-end').datepicker();

    // Time Picker
    // jQuery('#timepicker-start').timepicker({
    //     showMeridian : false
    // });

    // jQuery('#timepicker-end').timepicker({
    //     showMeridian : false
    // });

    // jQuery('#timepicker-upload').timepicker({
    //     showMeridian : false
    // });

    // $('.dropify').dropify({
    //     messages: {
    //         'default': '請將文件拖放到此處或單擊該區域上傳文件。',
    //         'replace': '請將文件拖放到此處或單擊該區域上傳文件。',
    //         'remove': '移除',
    //         'error': '發生錯誤，請重新上傳。'
    //     },
    //     error: {
    //         'fileSize': 'The file size is too big (1M max).'
    //     }
    // });
</script>

</body>
</html>
