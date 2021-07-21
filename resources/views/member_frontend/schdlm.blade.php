@extends('member_frontend.layout.master')
@section('content')
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">進度管理</h4>
            </div>
            <div class="col-sm-4 m-b-15">
                <a href="{{route('Overall.member_schdlm_create',$id)}}" class="btn btn-primary waves-effect waves-light">新增進度</a>
            </div>
            <div class="col-sm-8 m-b-15" align="right">
                <div class="input-group col-sm-9">
                    <button type="button" class="btn waves-effect waves-light btn-primary btn-sm m-r-5" onclick="displayAllData()">顯示全部資料</button>
                    <select class="form-control-select col-sm-3 m-r-5" id="target" name="target">
                        <option>請選擇</option>
                        <option value="0">標題</option>
                        <option value="1">考核狀態</option>
                    </select>
                    <input type="text" class="form-control" placeholder="表格搜尋" id="keyword" name="keyword">
                    <select class="form-control-select col-sm-5" style="display: none" id="keyword_status" name="keyword_status">
                        <option value="0">未開始</option>
                        <option value="1">考核中</option>
                        <option value="2">已結束</option>
                    </select>
                    <span class="input-group-prepend">
                        <button type="button" class="search btn waves-effect waves-light btn-primary"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </div>

            {{--   all_data_table   --}}
            <div class="table-responsive">
                <table class="table table-hover m-0" id="all_data_table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>標題</th>
                        <th>進度起止日</th>
                        <th>進度下載</th>
                        <th>考核</th>
                        <th>考核狀態</th>
                        <th>編輯</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>

            {{--   search_data_table   --}}
            <div class="table-responsive">
                <table class="table table-hover m-0" style="display: none" id="search_data_table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>標題</th>
                        <th>進度起止日</th>
                        <th>進度下載</th>
                        <th>考核</th>
                        <th>考核狀態</th>
                        <th>編輯</th>
                    </tr>
                    </thead>
                    <tbody id="search_body">

                    </tbody>
                </table>
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid -->


    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

@endsection
@section('title','進度管理')
