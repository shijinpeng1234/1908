<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>分类列表</title>
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">
    <script src="/static/js/jquery.min.js"></script>
    <script src="/static/js/bootstrap.min.js"></script>
</head>
<body>
<caption>分类列表</caption>
<form>
        <input type="text" name="c_name"  placeholder="请输入分类名称" />
        <input type="submit" value="搜索" />
</form>
<table class="table">

    <thead>
        <tr>
            <th>id</th>
            <th>分类名称</th>
            <th>分类介绍</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($data as $k=>$v)
        <tr @if($k%2==0) class="active" @else class="success" @endif >
            <th>{{$v->c_id}}</th>
            <th>{{str_repeat('|——',$v->level)}}{{$v->c_name}}</th>
            <th>{{$v->c_content}}</th>
            <th>
                <a href="{{url('category/edit/'.$v->c_id)}}" class="btn btn-info">编辑</a>
                <a href="{{url('category/destroy/'.$v->c_id)}}" class="btn btn-danger">删除</a>
            </th>
        </tr>
        @endforeach
    </tbody>
</table>


</body>
</html>