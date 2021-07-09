@extends('admin_frontend.layout.master')
@section('content')
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">人資管理</h4>
            </div>
            <div class="col-sm-4 m-b-15">
                <button class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#choose">新增成員</button>
            </div>
            <div class="col-sm-8 m-b-15" align="right">
                <div class="input-group col-sm-9">
                    <button type="button" class="btn waves-effect waves-light btn-primary btn-sm m-r-5">顯示全部資料</button>
                    <select class="form-control-select col-sm-3 m-r-5" id="target" name="target">
                        <option>請選擇</option>
                        <option value="0">加入學年度</option>
                        <option value="1">姓名</option>
                        <option value="2">職稱</option>
                        <option value="3">知點職務</option>
                    </select>
                    <input type="text" class="form-control" placeholder="表格搜尋" id="keyword" name="keyword">
                    <select class="form-control-select col-sm-5" style="display: none" id="keyword_title" name="keyword_title">
                        <option value="0">專任教授</option>
                        <option value="1">知點助理</option>
                        <option value="2">企劃</option>
                        <option value="3">程式</option>
                        <option value="4">美術</option>
                        <option value="5">技美</option>
                    </select>
                    <select class="form-control-select col-sm-5" style="display: none" id="keyword_position" name="keyword_position">
                        <option value="0">PM</option>
                        <option value="1">HR</option>
                        <option value="2">核銷</option>
                        <option value="3">行政</option>
                        <option value="4">企劃講師</option>
                        <option value="5">程式講師</option>
                        <option value="6">美術講師</option>
                        <option value="7">企劃助教</option>
                        <option value="8">程式助教</option>
                        <option value="9">美術助教</option>
                        <option value="10">無職務</option>
                    </select>
                    <span class="input-group-prepend">
                        <button type="button" class="search btn waves-effect waves-light btn-primary"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover m-0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>加入學年度</th>
                        <th>學號</th>
                        <th>姓名</th>
                        <th>電子信箱</th>
                        <th>職稱</th>
                        <th>知點職務</th>
                        <th>詳情</th>
                        <th>密碼重設</th>
                        <th>編輯</th>
                        <th>刪除</th>
                    </tr>
                    </thead>
                    <tbody>

                        @if(count($member)==0)
                            <tr><td>無資料</td></tr>
                        @else
                            @for($i=0; $i<count($member); $i++ )
                                <tr>
                                    <th scope="row">{{$member[$i]['id']}}</th>
                                    <td>{{$member[$i]['join_year']}}</td>
                                    <td>{{$member[$i]['student_ID']}}</td>
                                    <td>{{$member[$i]['name']}}</td>
                                    <td>{{$member[$i]['email']}}</td>
                                    @if($member[$i]['title']==0)
                                        <td>專任教授</td>
                                    @elseif($member[$i]['title']==1)
                                        <td>知點助理</td>
                                    @elseif($member[$i]['title']==2)
                                        <td>企劃</td>
                                    @elseif($member[$i]['title']==3)
                                        <td>程式</td>
                                    @elseif($member[$i]['title']==4)
                                        <td>美術</td>
                                    @elseif($member[$i]['title']==5)
                                        <td>技美</td>
                                    @elseif($member[$i]['title']==6)
                                        <td>無</td>
                                    @endif
                                    <td>{{$position[$i]}}</td>
                                    <td><a href="{{action('AdminHrController@show',$member[$i]['id'])}}" class="btn btn-icon waves-effect btn-rounded btn-sm waves-light btn-info"><i class="zmdi zmdi-info-outline"></i></a></td>
                                    <td><a href="{{route('Overall.hr_reset_edit',$member[$i]['id'])}}" class="btn btn-icon waves-effect btn-rounded btn-sm waves-light btn-purple"><i class="zmdi zmdi-key"></i></a></td>
                                    <td><a href="{{action('AdminHrController@edit',$member[$i]['id'])}}" class="btn btn-icon waves-effect btn-rounded btn-sm waves-light btn-warning"><i class="zmdi zmdi-edit"></i></a></td>
                                    <form action="{{action('AdminHrController@destroy',$member[$i]['id'])}}" method="post">
                                        <td><button type="submit" class="btn btn-icon btn-rounded btn-sm waves-effect waves-light btn-danger" onclick="return(confirm('是否刪除此筆資料？'))"> <i class="fa fa-remove"></i></button></td>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    </form>
                                </tr>
                            @endfor
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid -->

    <!-- choose modal content -->
    <div id="choose" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title mt-0" id="myModalLabel">請選擇加入方式</h4>
                </div>
                <div class="modal-body center">
                    <a href="{{action('AdminHrController@create')}}" class="btn btn-primary btn-lg waves-effect waves-light">單一成員加入</a>
                    <a href="{{route('Overall.multiple_create')}}" class="btn btn-primary btn-lg waves-effect waves-light m-l-10">多位成員加入</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#target").change(function(){
            var target = $('#target').val();
            if (target == 2){
                $('#keyword').hide();
                $('#keyword_title').show();
                $('#keyword_position').hide();
            }else if(target == 3){
                $('#keyword').hide();
                $('#keyword_title').hide();
                $('#keyword_position').show();
            }else {
                $('#keyword').show();
                $('#keyword_title').hide();
                $('#keyword_position').hide();
            }
        });

        $(document).on('click', '.search', function() {
            var target = $('#target').val();
            var keyword = $('#keyword').val();
            var keyword_title = $('#keyword_title').val();
            var keyword_position = $('#keyword_position').val();

            if (target == "請選擇"){
                alert("請選擇搜尋目標")
            }else {
                $(document).ready(function() {
                    $.ajax({
                        type: 'POST',
                        url: 'HR/search',
                        data: {
                            target: target,
                            keyword: keyword,
                            keyword_title: keyword_title,
                            keyword_position: keyword_position,
                            _token: '{{csrf_token()}}'
                        },
                        success: function (data) {
                            console.log(data)
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
@section('title','人資管理')
