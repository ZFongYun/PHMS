@extends('admin_frontend.layout.master')
@section('content')
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="btn-group float-right m-t-25">
                    <button type="button" class="btn btn-custom dropdown-toggle page-title-drop waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Settings <span class="m-l-5"><i class="fa fa-cog"></i></span></button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><a href="#" class="dropdown-item">Action</a></li>
                        <li><a href="#" class="dropdown-item">Another action</a></li>
                        <li><a href="#" class="dropdown-item">Something else here</a></li>
                        <li class="dropdown-divider"></li>
                        <li><a href="#" class="dropdown-item">Separated link</a></li>
                    </ul>
                </div>
                <h4 class="page-title">用戶資料</h4>
            </div>
        </div>
        <!-- end row -->

    </div>
    <!-- end container-fluid -->
@endsection
@section('title','用戶資料')
