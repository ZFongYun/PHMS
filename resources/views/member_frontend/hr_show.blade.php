@extends('member_frontend.layout.master')
@section('content')
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">成員詳情</h4>
                <p class="little-title">基本資料</p>
                <dl class="row m-b-10" style="padding-left: 30px;">
                    <dt class="col-sm-2">姓名</dt>
                    <dd class="col-sm-9">{{$memberToShow['name']}}</dd>
                    <dt class="col-sm-2">學號</dt>
                    <dd class="col-sm-9">{{$memberToShow['student_ID']}}</dd>
                    <dt class="col-sm-2">電子信箱</dt>
                    <dd class="col-sm-9">{{$memberToShow['email']}}</dd>
                    <dt class="col-sm-2">加入學年度</dt>
                    <dd class="col-sm-9">{{$memberToShow['join_year']}}</dd>
                    <dt class="col-sm-2">職稱</dt>
                    @if($memberToShow['title']==0)
                        <dd class="col-sm-9">專任教授</dd>
                    @elseif($memberToShow['title']==1)
                        <dd class="col-sm-9">知點助理</dd>
                    @elseif($memberToShow['title']==2)
                        <dd class="col-sm-9">企劃</dd>
                    @elseif($memberToShow['title']==3)
                        <dd class="col-sm-9">程式</dd>
                    @elseif($memberToShow['title']==4)
                        <dd class="col-sm-9">美術</dd>
                    @elseif($memberToShow['title']==5)
                        <dd class="col-sm-9">技美</dd>
                    @elseif($memberToShow['title']==6)
                        <dd class="col-sm-9">無</dd>
                    @endif
                    <dt class="col-sm-2">知點職務</dt>
                    <dd class="col-sm-9">{{$position_string}}</dd>
                </dl>
                <p class="little-title">專長介紹</p>
                <div class="col-sm-8 m-b-10" style="padding-left: 30px;">
                    <p>{{$memberToShow['skill']}}</p>
                </div>
                <p class="little-title">歷年製作的專案項目</p>
                <div class="col-sm-8 m-b-10" style="padding-left: 30px">
                    @foreach($member_project as $row)
                        <a href="{{route('Overall.member_result',$row->id)}}" style="line-height: 30px">{{$row->name}}</a>
                        <br>
                    @endforeach
                </div>
                <p class="little-title">備註</p>
                <div class="col-sm-8 m-b-10" style="padding-left: 30px;">
                    <p>{{$memberToShow['remark']}}</p>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid -->
@endsection
@section('title','成員詳情')
