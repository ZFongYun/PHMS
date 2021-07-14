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
                <table class="table table-hover m-0" id="all_data_table">
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
                    @foreach($project as $row)
                        <tr>
                            <th scope="row">{{$row['id']}}</th>
                            @if($row['semester'] == 0)
                                <td>{{$row['school_year']}}-01</td>
                            @else
                                <td>{{$row['school_year']}}-02</td>
                            @endif
                            <td>{{$row['name']}}</td>
                            @if($row['status'] == 0)
                                <td>執行中</td>
                            @elseif($row['status'] == 1)
                                <td>測試</td>
                            @elseif($row['status'] == 2)
                                <td>完成</td>
                            @elseif($row['status'] == 3)
                                <td>關閉</td>
                            @endif
                            <td>{{$row['start_date']}}</td>
                            @if($row['end_date']==null)
                                <td>-無日期-</td>
                            @else
                                <td>{{$row['end_date']}}</td>
                            @endif
                            <td width="8%"><a href="{{route('Overall.admin_schdlm',$row['id'])}}" class="btn btn-icon waves-effect btn-rounded btn-sm waves-light btn-custom"><i class="ti-ruler-pencil"></i></a></td>
                            <td width="8%"><a href="{{route('Overall.admin_result',$row['id'])}}" class="btn btn-icon waves-effect btn-rounded btn-sm waves-light btn-purple"><i class="ti-light-bulb"></i></a></td>
                            <td><a href="{{action('AdminPmController@show',$row['id'])}}" class="btn btn-icon waves-effect btn-rounded btn-sm waves-light btn-info"><i class="zmdi zmdi-info-outline"></i></a></td>
                            <td><a href="{{action('AdminPmController@edit',$row['id'])}}" class="btn btn-icon waves-effect btn-rounded btn-sm waves-light btn-warning"><i class="zmdi zmdi-edit"></i></a></td>
                            <form action="{{action('AdminPmController@destroy',$row['id'])}}" method="post">
                                <td><button type="submit" class="btn btn-icon btn-rounded btn-sm waves-effect waves-light btn-danger" onclick="return(confirm('是否刪除此筆資料？'))"> <i class="fa fa-remove"></i></button></td>
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            </form>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            {{--   search_data_table   --}}
            <div class="table-responsive">
                <table class="table table-hover m-0" style="display: none" id="search_data_table">
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
