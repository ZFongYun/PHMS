@extends('admin_frontend.layout.master')
@section('content')
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">編輯專案</h4>
                <form action="{{action('AdminPmController@update',$projectToEdit['id'])}}" method="post">
                    {{ csrf_field() }}
                    <div class="col-md-8">
                        <h5 class="star">注意！「*」為必填欄位</h5>
                        <div class="form-group row">
                            <label for="name" class="col-md-2 control-label form-title"><span class="text-danger">*</span>專案姓名</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="name" name="name" required="" value="{{$projectToEdit['name']}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="content" class="col-md-2 control-label form-title">簡述</label>
                            <div class="col-md-8">
                                <textarea id="content" name="content" class="form-control" maxlength="225" rows="2">{{$projectToEdit['content']}}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="school_year" class="col-md-2 control-label form-title"><span class="text-danger">*</span>專案學年期</label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="text" class="form-control m-r-10" id="school_year" name="school_year" required="" value="{{$projectToEdit['school_year']}}">
                                    <select class="form-control" id="semester" name="semester">
                                        <option value="0" {{$projectToEdit['semester'] == 0 ? 'selected' : ''}}>上學期</option>
                                        <option value="1" {{$projectToEdit['semester'] == 1 ? 'selected' : ''}}>下學期</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="input-group row">
                            <label for="project_start" class="col-md-2 control-label form-title"><span class="text-danger">*</span>開始日期</label>
                            <div class="col-md-8">
                                <div class="input-group m-b-10">
                                    <input type="text" class="form-control" placeholder="yyyy-mm-dd" id="datepicker-project-start" name="project_start" required="" value="{{$projectToEdit['start_date']}}">
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-primary b-0 text-white"><i class="ti-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- input-group -->
                        <div class="input-group row">
                            <label for="project_end" class="col-md-2 control-label form-title">結束日期</label>
                            <div class="col-md-8">
                                <div class="input-group m-b-10">
                                    <input type="text" class="form-control" placeholder="yyyy-mm-dd" id="datepicker-project-end" name="project_end" value="{{$projectToEdit['end_date']}}">
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-primary b-0 text-white"><i class="ti-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- input-group -->
                        <div class="form-group row">
                            <label for="status" class="col-md-2 control-label form-title"><span class="text-danger">*</span>狀態</label>
                            <div class="col-md-8">
                                <select class="form-control" id="status" name="status">
                                    <option value="3">請選擇</option>
                                    <option value="0" {{$projectToEdit['status'] == 0 ? 'selected' : ''}}>執行中</option>
                                    <option value="1" {{$projectToEdit['status'] == 1 ? 'selected' : ''}}>測試</option>
                                    <option value="2" {{$projectToEdit['status'] == 2 ? 'selected' : ''}}>完成</option>
                                    <option value="3" {{$projectToEdit['status'] == 3 ? 'selected' : ''}}>關閉</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 control-label form-title"><span class="text-danger">*</span>參與成員</label>
                            <div class="col-md-8">
                                <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#select-member">選擇</button>
                                <label>已選擇..</label>
                                <span class="m-t-5" id="member"></span>
                                <input type="hidden" id="memberId" name="memberId">
                            </div>
                        </div>
                    </div>
                    <div>
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

    <!-- select modal content -->
    <div id="select-member" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title mt-0" id="myModalLabel">請選擇成員</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-hover m-0">
                            <thead>
                            <tr>
                                <th></th>
                                <th>加入學年度</th>
                                <th>學號</th>
                                <th>姓名</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($member as $row)
                                <tr>
                                    <td><input type="checkbox" class="memberCheckbox" name="member[]" id="{{$row['name']}}" value="{{$row['id']}}"
                                               @foreach($member_is_checked as $item)
                                                    @if($item->id == $row['id'])
                                                        checked
                                                    @endif
                                                @endforeach
                                        ></td>
                                    <td>{{$row['join_year']}}</td>
                                    <td>{{$row['student_ID']}}</td>
                                    <td>{{$row['name']}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="search btn waves-effect waves-light btn-primary" data-dismiss="modal">確認</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $( document ).ready(function() {
            var member = '';
            var checkedValue = [];
            var inputElements = document.getElementsByClassName('memberCheckbox');
            for(var i=0; inputElements[i]; ++i){
                if(inputElements[i].checked){
                    checkedValue.push(inputElements[i].value);
                    member += '<label>'+ inputElements[i].id + '／' + '</label>';
                }
            }
            $('#member').html(member);
            $('#memberId').val(checkedValue);
        });

        $(document).on('click', '.search', function() {
            var member = '';
            var checkedValue = [];
            var inputElements = document.getElementsByClassName('memberCheckbox');
            for(var i=0; inputElements[i]; ++i){
                if(inputElements[i].checked){
                    checkedValue.push(inputElements[i].value);
                    member += '<label>'+ inputElements[i].id + '／' + '</label>';
                }
            }
            $('#member').html(member);
            $('#memberId').val(checkedValue);
        });
    </script>
@endsection
@section('title','編輯專案')
