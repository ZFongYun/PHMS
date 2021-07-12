@extends('admin_frontend.layout.master')
@section('content')
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">新增專案</h4>
                <h5 class="star">注意！「*」為必填欄位</h5>
                <form action="{{action('AdminPmController@store')}}" method="post">
                    {{ csrf_field() }}
                    <div class="col-md-8">
                        <div class="form-group row">
                            <label for="name" class="col-md-2 control-label form-title">專案姓名*</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="name" name="name" required="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="content" class="col-md-2 control-label form-title">簡述</label>
                            <div class="col-md-8">
                                <textarea id="content" name="content" class="form-control" maxlength="225" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="school_year" class="col-md-2 control-label form-title">專案學年期*</label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="text" class="form-control m-r-10" id="school_year" name="school_year" required="">
                                    <select class="form-control" id="semester" name="semester">
                                        <option value="0">上學期</option>
                                        <option value="1">下學期</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="input-group row">
                            <label for="project-start" class="col-md-2 control-label form-title">開始日期*</label>
                            <div class="col-md-8">
                                <div class="input-group m-b-10">
                                    <input type="text" class="form-control" placeholder="yyyy-mm-dd" id="datepicker-project-start" name="project-start" required="">
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-primary b-0 text-white"><i class="ti-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- input-group -->
                        <div class="input-group row">
                            <label for="project-end" class="col-md-2 control-label form-title">結束日期</label>
                            <div class="col-md-8">
                                <div class="input-group m-b-10">
                                    <input type="text" class="form-control" placeholder="yyyy-mm-dd" id="datepicker-project-end" name="project-end">
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-primary b-0 text-white"><i class="ti-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- input-group -->
                        <div class="form-group row">
                            <label for="status" class="col-md-2 control-label form-title">狀態*</label>
                            <div class="col-md-8">
                                <select class="form-control" id="status" name="status">
                                    <option value="3">請選擇</option>
                                    <option value="0">執行中</option>
                                    <option value="1">測試</option>
                                    <option value="2">完成</option>
                                    <option value="3">關閉</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 control-label form-title">參與成員*</label>
                            <div class="col-md-8">
                                <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#select-member">選擇</button>
                                <div id="member"></div>
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

    <!-- select modal content -->
    <div id="select-member" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title mt-0" id="myModalLabel">請選擇成員</h4>
                </div>
                <div class="modal-body">

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script>


    </script>
@endsection
@section('title','新增專案')
