<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>user列表</title>
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">
    <script src="/static/js/jquery.min.js"></script>
    <script src="/static/js/bootstrap.min.js"></script>
</head>
<body>


<table class="table">
<a href="{{url('user/create')}}">添加</a>
    <thead>
        <tr>
            <th>id</th>
            <th>用户名称</th>
            <th>用户身份</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($data as $k=>$v)
        <tr @if($k%2==0) class="active" @else class="success" @endif >
            <th>{{$v->u_id}}</th>
            <th>{{$v->u_name}}</th>
            <th>{{$v->u_sf==1?'主管':'库管'}}</th>

            <th>
                <a href="{{url('user/edit/'.$v->u_id)}}" class="btn btn-info">编辑</a>
                <a href="{{url('user/destroy/'.$v->u_id)}}" class="btn btn-danger">删除</a>
            </th>
        </tr>
        @endforeach
    </tbody>
</table>


</body>
</html>