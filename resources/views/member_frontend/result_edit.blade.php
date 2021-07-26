@extends('member_frontend.layout.master')
@section('content')
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">編輯成果</h4>
                <form action="{{route('Overall.member_result_update',[$resultToEdit['0']['project_id'],$resultToEdit['0']['id']])}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="col-md-8">
                        <h5 class="text-danger m-b-0">☆ 上傳文件前，請先<a href="">點我</a>下載上傳規範 ☆</h5>
                        <h5 class="star">注意！「*」為必填欄位</h5>
                        <div class="form-group row">
                            <label for="name" class="col-md-2 control-label form-title"><span class="text-danger">*</span>遊戲名稱</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="name" name="name" required="" value="{{$resultToEdit['0']['name']}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="introduction" class="col-md-2 control-label form-title"><span class="text-danger">*</span>遊戲介紹/背景</label>
                            <div class="col-md-8">
                                <textarea id="introduction" name="introduction" class="form-control" maxlength="225" rows="2" required="">{{$resultToEdit['0']['introduction']}}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="introduction" class="col-md-2 control-label form-title"><span class="text-danger">*</span>遊戲類型</label>
                            <div class="checkbox controls">
                                <input id="typeButton1" type="checkbox" name="type[]" value="休閒" class="input-mini"
                                       @foreach($type_chk_arr as $item)
                                            @if($item == "休閒")
                                                checked
                                            @endif
                                        @endforeach>
                                <label for="typeButton1" class="m-r-10">休閒</label>
                                <input id="typeButton2" type="checkbox" name="type[]" value="動作" class="input-mini"
                                       @foreach($type_chk_arr as $item)
                                            @if($item == "動作")
                                                checked
                                            @endif
                                        @endforeach>
                                <label for="typeButton2" class="m-r-10">動作</label>
                                <input id="typeButton3" type="checkbox" name="type[]" value="冒險" class="input-mini"
                                       @foreach($type_chk_arr as $item)
                                            @if($item == "冒險")
                                                checked
                                            @endif
                                        @endforeach>
                                <label for="typeButton3" class="m-r-10">冒險</label>
                            </div>
                            <div class="checkbox controls">
                                <input id="typeButton4" type="checkbox" name="type[]" value="模擬" class="input-mini"
                                       @foreach($type_chk_arr as $item)
                                            @if($item == "模擬")
                                                checked
                                            @endif
                                        @endforeach>
                                <label for="typeButton4" class="m-r-10">模擬</label>
                                <input id="typeButton5" type="checkbox" name="type[]" value="養成" class="input-mini"
                                       @foreach($type_chk_arr as $item)
                                            @if($item == "養成")
                                                checked
                                            @endif
                                        @endforeach>
                                <label for="typeButton5" class="m-r-10">養成</label>
                                <input id="typeButton6" type="checkbox" name="type[]" value="教育" class="input-mini"
                                       @foreach($type_chk_arr as $item)
                                            @if($item == "教育")
                                                checked
                                            @endif
                                        @endforeach>
                                <label for="typeButton6" class="m-r-10">教育</label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="function" class="col-md-2 control-label form-title">遊戲方法</label>
                            <div class="col-md-8">
                                <textarea id="function" name="function" class="form-control" maxlength="225" rows="2">{{$resultToEdit['0']['function']}}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="teacher" class="col-md-2 control-label form-title"><span class="text-danger">*</span>指導老師</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="teacher" name="teacher" required="" value="{{$resultToEdit['0']['teacher']}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="team" class="col-md-2 control-label form-title"><span class="text-danger">*</span>製作團隊</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="team" name="team" required="" value="{{$resultToEdit['0']['team']}}">
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

                        <div class="form-group row" id="upload_video">
                            <label for="video" class="col-md-2 control-label form-title">宣傳影片</label>
                            <div class="col-md-8">
                                <a href="{{$video_url}}">{{$video_name}}</a>
                                <button type="button" class="btn waves-effect waves-light btn-primary btn-sm m-l-10" onclick="reUploadVideo()">重新上傳</button>
                            </div>
                        </div>

                        <div class="form-group row" id="re_upload_video" style="display: none">
                            <label for="video" class="col-md-2 control-label form-title">宣傳影片</label>
                            <div class="col-md-8">
                                <input type="file" id="video" name="video" class="dropify" data-height="100" accept=".mp4" data-max-file-size="60M"/>
                                <button type="button" class="btn waves-effect waves-light btn-primary btn-sm" onclick="videoCancel()">取消</button>
                                <input type="hidden" id="isVideoRe" name="isVideoRe" value="0">
                            </div>
                        </div>

                        <div class="form-group row" id="upload_img">
                            <label for="video" class="col-md-2 control-label form-title"><span class="text-danger">*</span>遊戲截圖</label>
                            <div class="col-md-8">
                                <a href="{{$img1_url}}">{{$img1_name}}</a><br>
                                @if($img2_url != '')
                                    <a href="{{$img2_url}}">{{$img2_name}}</a>
                                @endif
                                @if($img3_url != '')
                                    <a href="{{$img3_url}}">{{$img3_name}}</a>
                                @endif
                                @if($img4_url != '')
                                    <a href="{{$img4_url}}">{{$img4_name}}</a>
                                @endif
                                @if($img5_url != '')
                                    <a href="{{$img5_url}}">{{$img5_name}}</a>
                                @endif
                                <button type="button" class="btn waves-effect waves-light btn-primary btn-sm m-l-10" onclick="reUploadImg()">重新上傳</button>
                            </div>
                        </div>

                        <div class="form-group row" id="re_upload_img" style="display: none">
                            <label for="img" class="col-md-2 control-label form-title"><span class="text-danger">*</span>遊戲截圖</label>
                            <div class="col-md-8">
                                <input type="file" id="img" name="img[]" class="dropify" data-height="100" accept=".jpg, .jpeg, .bmp, .gif, .png" multiple/>
                                <button type="button" class="btn waves-effect waves-light btn-primary btn-sm" onclick="imgCancel()">取消</button>
                                <input type="hidden" id="isImgRe" name="isImgRe" value="0">
                            </div>
                        </div>

                        <div class="form-group row" id="upload_exe">
                            <label for="exe" class="col-md-2 control-label form-title"><span class="text-danger">*</span>遊戲執行檔</label>
                            <div class="col-md-8">
                                <a href="{{$exe_url}}">{{$exe_name}}</a>
                                <button type="button" class="btn waves-effect waves-light btn-primary btn-sm m-l-10" onclick="reUploadExe()">重新上傳</button>
                            </div>
                        </div>

                        <div class="form-group row" id="re_upload_exe" style="display: none">
                            <label for="exe" class="col-md-2 control-label form-title"><span class="text-danger">*</span>遊戲執行檔</label>
                            <div class="col-md-8">
                                <input type="file" id="exe" name="exe" class="dropify" data-height="100" accept=".zip, .rar" data-max-file-size="1G"/>
                                <button type="button" class="btn waves-effect waves-light btn-primary btn-sm" onclick="exeCancel()">取消</button>
                                <input type="hidden" id="isExeRe" name="isExeRe" value="0">
                            </div>
                        </div>

                        <div class="form-group row" id="upload_material">
                            <label for="material" class="col-md-2 control-label form-title">製作素材</label>
                            <div class="col-md-8">
                                @if($material_url == '')
                                    <label>無</label>
                                @else
                                    <a href="{{$material_url}}">{{$material_name}}</a>
                                @endif
                                <button type="button" class="btn waves-effect waves-light btn-primary btn-sm m-l-10" onclick="reUploadMaterial()">重新上傳</button>
                            </div>
                        </div>

                        <div class="form-group row" id="re_upload_material" style="display: none">
                            <label for="material" class="col-md-2 control-label form-title">製作素材</label>
                            <div class="col-md-8">
                                <input type="file" id="material" name="material" class="dropify" data-height="100" accept=".zip, .rar" data-max-file-size="1G"/>
                                <button type="button" class="btn waves-effect waves-light btn-primary btn-sm" onclick="materialCancel()">取消</button>
                                <input type="hidden" id="isMaterialRe" name="isMaterialRe" value="0">
                            </div>
                        </div>

                    </div>
                    <div>
                        <button type="submit" id="submit" class="btn btn-warning w-md waves-effect waves-light button-font">編輯</button>
                    </div><!-- end col -->

                </form>
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container-fluid -->

    <script>
        //====宣傳影片====
        function reUploadVideo(){
            $('#re_upload_video').show();
            $('#upload_video').hide();
            $('#isVideoRe').val(1);
        }
        function videoCancel(){
            $('#re_upload_video').hide();
            $('#upload_video').show();
            $('#isVideoRe').val(0);
        }
        //====遊戲截圖====
        function reUploadImg(){
            $('#re_upload_img').show();
            $('#upload_img').hide();
            $('#isImgRe').val(1);
        }
        function imgCancel(){
            $('#re_upload_img').hide();
            $('#upload_img').show();
            $('#isImgRe').val(0);
        }
        //====遊戲執行檔====
        function reUploadExe(){
            $('#re_upload_exe').show();
            $('#upload_exe').hide();
            $('#isExeRe').val(1);
        }
        function exeCancel(){
            $('#re_upload_exe').hide();
            $('#upload_exe').show();
            $('#isExeRe').val(0);
        }
        //====製作素材====
        function reUploadMaterial(){
            $('#re_upload_material').show();
            $('#upload_material').hide();
            $('#isMaterialRe').val(1);
        }
        function materialCancel(){
            $('#re_upload_material').hide();
            $('#upload_material').show();
            $('#isMaterialRe').val(0);
        }

        $(function(){
            $("#submit").click(function(){
                var video = document.getElementById('video');
                var img = document.getElementById('img');
                var exe = document.getElementById('exe');
                var material = document.getElementById('material');

                //====宣傳影片====
                if (video.files[0] != null){
                    if (video.files[0].type != "video/mp4"){
                        alert("宣導影片格式錯誤。");
                        return false;
                    }
                }
                //====遊戲截圖====
                if (parseInt(img.files.length)>6){
                    alert("遊戲截圖上限為5張。");
                    return false;
                }
                var imgFileExtensions = ["image/jpg", "image/jpeg", "image/bmp", "image/gif", "image/png"];
                for (var i=0; i<img.files.length; i++){
                    if(!imgFileExtensions.includes(img.files[i].type)){
                        alert("遊戲截圖格式錯誤。");
                        return false;
                    }
                }
                var isImgRe = $('#isImgRe').val();
                if (isImgRe === 1){
                    if (img.files[0] == null){
                        alert("請上傳遊戲截圖。");
                        return false;
                    }
                }
                //====遊戲執行檔====
                var FileExtensions = ["rar", "zip"];
                if (exe.files[0] != null){
                    var exe_string = exe.files[0].name;
                    var exe_split = exe_string.split(".");
                    if(!FileExtensions.includes(exe_split[1])){
                        alert("遊戲執行檔格式錯誤。");
                        return false;
                    }
                }
                if (isExeRe === 1){
                    if (exe.files[0] == null){
                        alert("請上傳遊戲執行檔。");
                        return false;
                    }
                }
                //====製作素材====
                if (material.files[0] != null){
                    var material_string = material.files[0].name;
                    var material_split = material_string.split(".");
                    if(!FileExtensions.includes(material_split[1])){
                        alert("製作素材格式錯誤。");
                        return false;
                    }
                }
            });
        });
    </script>
@endsection
@section('title','編輯成果')
