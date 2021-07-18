@extends('member_frontend.layout.master')
@section('content')
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">編輯用戶資料</h4>
                <h5 class="star">注意！「*」為必填欄位</h5>
                <form action="{{action('MemberInfoController@update',$memberToEdit['id'])}}" method="post">
                    {{ csrf_field() }}
                    <p class="little-title">基本資料</p>
                    <div class="col-md-8">
                        <div class="form-group row">
                            <label for="name" class="col-md-2 control-label form-title">姓名*</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="name" name="name" required="" value="{{$memberToEdit['name']}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="student_id" class="col-md-2 control-label form-title">學號*</label>
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
                            <label for="join_year" class="col-md-2 control-label form-title">加入學年度*</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="join_year" name="join_year" required="" value="{{$memberToEdit['join_year']}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="title" class="col-md-2 control-label form-title">職稱*</label>
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
@endsection
@section('title','編輯用戶資料')
