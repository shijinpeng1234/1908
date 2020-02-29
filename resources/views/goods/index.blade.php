<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>商品列表</title>
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">
    <script src="/static/js/jquery.min.js"></script>
    <script src="/static/js/bootstrap.min.js"></script>
</head>
<body>
<caption>商品列表</caption>
<form>
        <input type="text" name="g_name" placeholder="请输入商品名称" />

        <input type="submit" value="搜索" />
</form>
<table class="table">

    <thead>
        <tr>
            <th>id</th>
            <th>商品名称</th>
            <th>商品货号</th>
            <th>商品价格</th>
            <th>商品库存</th>
            <th>是否精品</th>
            <th>是否热卖</th>
            <th>商品详情</th>
            <th>商品图片</th>
            <th>商品相册</th>
            <th>品牌</th>
            <th>分类</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($arr as $k=>$v)
        <tr @if($k%2==0) class="active" @else class="success" @endif g_id="{{$v->g_id}}">
            <th>{{$v->g_id}}</th>
            <th>{{$v->g_name}}</th>
            <th>{{$v->g_number}}</th>
            <th>{{$v->g_price}}</th>
            <th>{{$v->g_inventory}}</th>
            <th>{{$v->is_jing==1?'√':'×'}}</th>
            <th>{{$v->is_hot==1?'√':'×'}}</th>
            <th>{{$v->g_content}}</th>
            <th><img src="{{env('UPLOAD_URL')}}{{$v->g_img}}" width='40' height='40'></th>
            <th>
            @if($v->g_imgs)
            @php $g_imgs=explode('|',$v->g_imgs);@endphp
            @foreach($g_imgs as $vv)
            <img src="{{env('UPLOAD_URL')}}{{$vv}}" width='40' height='40'>
            @endforeach
            @endif
            </th>
            <th>{{$v->b_name}}</th>
            <th>{{$v->c_name}}</th>
            <th>
                <a href="{{url('goods/edit/'.$v->g_id)}}" class="btn btn-info">编辑</a>
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
    var g_id=_this.parents('tr').attr('g_id')
    console.log(g_id)
    if(window.confirm('是否确认删除？')){
        $.get(
                '/goods/destroy/'+g_id,
                function(res){
                    if(res.code=='00000'){
                        location.reload();
                    }
                },'json'
            )
    }

})



</script>

