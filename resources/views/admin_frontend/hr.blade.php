@extends('admin_frontend.layout.master')
@section('content')
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">人資管理</h4>
            </div>
            <div class="col-sm-12 m-b-20">
                <button class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#choose">新增成員</button>
            </div>


        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid -->

    <!-- sample modal content -->
    <div id="choose" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title mt-0" id="myModalLabel">請選擇加入方式</h4>
                </div>
                <div class="modal-body center">
                    <a href="{{action('AdminHrController@create')}}" class="btn btn-primary btn-lg waves-effect waves-light">單一成員加入</a>
                    <a href="#" class="btn btn-primary btn-lg waves-effect waves-light m-l-10">多位成員加入</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@endsection
@section('title','人資管理')
