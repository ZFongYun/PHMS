@extends('member_frontend.layout.master')
@section('content')
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <p class="page-title">{{$project_name['name']}} | 成果展示</p>
            </div>
            <div class="col-sm-4">
                <a href="#" class="btn btn-primary waves-effect waves-light m-b-15">新增專案</a>
                <div class="alert alert-danger">
                    <strong>未有成果資料</strong>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid -->
@endsection
@section('title','成果展示')
