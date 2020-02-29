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
<caption>外来人口列表</caption>
<form>
        <input type="text" name="username" value="{{$username}}" placeholder="请输入名称" />
        <input type="submit" value="搜索" />
</form>
<table class="table">

    <thead>
        <tr>
            <th>id</th>
            <th>姓名</th>
            <th>年龄</th>
            <th>身份证</th>
            <th>头像</th>
            <th>是否是湖北人</th>
            <th>时间</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($data as $k=>$v)
        <tr @if($k%2==0) class="active" @else class="success" @endif >
            <th>{{$v->p_id}}</th>
            <th>{{$v->username}}</th>
            <th>{{$v->age}}</th>
            <th>{{$v->card}}</th>
            <th><img src="{{env('UPLOAD_URL')}}{{$v->head}}" width='40' height='40'></th>
            <th>{{$v->is_hubei==1?'√':'×'}}</th>
            <th>{{date('Y-m-d H:i:s',$v->add_time)}}</th>
            <th>
                <a href="{{url('people/edit/'.$v->p_id)}}" class="btn btn-info">编辑</a>
                <a href="{{url('people/destroy/'.$v->p_id)}}" class="btn btn-danger">删除</a>
            </th>
        </tr>
        @endforeach
        <tr><td colspan="7">{{$data->appends(['username'=>$username])->links()}}</td></tr>
    </tbody>
</table>


</body>
</html>