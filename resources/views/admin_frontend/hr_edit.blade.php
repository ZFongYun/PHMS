@extends('admin_frontend.layout.master')
@section('content')

<form action="{{action('AdminHrController@update',$memberToEdit['id'])}}" method="post">
    {{ csrf_field() }}
<input id="btnAdd" type="button" value="add" onclick="add_field()" />

<div id="main" class="m-t-10"></div>

    @foreach($member_position as $row)
        <div id="position{{$row['id']}}">
        <select class="form-control-select" id="position" name="position_mu[]">
            <option>請選擇</option>
            <option value="0" {{$row['position'] == 0 ? 'selected' : ''}}>PM</option>
            <option value="1" {{$row['position'] == 1 ? 'selected' : ''}}>HR</option>
            <option value="2" {{$row['position'] == 2 ? 'selected' : ''}}>核銷</option>
            <option value="3" {{$row['position'] == 3 ? 'selected' : ''}}>行政</option>
            <option value="4" {{$row['position'] == 4 ? 'selected' : ''}}>企劃講師</option>
            <option value="5" {{$row['position'] == 5 ? 'selected' : ''}}>程式講師</option>
            <option value="6" {{$row['position'] == 6 ? 'selected' : ''}}>美術講師</option>
            <option value="7" {{$row['position'] == 7 ? 'selected' : ''}}>企劃助教</option>
            <option value="8" {{$row['position'] == 8 ? 'selected' : ''}}>程式助教</option>
            <option value="9" {{$row['position'] == 9 ? 'selected' : ''}}>美術助教</option>
            <option value="10" {{$row['position'] == 10 ? 'selected' : ''}}>無</option>
        </select>
            <button type="button" value="Remove" onclick = "RemoveExistSelect(position{{$row['id']}})" class="btn-sm btn-rounded waves-effect waves-light btn-danger m-l-10"> <i class="fa fa-remove"></i></button>
        <br>
        </div>
    @endforeach
    <input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
<button type="submit" class="btn btn-success w-md waves-effect waves-light button-font">新增</button>
</form>


<script>
    function GetDynamicTextBox(value){
        return '<select class="form-control-select m-b-10" id="position" name="position_mu[]">'+
        '<option>請選擇</option>'+
        '<option value="0">PM</option>'+
        '<option value="1">HR</option>'+
        '<option value="2">核銷</option>'+
        '<option value="3">行政</option>'+
        '<option value="4">企劃講師</option>'+
        '<option value="5">程式講師</option>'+
        '<option value="6">美術講師</option>'+
        '<option value="7">企劃助教</option>'+
        '<option value="8">程式助教</option>'+
        '<option value="9">美術助教</option>'+
        '</select>'+
        '<button type="button" value="Remove" onclick = "RemoveSelect(this)" class="btn-sm btn-rounded waves-effect waves-light btn-danger m-l-10"> <i class="fa fa-remove"></i></button>'
    }

    function add_field() {
        var div = document.createElement('DIV');
        div.innerHTML = GetDynamicTextBox("");
        document.getElementById("main").appendChild(div);
    }

    function RemoveSelect(div) {
        document.getElementById("main").removeChild(div.parentNode);
    }

    function RemoveExistSelect(myObj) {
        var parentObj = myObj.parentNode;
        parentObj.removeChild(myObj);
    }


</script>
@endsection
@section('title','編輯成員')
