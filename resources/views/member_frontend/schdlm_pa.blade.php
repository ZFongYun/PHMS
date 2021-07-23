@extends('member_frontend.layout.master')
@section('content')
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">{{$schdl_name}} 進度考核</h4>
            </div>
            <div class="col-sm-5">
                <h5>評分表</h5>
                <p class="m-b-0">◎ 專案整體考核</p>
                {{--   project_pa_table   --}}
                <div class="table-responsive m-l-15">
                    <table class="table table-hover" id="project_pa_table">
                        <thead>
                        <tr>
                            <th>分數</th>
                            <th>說明</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            @if($project_pa == null)
                                <td>-</td>
                                <td>-</td>
                            @else
                                <td>{{$project_pa[0]['score']}}</td>
                                <td>{{$project_pa[0]['explanation']}}</td>
                            @endif
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-sm-10 m-t-10">
                <p class="m-b-0">◎ 成員考核</p>
                {{--   member_pa_table   --}}
                <div class="table-responsive  m-l-15">
                    <table class="table table-hover" id="member_pa_table">
                        <thead>
                        <tr>
                            <th>學號</th>
                            <th>姓名</th>
                            <th>職稱</th>
                            <th>分數</th>
                            <th>說明</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($project_pa == null)
                            @foreach($project_member as $row)
                                <tr>
                                    <td>{{$row->student_ID}}</td>
                                    <td>{{$row->name}}</td>
                                    @if($row->title==0)
                                        <td>專任教授</td>
                                    @elseif($row->title==1)
                                        <td>知點助理</td>
                                    @elseif($row->title==2)
                                        <td>企劃</td>
                                    @elseif($row->title==3)
                                        <td>程式</td>
                                    @elseif($row->title==4)
                                        <td>美術</td>
                                    @elseif($row->title==5)
                                        <td>技美</td>
                                    @elseif($row->title==6)
                                        <td>無職務</td>
                                    @endif
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                            @endforeach
                        @else
                            @foreach($member_pa as $row)
                                <tr>
                                    <td>{{$row->student_ID}}</td>
                                    <td>{{$row->name}}</td>
                                    @if($row->title==0)
                                        <td>專任教授</td>
                                    @elseif($row->title==1)
                                        <td>知點助理</td>
                                    @elseif($row->title==2)
                                        <td>企劃</td>
                                    @elseif($row->title==3)
                                        <td>程式</td>
                                    @elseif($row->title==4)
                                        <td>美術</td>
                                    @elseif($row->title==5)
                                        <td>技美</td>
                                    @elseif($row->title==6)
                                        <td>無職務</td>
                                    @endif
                                    <td>{{$row->score}}</td>
                                    <td>{{$row->explanation}}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-sm-10 m-t-10">
                @if($project_pa == null)
                    <button class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#score_modal">評分</button>
                @else
                    <button class="btn btn-warning waves-effect waves-light" data-toggle="modal" data-target="#edit_modal">編輯</button>
                @endif
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid -->

    <!-- score_modal -->
    <div id="score_modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title mt-0">進度考核</h4>
                </div>
                <div class="modal-body">
                    <p>◎ 專案整體考核</p>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="project_score" class="control-label">評分分數</label>
                                <select class="form-control" id="project_score" name="project_score">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="project_explanation" class="control-label">評分說明</label>
                                <textarea id="project_explanation" name="project_explanation" class="form-control" maxlength="225" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <p>◎ 成員考核</p>
                    <div class="table-responsive">
                        <table class="table table-hover" id="member_pa_table">
                            <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th>姓名</th>
                                <th>職稱</th>
                                <th>分數</th>
                                <th>說明</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($project_member as $row)
                                <tr>
                                    <td>{{$row->id}}</td>
                                    <td>{{$row->name}}</td>
                                    @if($row->title==0)
                                        <td>專任教授</td>
                                    @elseif($row->title==1)
                                        <td>知點助理</td>
                                    @elseif($row->title==2)
                                        <td>企劃</td>
                                    @elseif($row->title==3)
                                        <td>程式</td>
                                    @elseif($row->title==4)
                                        <td>美術</td>
                                    @elseif($row->title==5)
                                        <td>技美</td>
                                    @elseif($row->title==6)
                                        <td>無職務</td>
                                    @endif
                                    <td>
                                        <select class="form-control col-sm-2" id="{{$row->id}}" name="member_score">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </td>
                                    <td>
                                        <textarea id="member_explanation" name="member_explanation" class="form-control" maxlength="225" rows="2"></textarea>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary waves-effect waves-light" id="send">送出</button>
                    </div>
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

        $('#send').click(function () {
            var project_id = {{$id}}; //專案id
            var schdl_id = {{$schdlId}}; //進度id
            var member_id_values= []; //成員id
            var project_score = $("#project_score").val(); //專案考核分數
            var project_explanation = $("#project_explanation").val(); //專案考核說明
            var member_score = document.getElementsByName("member_score");
            var member_explanation = document.getElementsByName("member_explanation");
            var member_score_values= []; //成員考核分數
            var member_explanation_values= []; //成員考核說明
            for(var i=0; i<member_score.length; i++) {
                member_id_values.push(member_score[i].id)
                member_score_values.push(member_score[i].value);
                member_explanation_values.push(member_explanation[i].value);
            }
            $(document).ready(function() {
                $.ajax({
                    type:'POST',
                    url:'/PHMS_member/score/store',
                    data:{project_id: project_id,
                        schdl_id:schdl_id,
                        member_id_values:member_id_values,
                        project_score: project_score,
                        project_explanation: project_explanation,
                        member_score_values: member_score_values,
                        member_explanation_values: member_explanation_values,
                        _token: '{{csrf_token()}}'},
                    success: function() {
                        alert('完成評分')
                        location.reload();
                    },
                    error: function (){
                        alert('評分失敗')
                    }
                });
            });
        });
    </script>
@endsection
@section('title','進度考核')
