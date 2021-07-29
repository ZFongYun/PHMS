@extends('admin_frontend.layout.master')
@section('content')
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">{{$project_name}} 進度管理</h4>
            </div>
            <div class="col-sm-12 m-b-15" align="right">
                <div class="input-group col-sm-5">
                    <button type="button" class="btn waves-effect waves-light btn-primary btn-sm m-r-5" onclick="displayAllData()">顯示全部資料</button>
                    <input type="text" class="form-control" placeholder="表格搜尋" id="keyword" name="keyword">
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
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($schdlToIndex as $row)
                        <tr>
                            <th scope="row">{{$row['id']}}</th>
                            <td>{{$row['name']}}</td>
                            <td>{{$row['schdl_start_date']}} ~ {{$row['schdl_end_date']}}</td>
                            <td><a href="{{route('Overall.admin_schdlm_download',[$id, $row['id']])}}" class="btn btn-icon waves-effect btn-rounded btn-sm waves-light btn-primary"><i class="zmdi zmdi-download"></i></a></td>
                            <td><a href="{{route('Overall.admin_schdlm_pa',[$id, $row['id']])}}" class="btn btn-icon waves-effect btn-rounded btn-sm waves-light btn-primary"><i class="zmdi zmdi-account-circle"></i></a></td>
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

        function displayAllData(){
            $('#all_data_table').show();
            $('#search_data_table').hide();
        }

        $(document).on('click', '.search', function() {
            var keyword = $('#keyword').val();
            var project_id = {{$id}};
            var html_result = '';

            $(document).ready(function() {
                $.ajax({
                    type: 'POST',
                    url: '/PHMS_admin/search/schdl_search',
                    data: {
                        keyword: keyword,
                        project_id: project_id,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (data) {
                        $('#all_data_table').hide();
                        $('#search_data_table').show();
                        if (data == ''){
                            html_result += '<tr>';
                            html_result += '<td colspan="5">無結果</td></tr>';
                            $('#search_body').html(html_result);
                        }else {
                            for (var i = 0; i<data.length; i++){
                                html_result += '<tr>';
                                html_result += '<th scope="row">'+data[i].id+'</th>';
                                html_result += '<td>'+data[i].name+'</td>';
                                html_result += '<td>'+data[i].schdl_start_date+' ~ '+data[i].schdl_end_date+'</td>';
                                html_result += '<td><a href="schdlm/' + data[i].id + '/download" class="btn btn-icon waves-effect btn-rounded btn-sm waves-light btn-primary"><i class="zmdi zmdi-download"></i></a></td>';
                                html_result += '<td><a href="schdlm/' + data[i].id + '/PA" class="btn btn-icon waves-effect btn-rounded btn-sm waves-light btn-primary"><i class="zmdi zmdi-account-circle"></i></a></td>';
                                $('#search_body').html(html_result);
                            }
                        }
                    },
                    error: function () {
                        alert('搜尋錯誤')
                    }
                });
            });
        });
    </script>
@endsection
@section('title','進度管理')
