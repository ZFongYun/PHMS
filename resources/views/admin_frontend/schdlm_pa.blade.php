@extends('admin_frontend.layout.master')
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
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid -->
@endsection
@section('title','進度考核')
