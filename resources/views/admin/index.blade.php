<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>管理员列表</title>
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">
    <script src="/static/js/jquery.min.js"></script>
    <script src="/static/js/bootstrap.min.js"></script>
</head>
<body>
<caption>管理员列表</caption>
<form>
        <input type="text" name="u_name" placeholder="请输入账号" />

        <input type="submit" value="搜索" />
</form>
<table class="table">

    <thead>
        <tr>
            <th>id</th>
            <th>账号</th>
            <th>电话</th>
            <th>邮箱</th>
            <th>头像</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($arr as $k=>$v)
        <tr @if($k%2==0) class="active" @else class="success" @endif u_id="{{$v->u_id}}">
            <th>{{$v->u_id}}</th>
            <th>{{$v->u_name}}</th>
            <th>{{$v->u_tel}}</th>
            <th>{{$v->u_email}}</th>
            <th><img src="{{env('UPLOAD_URL')}}{{$v->u_img}}" width='40' height='40'></th>
            <th>
                <a href="{{url('admin/edit/'.$v->u_id)}}" class="btn btn-info">编辑</a>
                <!-- <a href="{{url('goods/destroy/'.$v->g_id)}}" class="btn btn-danger">删除</a> -->
                <a href="javascript:;"  class="btn btn-danger del">删除</a>
            </th>
        </tr>
        @endforeach
        <tr><td colspan="7">{{$arr->links()}}</td></tr>
    </tbody>
</table>


</body>
</html>
<script>
$(document).on('click','.del',function(){
    console.log(1232)
    var _this=$(this)
    var u_id=_this.parents('tr').attr('u_id')
    console.log(u_id)
    if(window.confirm('是否确认删除？')){
        $.get(
                '/admin/destroy/'+u_id,
                function(res){
                    if(res.code=='00000'){
                        location.reload();
                    }
                },'json'
            )
    }

})



</script>

