@extends('admin_frontend.layout.master')
@section('content')
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">單一新增成員</h4>
                <h5 class="star">注意！「*」為必填欄位</h5>
                <form action="{{action('AdminHrController@store')}}" method="post">
                    {{ csrf_field() }}
                    <p class="little-title">基本資料</p>
                    <div class="col-md-8">
                        <div class="form-group row">
                            <label for="name" class="col-md-2 control-label form-title">姓名*</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="name" name="name" required="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="student_id" class="col-md-2 control-label form-title">學號*</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="student_id" name="student_id" required="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-2 control-label form-title">電子郵件</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="email" name="email" required="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="join_year" class="col-md-2 control-label form-title">加入學年度*</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="join_year" name="join_year" required="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="title" class="col-md-2 control-label form-title">職稱*</label>
                            <div class="col-md-8">
                                <select class="form-control" id="title" name="title">
                                    <option>請選擇</option>
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
                            <label for="position" class="col-md-2 control-label form-title">知點職務*</label>
                            <div class="col-md-8">
                                <select class="form-control" id="position" name="position">
                                    <option>請選擇</option>
                                    <option value="0">PM</option>
                                    <option value="1">HR</option>
                                    <option value="2">核銷</option>
                                    <option value="3">行政</option>
                                    <option value="4">企劃講師</option>
                                    <option value="5">程式講師</option>
                                    <option value="6">美術講師</option>
                                    <option value="7">企劃助教</option>
                                    <option value="8">程式助教</option>
                                    <option value="9">美術助教</option>
                                    <option value="10">無</option>
                                </select>
                                <button type="button" onclick="add_field()" class="btn btn-primary btn-sm m-t-10 waves-effect waves-light button-font">再新增一列</button>
                                <div id="main" class="m-t-10"></div>
                            </div>

                        </div>
                    </div>
                    <p class="little-title">專長介紹</p>
                    <div class="col-md-8">
                        <div class="form-group row">
                            <div class="col-md-8">
                                <textarea id="skill" name="skill" class="form-control" maxlength="225" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                    <p class="little-title">歷年製作的專案項目</p>
                    <div class="col-md-8 m-b-15">
                        @foreach($project as $row)
                            <input type="checkbox" id="project{{$row['id']}}" name="project[]" value="{{$row['id']}}">
                            <label for="project{{$row['id']}}" class="control-label  form-title p-r-10">{{$row['name']}}</label>
                            <br>
                        @endforeach
                    </div>
                    <p class="little-title">帳戶設定</p>
                    <div class="col-md-8">
                        <div class="form-group row">
                            <label for="password" class="col-md-2 control-label form-title">預設密碼*</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="password" name="password" required="">
                            </div>
                        </div>
                    </div>
                    <p class="little-title">備註</p>
                    <div class="col-md-8">
                        <div class="form-group row">
                            <div class="col-md-8">
                                <textarea id="remark" name="remark" class="form-control" maxlength="225" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="m-t-30">
                        <button type="submit" class="btn btn-success w-md waves-effect waves-light button-font">新增</button>
                    </div><!-- end col -->
                </form>
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid -->

    <script>
        function GetDynamicTextBox(value){
            return '<select class="form-control-select m-b-10" id="position" name="position_mu[]">'+
                '<option>請選擇</option>'+
                '<option value="0">PM</option>'+
                '<option value="1">HR</option>'+
                '<option value="2">核銷</option>'+
                '<option value="3">行政</option>'+
                '<option value="4">企劃講師</option>'+
                '<option value="5">程式講師</option>'+
                '<option value="6">美術講師</option>'+
                '<option value="7">企劃助教</option>'+
                '<option value="8">程式助教</option>'+
                '<option value="9">美術助教</option>'+
                '</select>'+
                '<button type="button" value="Remove" onclick = "RemoveTextBox(this)" class="btn-sm btn-rounded waves-effect waves-light btn-danger m-l-10"> <i class="fa fa-remove"></i></button>'
        }

        function add_field() {
            var div = document.createElement('DIV');
            div.innerHTML = GetDynamicTextBox("");
            document.getElementById("main").appendChild(div);
        }

        function RemoveTextBox(div) {
            document.getElementById("main").removeChild(div.parentNode);
        }


    </script>
@endsection
@section('title','新增成員')
