@extends('admin_frontend.layout.master')
@section('content')
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">編輯資料</h4>
            </div>

            <div class="col-sm-6">
                <div class="card card-color">
                    <div class="card-heading bg-gray">
                        <h3 class="card-title m-0">基本資料</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{action('AdminInfoController@update',$adminToEdit['id'])}}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group row">
                                <label for="account" class="col-md-3 form-title">新帳號</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="account" name="account" required="">
                                </div>
                            </div>
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="m-t-10" align="right">
                                <button type="submit" class="btn btn-primary waves-effect waves-light button-font">編輯</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid -->
@endsection
@section('title','用戶資料')
