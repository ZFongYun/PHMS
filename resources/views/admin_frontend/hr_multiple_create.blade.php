@extends('admin_frontend.layout.master')
@section('content')
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">多筆新增成員</h4>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title m-t-0 m-b-30">匯入成員資料說明</h4>
                        <p>1、請先<a href="#">點選我</a>下載檔案格式，編輯完成後請儲存為<mark>CSV格式</mark>。</p>
                        <p>2、完成存儲後，請在下方區域上傳文件，接著再點擊新增按鈕。</p>
                        <p>※ 若匯入學號已經是知點成員的話，則不做處理，反之則加入為成員。</p>
                    </div>
                </div>
                <form action="#" method="post">
                    <input type="file" class="dropify" data-height="100" />
                    <button type="submit" class="btn btn-primary w-md m-t-10 waves-effect waves-light button-font">新增</button>
                </form>
            </div><!-- end col -->
        </div>

@endsection
@section('title','新增成員')
