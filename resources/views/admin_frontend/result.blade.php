@extends('admin_frontend.layout.master')
@section('content')
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <p class="page-title">{{$project_name}} | 成果展示</p>
            </div>
            <div class="col-sm-12 m-b-10">
                <h2>{{$resultToIndex[0]['name']}}</h2>
            </div>
            <div class="col-sm-6">
                <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        @for($i=1; $i<count($img); $i++)
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{$i}}" aria-label="Slide {{$i+1}}"></button>
                        @endfor
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{$img[0]}}" class="d-block w-100">
                        </div>
                        @for($i=1; $i<count($img); $i++)
                            <div class="carousel-item">
                                <img src="{{$img[$i]}}" class="d-block w-100">
                            </div>
                        @endfor
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
            <div class="col-sm-6">
                <h4>遊戲介紹/背景</h4>
                <p class="m-l-10">{{$resultToIndex[0]['introduction']}}</p>
                <h4>遊戲類型</h4>
                <p class="m-l-10">{{$resultToIndex[0]['type']}}</p>
            </div>

            <div class="col-sm-6 m-t-10">
                @if($video_url != '')
{{--                    <iframe src="{{$video_url}}" class="d-block w-100" height="324"></iframe>--}}
                    <video src="{{$video_url}}" controls class="d-block w-100" height="324"></video>
                @else
                    <label>未上傳影片</label>
                @endif
            </div>
            <div class="col-sm-6 m-t-10">
                <h4>遊玩方法</h4>
                <p class="m-l-10">{{$resultToIndex[0]['function']}}</p>
            </div>

            <div class="col-sm-6 m-t-10">
                <div class="card card-primary card-border">
                    <div class="card-heading">
                        <h3 class="card-title text-primary m-0">遊戲下載</h3>
                    </div>
                    <div class="card-body">
                        <a href="{{$exe_url}}" class="btn waves-effect waves-light btn-primary">download</a>
                        <label class="m-l-10">{{$exe_name}}</label>
                    </div>
                </div>
                <div class="card card-primary card-border">
                    <div class="card-heading">
                        <h3 class="card-title text-primary m-0">素材下載</h3>
                    </div>
                    <div class="card-body">
                        @if($material_url != '')
                            <a href="{{$material_url}}" class="btn waves-effect waves-light btn-primary">download</a>
                            <label class="m-l-10">{{$exe_name}}</label>
                        @else
                            <label>未上傳素材</label>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-sm-6 m-t-10">
                <div class="card card-primary card-border">
                    <div class="card-heading">
                        <h3 class="card-title text-primary m-0">相關資訊</h3>
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
                                            專任教授 | <a href="{{action('AdminHrController@show',$row->id)}}">{{$row->name}}</a><br>
                                        @elseif($row->title==1)
                                            知點助理 | <a href="{{action('AdminHrController@show',$row->id)}}">{{$row->name}}</a><br>
                                        @elseif($row->title==2)
                                            企劃 | <a href="{{action('AdminHrController@show',$row->id)}}">{{$row->name}}</a><br>
                                        @elseif($row->title==3)
                                            程式 | <a href="{{action('AdminHrController@show',$row->id)}}">{{$row->name}}</a><br>
                                        @elseif($row->title==4)
                                            美術 | <a href="{{action('AdminHrController@show',$row->id)}}">{{$row->name}}</a><br>
                                        @elseif($row->title==5)
                                            技美 | <a href="{{action('AdminHrController@show',$row->id)}}">{{$row->name}}</a><br>
                                        @elseif($row->title==6)
                                            無職務 | <a href="{{action('AdminHrController@show',$row->id)}}">{{$row->name}}</a><br>
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
