@extends('member_frontend.layout.master')
@section('content')
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">{{$project_name}} 進度管理</h4>
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
                        <th width="20%">進度起止日</th>
                        <th>進度下載</th>
                        <th>考核</th>
                        <th>考核狀態</th>
                        <th>編輯</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($schdlToIndex as $row)
                        <tr>
                            <th scope="row">{{$row['id']}}</th>
                            <td>{{$row['name']}}</td>
                            <td>{{$row['schdl_start_date']}} ~ {{$row['schdl_end_date']}}</td>
                            <td><a href="{{route('Overall.member_schdlm_download',[$id, $row['id']])}}" class="btn btn-icon waves-effect btn-rounded btn-sm waves-light btn-primary"><i class="zmdi zmdi-download"></i></a></td>
                            <td><a href="{{route('Overall.member_schdlm_pa',[$id, $row['id']])}}" class="btn btn-icon waves-effect btn-rounded btn-sm waves-light btn-primary"><i class="zmdi zmdi-account-circle"></i></a></td>
                            @if(strtotime(date("Y-m-d H:i:s")) > strtotime($row['pa_end_date'].' '.$row['pa_end_time']))
                                <td>已結束</td>
                            @else
                                <td>考核中</td>
                            @endif
                            <td><a href="{{route('Overall.member_schdlm_edit',[$id,$row['id']])}}" class="btn btn-icon waves-effect btn-rounded btn-sm waves-light btn-warning"><i class="zmdi zmdi-edit"></i></a></td>
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

        $("#target").change(function(){
            var target = $('#target').val();
            if (target == 1){
                $('#keyword').hide();
                $('#keyword_status').show();
            }else {
                $('#keyword').show();
                $('#keyword_status').hide();
            }
        });

        function displayAllData(){
            $('#all_data_table').show();
            $('#search_data_table').hide();
        }

        $(document).on('click', '.search', function() {
            var target = $('#target').val();
            var keyword = $('#keyword').val();
            var keyword_status = $('#keyword_status').val();
            var project_id = {{$id}};
            var html_result = '';

            if (target == "請選擇"){
                alert("請選擇搜尋目標");
            }else {
                $(document).ready(function() {
                    $.ajax({
                        type: 'POST',
                        url: '/PHMS_member/search/schdl_search',
                        data: {
                            target: target,
                            keyword: keyword,
                            keyword_status: keyword_status,
                            project_id: project_id,
                            _token: '{{csrf_token()}}'
                        },
                        success: function (data) {
                            console.log(data);
                        },
                        error: function () {
                            alert('error')
                        }
                    });
                });
            }
        });
    </script>

@endsection
@section('title','進度管理')
