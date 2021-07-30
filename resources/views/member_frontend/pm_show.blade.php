@extends('member_frontend.layout.master')
@section('content')
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">專案詳情</h4>
                <dl class="row m-b-10" style="padding-left: 30px;">
                    <dt class="col-sm-2">專案名稱</dt>
                    <dd class="col-sm-9">{{$projectToShow['name']}}</dd>
                    <dt class="col-sm-2">簡述</dt>
                    @if($projectToShow['content'] == '')
                        <dd class="col-sm-9">-無說明-</dd>
                    @else
                        <dd class="col-sm-9">{{$projectToShow['content']}}</dd>
                    @endif
                    <dt class="col-sm-2">專案學年期</dt>
                    @if($projectToShow['semester'] == 0)
                        <dd class="col-sm-9">{{$projectToShow['school_year']}}-01</dd>
                    @else
                        <dd class="col-sm-9">{{$projectToShow['school_year']}}-02</dd>
                    @endif
                    <dt class="col-sm-2">開始日期</dt>
                    <dd class="col-sm-9">{{$projectToShow['start_date']}}</dd>
                    <dt class="col-sm-2">結束日期</dt>
                    @if($projectToShow['end_date'] == '')
                        <dd class="col-sm-9">-無日期-</dd>
                    @else
                        <dd class="col-sm-9">{{$projectToShow['end_date']}}</dd>
                    @endif
                    <dt class="col-sm-2">狀態</dt>
                    @if($projectToShow['status'] == 0)
                        <dd class="col-sm-9">執行中</dd>
                    @elseif($projectToShow['status'] == 1)
                        <dd class="col-sm-9">測試</dd>
                    @elseif($projectToShow['status'] == 2)
                        <dd class="col-sm-9">完成</dd>
                    @elseif($projectToShow['status'] == 3)
                        <dd class="col-sm-9">關閉</dd>
                    @endif
                    <dt class="col-sm-2">參與成員</dt>
                    @if($project_member == null)
                        <dd class="col-sm-9">-無參與成員-</dd>
                    @else
                        <dd class="col-sm-9">
                            @foreach($project_member as $row)
                                @if($row->title==0)
                                    專任教授 | <a href="{{action('MemberHrController@show',$row->id)}}">{{$row->name}}</a><br>
                                @elseif($row->title==1)
                                    知點助理 | <a href="{{action('MemberHrController@show',$row->id)}}">{{$row->name}}</a><br>
                                @elseif($row->title==2)
                                    企劃 | <a href="{{action('MemberHrController@show',$row->id)}}">{{$row->name}}</a><br>
                                @elseif($row->title==3)
                                    程式 | <a href="{{action('MemberHrController@show',$row->id)}}">{{$row->name}}</a><br>
                                @elseif($row->title==4)
                                    美術 | <a href="{{action('MemberHrController@show',$row->id)}}">{{$row->name}}</a><br>
                                @elseif($row->title==5)
                                    技美 | <a href="{{action('MemberHrController@show',$row->id)}}">{{$row->name}}</a><br>
                                @elseif($row->title==6)
                                    無職務 | <a href="{{action('MemberHrController@show',$row->id)}}">{{$row->name}}</a><br>
                                @endif
                            @endforeach
                        </dd>
                    @endif
                </dl>
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid -->

@endsection
@section('title','專案詳情')
