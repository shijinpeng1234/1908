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

<form action="{{url('/people/store')}}" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
@csrf
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">名字</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" id="firstname"
                   placeholder="请输入名字" name="username">
                   <b style="color:blue">{{$errors->first('username')}}</b>
        </div>
    </div>
    <div class="form-group">
        <label for="lastname" class="col-sm-2 control-label">年龄</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" id="lastname"
                   placeholder="请输入年龄" name="age">
                   <b style="color:blue">{{$errors->first('age')}}</b>
        </div>
    </div>
    <div class="form-group">
        <label for="lastname" class="col-sm-2 control-label">身份证号</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" id="lastname"
                   placeholder="请输入身份证号" name="card">
        </div>
    </div>
    <div class="form-group">
        <label for="lastname" class="col-sm-2 control-label">头像</label>
        <div class="col-sm-7">
            <input type="file" name="head" />
        </div>
    </div>
    <div class="form-group">
    <label for="lastname" class="col-sm-2 control-label">是否是湖北人</label>

            <div class="checkbox">
                <label>
                    是&nbsp;&nbsp;<input type="radio" name="is_hubei" value="1" />
                    否&nbsp;&nbsp;<input type="radio" name="is_hubei" value="2" checked />
                </label>
            </div>

    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-7">
            <button type="submit" class="btn btn-default">添加</button>
        </div>
    </div>
</form>

</body>
</html>