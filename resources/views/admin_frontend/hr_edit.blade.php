@extends('admin_frontend.layout.master')
@section('content')

    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">編輯成員</h4>
                <h5 class="star">注意！「*」為必填欄位</h5>
                <form action="{{action('AdminHrController@update',$memberToEdit['id'])}}" method="post">
                    {{ csrf_field() }}
                    <p class="little-title">基本資料</p>
                    <div class="col-md-8">
                        <div class="form-group row">
                            <label for="name" class="col-md-2 control-label form-title"><span class="text-danger">*</span>姓名</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="name" name="name" required="" value="{{$memberToEdit['name']}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="student_id" class="col-md-2 control-label form-title"><span class="text-danger">*</span>學號</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="student_id" name="student_id" required="" value="{{$memberToEdit['student_ID']}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-2 control-label form-title">電子郵件</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="email" name="email" value="{{$memberToEdit['email']}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="join_year" class="col-md-2 control-label form-title"><span class="text-danger">*</span>加入學年度</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="join_year" name="join_year" required="" value="{{$memberToEdit['join_year']}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="title" class="col-md-2 control-label form-title"><span class="text-danger">*</span>職稱</label>
                            <div class="col-md-8">
                                <select class="form-control" id="title" name="title">
                                    <option>請選擇</option>
                                    <option value="0" {{$memberToEdit['title'] == 0 ? 'selected' : ''}}>專任教授</option>
                                    <option value="1" {{$memberToEdit['title'] == 1 ? 'selected' : ''}}>知點助理</option>
                                    <option value="2" {{$memberToEdit['title'] == 2 ? 'selected' : ''}}>企劃</option>
                                    <option value="3" {{$memberToEdit['title'] == 3 ? 'selected' : ''}}>程式</option>
                                    <option value="4" {{$memberToEdit['title'] == 4 ? 'selected' : ''}}>美術</option>
                                    <option value="5" {{$memberToEdit['title'] == 5 ? 'selected' : ''}}>技美</option>
                                    <option value="6" {{$memberToEdit['title'] == 6 ? 'selected' : ''}}>無</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="position" class="col-md-2 control-label form-title"><span class="text-danger">*</span>知點職務</label>
                            <div class="col-md-8">
                                <select class="form-control" id="position" name="position">
                                    <option>請選擇</option>
                                    <option value="0" {{$member_position[0]['position'] == 0 ? 'selected' : ''}}>PM</option>
                                    <option value="1" {{$member_position[0]['position'] == 1 ? 'selected' : ''}}>HR</option>
                                    <option value="2" {{$member_position[0]['position'] == 2 ? 'selected' : ''}}>核銷</option>
                                    <option value="3" {{$member_position[0]['position'] == 3 ? 'selected' : ''}}>行政</option>
                                    <option value="4" {{$member_position[0]['position'] == 4 ? 'selected' : ''}}>企劃講師</option>
                                    <option value="5" {{$member_position[0]['position'] == 5 ? 'selected' : ''}}>程式講師</option>
                                    <option value="6" {{$member_position[0]['position'] == 6 ? 'selected' : ''}}>美術講師</option>
                                    <option value="7" {{$member_position[0]['position'] == 7 ? 'selected' : ''}}>企劃助教</option>
                                    <option value="8" {{$member_position[0]['position'] == 8 ? 'selected' : ''}}>程式助教</option>
                                    <option value="9" {{$member_position[0]['position'] == 9 ? 'selected' : ''}}>美術助教</option>
                                    <option value="10" {{$member_position[0]['position'] == 10 ? 'selected' : ''}}>無</option>
                                </select>
                                <button type="button" onclick="add_field()" class="btn btn-primary btn-sm m-t-10 m-b-10 waves-effect waves-light button-font">再新增一列</button>
                                    @for($i=1; $i<count($member_position); $i++)
                                    <div id="position{{$member_position[$i]['id']}}">
                                        <select class="form-control-select m-b-10" id="position" name="position_mu[]">
                                            <option>請選擇</option>
                                            <option value="0" {{$member_position[$i]['position'] == 0 ? 'selected' : ''}}>PM</option>
                                            <option value="1" {{$member_position[$i]['position'] == 1 ? 'selected' : ''}}>HR</option>
                                            <option value="2" {{$member_position[$i]['position'] == 2 ? 'selected' : ''}}>核銷</option>
                                            <option value="3" {{$member_position[$i]['position'] == 3 ? 'selected' : ''}}>行政</option>
                                            <option value="4" {{$member_position[$i]['position'] == 4 ? 'selected' : ''}}>企劃講師</option>
                                            <option value="5" {{$member_position[$i]['position'] == 5 ? 'selected' : ''}}>程式講師</option>
                                            <option value="6" {{$member_position[$i]['position'] == 6 ? 'selected' : ''}}>美術講師</option>
                                            <option value="7" {{$member_position[$i]['position'] == 7 ? 'selected' : ''}}>企劃助教</option>
                                            <option value="8" {{$member_position[$i]['position'] == 8 ? 'selected' : ''}}>程式助教</option>
                                            <option value="9" {{$member_position[$i]['position'] == 9 ? 'selected' : ''}}>美術助教</option>
                                            <option value="10" {{$member_position[$i]['position'] == 10 ? 'selected' : ''}}>無</option>
                                        </select>
                                        <button type="button" value="Remove" onclick = "RemoveExistSelect(position{{$member_position[$i]['id']}})" class="btn-sm btn-rounded waves-effect waves-light btn-danger m-l-10"> <i class="fa fa-remove"></i></button>
                                    </div>
                                @endfor
                                <div id="main"></div>
                            </div>

                        </div>
                    </div>
                    <p class="little-title">專長介紹</p>
                    <div class="col-md-8">
                        <div class="form-group row">
                            <div class="col-md-8">
                                <textarea id="skill" name="skill" class="form-control" maxlength="225" rows="2">{{$memberToEdit['skill']}}</textarea>
                            </div>
                        </div>
                    </div>
                    <p class="little-title">歷年製作的專案項目</p>
                    <div class="col-md-8 m-b-15">
                        @foreach($project as $row)
                            <input type="checkbox" id="project{{$row['id']}}" name="project[]" value="{{$row['id']}}"
                                   @foreach($project_is_chk as $item)
                                        @if($item->id == $row['id'])
                                            checked
                                        @endif
                                    @endforeach
                            >
                            <label for="project{{$row['id']}}" class="control-label  form-title p-r-10">{{$row['name']}}</label>
                            <br>
                        @endforeach
                    </div>
                    <p class="little-title">備註</p>
                    <div class="col-md-8">
                        <div class="form-group row">
                            <div class="col-md-8">
                                <textarea id="remark" name="remark" class="form-control" maxlength="225" rows="2">{{$memberToEdit['remark']}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="m-t-30">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit" class="btn btn-warning w-md waves-effect waves-light button-font">編輯</button>
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
        '<button type="button" value="Remove" onclick = "RemoveSelect(this)" class="btn-sm btn-rounded waves-effect waves-light btn-danger m-l-10"> <i class="fa fa-remove"></i></button>'
    }

    function add_field() {
        var div = document.createElement('DIV');
        div.innerHTML = GetDynamicTextBox("");
        document.getElementById("main").appendChild(div);
    }

    function RemoveSelect(div) {
        document.getElementById("main").removeChild(div.parentNode);
    }

    function RemoveExistSelect(myObj) {
        var parentObj = myObj.parentNode;
        parentObj.removeChild(myObj);
    }


</script>
@endsection
@section('title','編輯成員')
