@extends('admin_frontend.layout.master')
@section('content')
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">修改密碼</h4>
            </div>

            <div class="col-sm-6">
                <div class="card card-color">
                    <div class="card-heading bg-gray">
                        <h3 class="card-title m-0">{{$adminToReset['account']}}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{route('Overall.reset_update',$adminToReset['id'])}}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group row">
                                <label for="password" class="col-md-3 form-title">新密碼</label>
                                <div class="col-md-9">
                                    <input type="password" class="form-control" id="password" name="password" required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password_check" class="col-md-3 form-title">確認新密碼</label>
                                <div class="col-md-9">
                                    <input type="password" class="form-control" id="password_check" name="password_check" required="">
                                </div>
                            </div>
                            <input type="checkbox" onclick="myFunction()"> 顯示密碼
                            @if($messageWaining = Session::get('warning'))
                                <div style="color: crimson;font-size: 10px">{{ $messageWaining }}</div>
                            @endif
                            <div class="m-t-10" align="right">
                                <button type="submit" class="btn btn-primary waves-effect waves-light button-font">修改</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid -->

    <script>
        function myFunction() {
            var x = document.getElementById("password");
            var y = document.getElementById("password_check");
            if (x.type === "password" && y.type === "password") {
                x.type = "text";
                y.type = "text";
            } else {
                x.type = "password";
                y.type = "password";
            }
        }
    </script>

@endsection
@section('title','修改密碼')
