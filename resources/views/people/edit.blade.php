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

<form action="{{url('/people/update/'.$user->p_id)}}" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
@csrf
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">名字</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" id="firstname"
                   placeholder="请输入名字" name="username" value="{{$user->username}}" >
        </div>
    </div>
    <div class="form-group">
        <label for="lastname" class="col-sm-2 control-label">年龄</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" id="lastname"
                   placeholder="请输入年龄" name="age" value="{{$user->age}}">
        </div>
    </div>
    <div class="form-group">
        <label for="lastname" class="col-sm-2 control-label">身份证号</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" id="lastname"
                   placeholder="请输入身份证号" name="card" value="{{$user->card}}">
        </div>
    </div>
    <div class="form-group">
        <label for="lastname" class="col-sm-2 control-label">头像</label>
        <div class="col-sm-7">
            <input type="file" name="head" value="{{$user->head}}"/><img src="{{env('UPLOAD_URL')}}{{$user->head}}" width='40' height='40'>
        </div>
    </div>
    <div class="form-group">
    <label for="lastname" class="col-sm-2 control-label">是否是湖北人</label>

            <div class="checkbox">
                <label>
                    是&nbsp;&nbsp;<input type="radio" name="is_hubei" value="1" {{$user->is_hubei==1?'checked':''}}/>
                    否&nbsp;&nbsp;<input type="radio" name="is_hubei" value="2" {{$user->is_hubei==2?'checked':''}}/>
                </label>
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