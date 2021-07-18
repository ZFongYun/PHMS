@extends('member_frontend.layout.master')
@section('content')

    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">用戶資料</h4>
            </div>
            <div class="col-sm-12 m-b-20">
                <a href="{{action('MemberInfoController@edit',$memberToIndex['id'])}}" class="btn btn-warning waves-effect waves-light">編輯</a>
                <a href="#" class="btn btn-info waves-effect waves-light m-l-10">修改密碼</a>
            </div>

            <div class="col-lg-6">
                <div class="card card-color">
                    <div class="card-heading bg-gray">
                        <h3 class="card-title m-0">基本資料</h3>
                    </div>
                    <div class="card-body">
                        <dl class="row m-b-10" style="padding-left: 30px;">
                            <dt class="col-sm-3">姓名</dt>
                            <dd class="col-sm-9">{{$memberToIndex['name']}}</dd>
                            <dt class="col-sm-3">學號</dt>
                            <dd class="col-sm-9">{{$memberToIndex['student_ID']}}</dd>
                            <dt class="col-sm-3">電子信箱</dt>
                            <dd class="col-sm-9">{{$memberToIndex['email']}}</dd>
                            <dt class="col-sm-3">加入學年度</dt>
                            <dd class="col-sm-9">{{$memberToIndex['join_year']}}</dd>
                            <dt class="col-sm-3">職稱</dt>
                            @if($memberToIndex['title']==0)
                                <dd class="col-sm-9">專任教授</dd>
                            @elseif($memberToIndex['title']==1)
                                <dd class="col-sm-9">知點助理</dd>
                            @elseif($memberToIndex['title']==2)
                                <dd class="col-sm-9">企劃</dd>
                            @elseif($memberToIndex['title']==3)
                                <dd class="col-sm-9">程式</dd>
                            @elseif($memberToIndex['title']==4)
                                <dd class="col-sm-9">美術</dd>
                            @elseif($memberToIndex['title']==5)
                                <dd class="col-sm-9">技美</dd>
                            @elseif($memberToIndex['title']==6)
                                <dd class="col-sm-9">無</dd>
                            @endif
                            <dt class="col-sm-3">知點職務</dt>
                            <dd class="col-sm-9">{{$position_string}}</dd>
                        </dl>
                    </div>
                </div>
            </div><!-- end col -->
            <div class="col-lg-6">
                <div class="card card-color">
                    <div class="card-heading bg-gray">
                        <h3 class="card-title m-0">專長介紹</h3>
                    </div>
                    <div class="card-body">
                        {{$memberToIndex['skill']}}
                    </div>
                </div>
            </div><!-- end col -->
            <div class="col-lg-6">
                <div class="card card-color">
                    <div class="card-heading bg-gray">
                        <h3 class="card-title m-0">歷年製作的專案項目</h3>
                    </div>
                    <div class="card-body">
                        @foreach($member_project as $row)
                            <a href="{{action('MemberPmController@show',$row->id)}}" style="line-height: 30px">{{$row->name}}</a>
                            <br>
                        @endforeach
                    </div>
                </div>
            </div><!-- end col -->
            <div class="col-lg-6">
                <div class="card card-color">
                    <div class="card-heading bg-gray">
                        <h3 class="card-title m-0">備註</h3>
                    </div>
                    <div class="card-body">
                        {{$memberToIndex['remark']}}
                    </div>
                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid -->
@endsection
@section('title','用戶資料')
