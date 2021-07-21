@extends('member_frontend.layout.master')
@section('content')
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">新增進度</h4>
                <h5 class="star">注意！「*」為必填欄位</h5>
                <form action="{{route('Overall.member_schdlm_store',$id)}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="col-md-8">
                        <div class="form-group row">
                            <label for="name" class="col-md-2 control-label form-title">進度標題*</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="name" name="name" required="">
                            </div>
                        </div>

                        <div class="input-group row">
                            <label for="project_start" class="col-md-2 control-label form-title">進度起止日期*</label>
                            <div class="col-md-8">
                                <div class="input-group m-b-10">
                                    <input type="text" class="form-control" placeholder="yyyy-mm-dd" id="datepicker_schdl_start" name="schdl_start" required="">
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-primary b-0 text-white"><i class="ti-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="input-group m-b-10">
                                    <input type="text" class="form-control" placeholder="yyyy-mm-dd" id="datepicker_schdl_end" name="schdl_end">
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-primary b-0 text-white"><i class="ti-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row m-b-0">
                            <label for="status" class="col-md-2 control-label form-title">進度上傳*</label>
                            <div class="col-md-8">
                                <input type="file" name="file" class="dropify" data-height="100" accept=".ppt,.pptx,.rar,.zip" data-max-file-size="50M"/>
                                <p class="text-danger m-b-0"><strong><ins>{{ $errors->first('file') }}</ins></strong></p>
                                <label class="text-primary">*上傳格式：ppt、pptx、zip、rar<br>*檔案大小限制：50MB</label>
                            </div>
                        </div>

                        <div class="form-group row m-b-15">
                            <label for="status" class="col-md-2 control-label form-title">考核期限*</label>
                            <div class="col-md-8">
                                <div class="input-group m-b-5">
                                    <input type="text" class="form-control" placeholder="yyyy-mm-dd" id="datepicker_limit_start" name="limit_start_data" required="">
                                    <div class="input-group-append m-r-5">
                                        <span class="input-group-text bg-primary b-0 text-white"><i class="ti-calendar"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="timepicker_limit_start" name="limit_start_time">
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-primary text-white"><i class="zmdi zmdi-time"></i></span>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="yyyy-mm-dd" id="datepicker_limit_end" name="limit_end_data" required="">
                                    <div class="input-group-append m-r-5">
                                        <span class="input-group-text bg-primary b-0 text-white"><i class="ti-calendar"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="timepicker_limit_end" name="limit_end_time">
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-primary text-white"><i class="zmdi zmdi-time"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="remark" class="col-md-2 control-label form-title">備註</label>
                            <div class="col-md-8">
                                <textarea id="remark" name="remark" class="form-control" maxlength="225" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success w-md waves-effect waves-light button-font">新增</button>
                    </div><!-- end col -->
                </form>
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid -->
@endsection
@section('title','新增進度')
