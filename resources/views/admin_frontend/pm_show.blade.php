@extends('admin_frontend.layout.master')
@section('content')
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">專案詳情</h4>
                <dl class="row m-b-10" style="padding-left: 30px;">
                    <dt class="col-sm-2">專案名稱</dt>
                    <dd class="col-sm-9">{{$projectToShow['name']}}</dd>
                    <dt class="col-sm-2">簡述</dt>
                    <dd class="col-sm-9">{{$projectToShow['content']}}</dd>
                    <dt class="col-sm-2">專案學年期</dt>
                    <dd class="col-sm-9">{{$projectToShow['school_year']}}-0{{$projectToShow['semester']}}</dd>
                    <dt class="col-sm-2">開始日期</dt>
                    <dd class="col-sm-9">{{$projectToShow['start_date']}}</dd>
                    <dt class="col-sm-2">結束日期</dt>
                    <dd class="col-sm-9">{{$projectToShow['end_date']}}</dd>
                    <dt class="col-sm-2">狀態</dt>
                    <dd class="col-sm-9">{{$projectToShow['status']}}</dd>
                    <dt class="col-sm-2">參與成員</dt>
                    <dd class="col-sm-9">{{$projectToShow['status']}}</dd>
                </dl>
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid -->

@endsection
@section('title','專案詳情')
