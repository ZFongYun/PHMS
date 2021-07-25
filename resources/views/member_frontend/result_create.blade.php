@extends('member_frontend.layout.master')
@section('content')
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">新增成果</h4>
                <form action="{{route('Overall.member_result_store',$id)}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="col-md-8">
                        <h5 class="text-danger m-b-0">☆ 新增成果前，請先<a href="">點我</a>下載上傳規範 ☆</h5>
                        <h5 class="star">注意！「*」為必填欄位</h5>
                        <div class="form-group row">
                            <label for="name" class="col-md-2 control-label form-title"><span class="text-danger">*</span>遊戲名稱</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="name" name="name" required="">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="introduction" class="col-md-2 control-label form-title"><span class="text-danger">*</span>遊戲介紹/背景</label>
                            <div class="col-md-8">
                                <textarea id="introduction" name="introduction" class="form-control" maxlength="225" rows="2"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="introduction" class="col-md-2 control-label form-title"><span class="text-danger">*</span>遊戲類型</label>
                            <div class="checkbox controls">
                                <input id="typeButton1" type="checkbox" name="type[]" value="休閒" class="input-mini" />
                                <label for="typeButton1" class="m-r-10">休閒</label>
                                <input id="typeButton2" type="checkbox" name="type[]" value="動作" class="input-mini" />
                                <label for="typeButton2" class="m-r-10">動作</label>
                                <input id="typeButton3" type="checkbox" name="type[]" value="冒險" class="input-mini" />
                                <label for="typeButton3" class="m-r-10">冒險</label>
                            </div>
                            <div class="checkbox controls">
                                <input id="typeButton4" type="checkbox" name="type[]" value="模擬" class="input-mini" />
                                <label for="typeButton4" class="m-r-10">模擬</label>
                                <input id="typeButton5" type="checkbox" name="type[]" value="養成" class="input-mini" />
                                <label for="typeButton5" class="m-r-10">養成</label>
                                <input id="typeButton6" type="checkbox" name="type[]" value="教育" class="input-mini" />
                                <label for="typeButton6" class="m-r-10">教育</label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="function" class="col-md-2 control-label form-title">遊戲方法</label>
                            <div class="col-md-8">
                                <textarea id="function" name="function" class="form-control" maxlength="225" rows="2"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="teacher" class="col-md-2 control-label form-title"><span class="text-danger">*</span>指導老師</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="teacher" name="teacher" required="">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="team" class="col-md-2 control-label form-title"><span class="text-danger">*</span>製作團隊</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="team" name="team" required="">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 control-label form-title">成員</label>
                            <div class="col-md-8">
                                @foreach($project_member as $row)
                                    @if($row->title==0)
                                        專任教授 | {{$row->name}}<br>
                                    @elseif($row->title==1)
                                        知點助理 | {{$row->name}}<br>
                                    @elseif($row->title==2)
                                        企劃 | {{$row->name}}<br>
                                    @elseif($row->title==3)
                                        程式 | {{$row->name}}<br>
                                    @elseif($row->title==4)
                                        美術 | {{$row->name}}<br>
                                    @elseif($row->title==5)
                                        技美 | {{$row->name}}<br>
                                    @elseif($row->title==6)
                                        無職務 | {{$row->name}}<br>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="video" class="col-md-2 control-label form-title">宣導影片</label>
                            <div class="col-md-8">
                                <input type="file" name="video" class="dropify" data-height="100" accept=".mp4" data-max-file-size="50M"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="img" class="col-md-2 control-label form-title"><span class="text-danger">*</span>遊戲截圖</label>
                            <div class="col-md-8">
                                <input type="file" name="img" class="dropify" data-height="100" accept=".png,.jpg,.svg" data-max-file-size="50M" multiple/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="exe" class="col-md-2 control-label form-title"><span class="text-danger">*</span>遊戲執行檔</label>
                            <div class="col-md-8">
                                <input type="file" name="exe" class="dropify" data-height="100" accept=".zip,.rar" data-max-file-size="50M"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="material" class="col-md-2 control-label form-title">製作素材</label>
                            <div class="col-md-8">
                                <input type="file" name="material" class="dropify" data-height="100" accept=".zip,.rar" data-max-file-size="50M" multiple/>
                            </div>
                        </div>

                    </div>
                    <div>
                        <button type="submit" class="btn btn-success w-md waves-effect waves-light button-font">新增</button>
                    </div><!-- end col -->
                </form>
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid -->
@endsection
@section('title','新增成果')
