<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bootstrap 实例 - 水平表单</title>
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">
    <script src="/static/js/jquery.min.js"></script>
    <script src="/static/js/bootstrap.min.js"></script>
</head>
<body>
<!-- @if ($errors->any())
<div class="alert alert-danger">
<ul>
@foreach ($errors->all() as $error)
<li>{{$error}}</li>
@endforeach
</ul>
</div>
@endif -->

<form action="{{url('/user/update/'.$data->u_id)}}" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
@csrf
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">用户名</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" id="firstname"
                   placeholder="请输入用户名" name="u_name" value="{{$data->u_name}}">

        </div>
    </div>
    <div class="form-group">
        <label for="lastname" class="col-sm-2 control-label">用户身份</label>
        <div class="col-sm-7">
                    主管&nbsp;&nbsp;<input type="radio" name="u_sf" value="1" {{$data->u_sf==1?'checked':''}} />
                    库管&nbsp;&nbsp;<input type="radio" name="u_sf" value="2" {{$data->u_sf==2?'checked':''}} />
        </div>
    </div>



    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-7">
            <button type="submit" class="btn btn-default">编辑</button>
        </div>
    </div>
</form>

</body>
</html>