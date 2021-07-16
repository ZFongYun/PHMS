<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">

    <!-- App title -->
    <title>一般用戶註冊</title>

    <!-- App CSS -->
    <link href="{{ URL::asset('assets_member/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets_member/css/icons.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets_member/css/style.css') }}" rel="stylesheet" type="text/css" />

    <script src="{{ URL::asset('assets_member/js/modernizr.min.js') }}"></script>

</head>
<body>
<div class="wrapper-page row">
        <div class="col-sm-6" style="border:5px #FFAC55 solid;">
            <div class="text-center logo-alt-box">
                <p class="logo"><span class="text-inverse">專案暨人資考核系統</span></p>
                <h4 class="text-uppercase font-bold">用戶註冊</h4>
            </div>
        </div>
        <div class="col-sm-6" style="border:5px #1c7430 solid;">
        <div class="m-t-30 card card-body">
                <form action="{{action('MemberController@authenticate')}}" method="post">
                    {{ csrf_field() }}
                    <p><mark>請輸入用戶資料</mark></p>
                    <div class="form-group row">
                        <label for="student_id" class="col-md-4 control-label form-title">帳號/學號</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="student_id" name="student_id" required="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-md-4 control-label form-title">姓名</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="name" name="name" required="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="join_year" class="col-md-4 control-label form-title">加入學年度</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="join_year" name="join_year" required="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="title" class="col-md-4 control-label form-title">職稱</label>
                        <div class="col-md-8">
                            <select class="form-control" id="title" name="title">
                                <option value="6">請選擇</option>
                                <option value="0">專任教授</option>
                                <option value="1">知點助理</option>
                                <option value="2">企劃</option>
                                <option value="3">程式</option>
                                <option value="4">美術</option>
                                <option value="5">技美</option>
                                <option value="6">無</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-md-4 control-label form-title">密碼</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="password" name="password" required="">
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-12">
                            <button class="btn btn-success btn-bordred btn-block waves-effect waves-light text-uppercase" type="submit">註冊</button>
                        </div>
                    </div>
                    <div class="form-group m-t-20 m-b-0 text-center">
                        <div class="col-sm-12">
                            <a href="#" class="btn btn-link waves-effect waves-light">前往登入</a>
                        </div>
                    </div>
                </form>
        </div>
        <!-- end card-box -->
    </div>
</div>
{{--<!-- end wrapper page -->--}}

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

</body>
</html>
