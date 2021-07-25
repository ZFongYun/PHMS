@extends('member_frontend.layout.master')
@section('content')
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <p class="page-title">{{$project_name['name']}} | 成果展示</p>
            </div>
            <div class="col-sm-4">
                <a href="#" class="btn btn-warning waves-effect waves-light m-b-15">編輯專案</a>
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid -->
@endsection
@section('title','成果展示')
