@extends('admin_frontend.layout.master')
@section('content')
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">用戶資料</h4>
            </div>
            <div class="col-sm-12 m-b-20">
                <a href="{{action('AdminInfoController@edit',$adminToIndex['id'])}}" class="btn btn-warning waves-effect waves-light">編輯</a>
                <a href="{{route('Overall.reset_edit',$adminToIndex['id'])}}" class="btn btn-info waves-effect waves-light m-l-10">修改密碼</a>
            </div>

            <div class="col-lg-6">
                <div class="card card-color">
                    <div class="card-heading bg-gray">
                        <h3 class="card-title m-0">帳號資料</h3>
                    </div>
                    <div class="card-body">
                        <p>帳號：{{$adminToIndex['account']}}</p>
                        <p>
                            @if($adminToIndex['access'] == '0')
                                用戶類型：超級管理者[老師]
                            @else
                                用戶類型：⼀般管理者[助教/⾏政⼈員]
                            @endif
                        </p>
                    </div>
                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid -->
@endsection
@section('title','用戶資料')
