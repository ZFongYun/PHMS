@extends('admin_frontend.layout.master')
@section('content')
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">專案管理</h4>
            </div>
            <div class="col-sm-4 m-b-15">
                <a href="{{action('AdminPmController@create')}}" class="btn btn-primary waves-effect waves-light">新增專案</a>
            </div>
            <div class="col-sm-8 m-b-15" align="right">
                <div class="input-group col-sm-9">
                    <button type="button" class="btn waves-effect waves-light btn-primary btn-sm m-r-5" onclick="displayAllDate()">顯示全部資料</button>
                    <select class="form-control-select col-sm-3 m-r-5" id="target" name="target">
                        <option>請選擇</option>
                        <option value="0">學年度</option>
                        <option value="1">專案名稱</option>
                        <option value="2">狀態</option>
                    </select>
                    <input type="text" class="form-control" placeholder="表格搜尋" id="keyword" name="keyword">
                    <select class="form-control-select col-sm-5" style="display: none" id="keyword_status" name="keyword_title">
                        <option value="0">執行中</option>
                        <option value="1">測試</option>
                        <option value="2">完成</option>
                        <option value="3">關閉</option>
                    </select>
                    <span class="input-group-prepend">
                        <button type="button" class="search btn waves-effect waves-light btn-primary"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </div>

            {{--   all_data_table   --}}
            <div class="table-responsive">
                <table class="table table-hover m-0" id="all_date">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>學年期</th>
                        <th>專案名稱</th>
                        <th>狀態</th>
                        <th>開始日期</th>
                        <th>結束日期</th>
                        <th>進度管理</th>
                        <th>成果展示</th>
                        <th>詳情</th>
                        <th>編輯</th>
                        <th>刪除</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>

            {{--   search_data_table   --}}
            <div class="table-responsive">
                <table class="table table-hover m-0" style="display: none" id="search_date">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>學年期</th>
                        <th>專案名稱</th>
                        <th>狀態</th>
                        <th>開始日期</th>
                        <th>結束日期</th>
                        <th>進度管理</th>
                        <th>詳情</th>
                        <th>編輯</th>
                        <th>刪除</th>
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
@section('title','專案管理')
