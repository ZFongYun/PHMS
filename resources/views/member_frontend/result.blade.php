@extends('member_frontend.layout.master')
@section('content')
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <p class="page-title">{{$project_name['name']}} | 成果展示</p>
            </div>
            <div class="col-sm-8 m-b-10">
                <h2>{{$resultToIndex[0]['name']}}</h2>
            </div>
            <div class="col-sm-4 m-b-10" align="right">
                <a href="{{route('Overall.member_result_edit',[$resultToIndex[0]['project_id'],$resultToIndex[0]['id']])}}" class="btn btn-warning waves-effect waves-light m-b-15">編輯專案</a>
            </div>
            <div class="col-sm-7">
                <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ URL::asset('assets/images/thumbnail/4.jpg') }}" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ URL::asset('assets/images/thumbnail/2.jpg') }}" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ URL::asset('assets/images/thumbnail/3.jpg') }}" class="d-block w-100" alt="...">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

            <div class="col-sm-5">
                <h4>遊戲介紹/背景</h4>
                <p class="m-l-10">{{$resultToIndex[0]['introduction']}}</p>

                <h5>遊戲類型</h5>
                <p class="m-l-10">{{$resultToIndex[0]['type']}}</p>

            </div>

            <div class="col-sm-7 m-t-10">
                <iframe src="{{$video_url}}" height="338" width="650"></iframe>
            </div>

            <div class="col-sm-5 m-t-10">
                <h5>遊玩方法</h5>
                <p class="m-l-10">{{$resultToIndex[0]['function']}}</p>
            </div>

            <div class="col-sm-6 m-t-10">
                <div class="card card-custom card-border">
                    <div class="card-heading">
                        <h2 class="card-title text-custom m-0">遊戲下載</h2>
                    </div>
                    <div class="card-body">
                        <a href="{{$exe_url}}" class="btn waves-effect waves-light btn-primary">download</a>
                        <label class="m-l-10">{{$exe_name}}</label>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 m-t-10">
                <div class="card card-custom card-border">
                    <div class="card-heading">
                        <h2 class="card-title text-custom m-0">相關資訊</h2>
                    </div>
                    <div class="card-body">
                        <dl class="row m-b-10">
                            <dt class="col-sm-3">製作團隊</dt>
                            <dd class="col-sm-7">{{$resultToIndex[0]['team']}}</dd>
                            <dt class="col-sm-3">參與成員</dt>
                            @if($project_member == null)
                                <dd class="col-sm-7">-無參與成員-</dd>
                            @else
                                <dd class="col-sm-7">
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
                            <dt class="col-sm-3">指導老師</dt>
                            <dd class="col-sm-7">{{$resultToIndex[0]['teacher']}} 老師</dd>
                            <dt class="col-sm-3">遊戲類型</dt>
                            <dd class="col-sm-7">{{$resultToIndex[0]['type']}}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid -->
@endsection
@section('title','成果展示')
