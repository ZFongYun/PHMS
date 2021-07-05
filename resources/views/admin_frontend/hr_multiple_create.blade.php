@extends('admin_frontend.layout.master')
@section('content')
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">多筆新增成員</h4>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title m-t-0 m-b-30">匯入成員資料說明</h4>
                        <p>1、請先<a href="{{route('Overall.download')}}">點選我</a>下載檔案格式，依照標題填入成員的姓名、學號、加入學年度、預設密碼。</p>
                        <p>2、編輯完成後請文件儲存為<mark>.xlsx</mark>檔，接著請在下方區域上傳文件，最後點擊新增按鈕。</p>
                        <p>※ 若匯入學號已經是知點成員的話，則不做處理，反之則加入為成員。</p>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <ul>
                            <strong>加入失敗</strong>
                        </ul>
                    </div>
                @endif
                @if($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif

                <form action="{{route('Overall.multiple_store')}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="file" name="import_file" class="dropify" data-height="100" />
                    <button type="submit" class="btn btn-primary w-md m-t-10 waves-effect waves-light button-font">新增</button>
                </form>
            </div><!-- end col -->
        </div>

@endsection
@section('title','新增成員')
