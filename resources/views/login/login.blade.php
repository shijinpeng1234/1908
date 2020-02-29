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
<center><b style="color:red">{{session('msg')}}</b></center>
<form action="{{url('/logindo')}}" method="post"  class="form-horizontal" role="form">
@csrf
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">用户名</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" id="firstname"
                   placeholder="请输入用户名" name="u_name">

        </div>
    </div>
    <div class="form-group">
        <label for="lastname" class="col-sm-2 control-label">密码</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" id="lastname"
                   placeholder="请输入密码" name="u_pwd">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-7">
            <button type="submit" class="btn btn-default">登录</button>
        </div>
    </div>
</form>

</body>
</html>