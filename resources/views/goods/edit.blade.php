<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bootstrap 实例 - 水平表单</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">
    <script src="/static/js/jquery.min.js"></script>
    <script src="/static/js/bootstrap.min.js"></script>
</head>
<body>

<form action="{{url('/goods/update/'.$info->g_id)}}" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
@csrf
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">商品名称</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" id="firstname"
                   placeholder="请输入商品名称" name="g_name" value="{{$info->g_name}}">
                   <b style="color:blue">{{$errors->first('g_name')}}</b>
        </div>
    </div>
    <div class="form-group">
        <label for="lastname" class="col-sm-2 control-label">商品货号</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" id="lastname"
                   placeholder="请输入商品货号" name="g_number" value="{{$info->g_number}}">
                   <b style="color:blue">{{$errors->first('g_number')}}</b>
        </div>
    </div>
    <div class="form-group">
        <label for="lastname" class="col-sm-2 control-label">商品价格</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" id="lastname"
                   placeholder="商品价格" name="g_price" value="{{$info->g_price}}">
                   <b style="color:blue">{{$errors->first('g_price')}}</b>
        </div>
    </div>
    <div class="form-group">
        <label for="lastname" class="col-sm-2 control-label">库存</label>
        <div class="col-sm-7">
            <input type="text" name="g_inventory" placeholder="请输入库存" value="{{$info->g_inventory}}"/>
            <b style="color:blue">{{$errors->first('g_inventory')}}</b>
        </div>
    </div>
    <div class="form-group">
    <label for="lastname" class="col-sm-2 control-label">是否是精品</label>

            <div class="checkbox">
                <label>
                    是&nbsp;&nbsp;<input type="radio" name="is_jing" value="1" {{$info->is_jing==1?'checked':''}}/>
                    否&nbsp;&nbsp;<input type="radio" name="is_jing" value="2" {{$info->is_jing==2?'checked':''}} />
                </label>
            </div>

    </div>
    <div class="form-group">
    <label for="lastname" class="col-sm-2 control-label">是否是热卖</label>

            <div class="checkbox">
                <label>
                    是&nbsp;&nbsp;<input type="radio" name="is_hot" value="1" {{$info->is_hot==1?'checked':''}} />
                    否&nbsp;&nbsp;<input type="radio" name="is_hot" value="2" {{$info->is_hot==2?'checked':''}} />
                </label>
            </div>

    </div>
    <div class="form-group">
        <label for="lastname" class="col-sm-2 control-label">商品详细</label>
        <div class="col-sm-7">
            <textarea name="g_content">{{$info->g_content}}</textarea>
        </div>
    </div>
    <div class="form-group">
        <label for="lastname" class="col-sm-2 control-label">商品图片</label>
        <div class="col-sm-7">
            <input type="file" name="g_img" /><img src="{{env('UPLOAD_URL')}}{{$info->g_img}}" width='40' height='40'>
        </div>
    </div>
    <div class="form-group">
        <label for="lastname" class="col-sm-2 control-label">商品相册</label>
        <div class="col-sm-7">
            <input type="file" name="g_imgs[]" multiple="multiple" />
            @if($info->g_imgs)
            @php $g_imgs=explode('|',$info->g_imgs);@endphp
            @foreach($g_imgs as $vv)
            <img src="{{env('UPLOAD_URL')}}{{$vv}}" width='40' height='40'>
            @endforeach
            @endif
        </div>
    </div>
    <div class="form-group">
        <label for="lastname" class="col-sm-2 control-label">请选择品牌</label>
        <div class="col-sm-7">
            <select name="b_id">
                <option value="">请选择品牌</option>
                @foreach($data as $k=>$v)
                <option value="{{$v->b_id}}" {{$info->b_id==$v->b_id?'selected':''}}>{{$v->b_name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="lastname" class="col-sm-2 control-label">请选择分类</label>
        <div class="col-sm-7">
            <select name="c_id">
                <option value="">请选择分类</option>
                @foreach($arr as $k=>$v)
                <option value="{{$v->c_id}}" {{$info->c_id==$v->c_id?'selected':''}}>{{str_repeat('|——',$v->level)}}{{$v->c_name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-7">
            <!-- <button type="button" class="btn btn-default">添加</button> -->
            <input type="button" class="btn btn-default" value="编辑"/>
        </div>
    </div>
</form>

</body>
</html>
<script>
$.ajaxSetup({ headers:{ 'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content') } });
//全局变量
var g_id={{$info->g_id}}
//表单提交
$('input[type="button"]').click(function(){
        var titleflag=true;
        $('input[name="g_name"]').next().html('');
        var g_name=$('input[name="g_name"]').val();
        var reg=/^[\u4e00-\u9fa50-9A-Za-z_]{2,8}$/;
        if(!reg.test(g_name)){
            $('input[name="g_name"]').next().html('商品名称由中文、字母、数字、下划线组成且长度2-8位');
            return;
        }
        $.ajax({
            type:'post',
            url:"/goods/checkOnly",
            data:{g_name:g_name,g_id:g_id},
            async:false,
            dataType:'json',
            success:function(result){
                // alert(result)
                // alert(result.count)
                if(result.count>0){
                    $('input[name="g_name"]').next().html('商品名称已存在')
                    titleflag=false
                }
            }
        })
        if(!titleflag){
            return ;
        }
        var g_number=$('input[name="g_number"]').val();
        var reg=/^\d{3,}$/;
        if(!reg.test(g_number)){
            $('input[name="g_number"]').next().html('商品货号必须是不小于3位的数字');
            return;
        }

        var g_price=$('input[name="g_price"]').val();
        var reg=/^\d{1,}(\.)00$/;
        if(!reg.test(g_price)){
            $('input[name="g_price"]').next().html('商品价格必须是数字');
            return;
        }

        var g_inventory=$('input[name="g_inventory"]').val();
        var reg=/^\d{1,}$/;
        if(!reg.test(g_inventory)){
            $('input[name="g_inventory"]').next().html('商品库存必须为数字');
            return;
        }

        //form 提交
        $('form').submit();

    })








//商品名称
$('input[name="g_name"]').blur(function(){
    $(this).next().html('');
    var g_name=$(this).val();
    var reg=/^[\u4e00-\u9fa50-9A-Za-z_]{2,8}$/;
    if(!reg.test(g_name)){
        $(this).next().html('商品名称由中文、字母、数字、下划线组成且长度2-8位')
        return
    }
    //Ajax验证商品名称唯一性
    $.ajax({
            type:'post',
            url:"/goods/checkOnly",
            data:{g_name:g_name,g_id:g_id},
            dataType:'json',
            success:function(result){
                // alert(result)
                // alert(result.count)
                if(result.count>0){
                    $('input[name="g_name"]').next().html('商品名称已存在')
                }
            }
        })

})
//商品价格
$('input[name="g_price"]').blur(function(){
    $(this).next().html('');
    var g_price=$(this).val();
    var reg=/^\d{1,}(\.)00$/;
    if(!reg.test(g_price)){
        $(this).next().html('商品价格必须是数字')
        return
    }
})
//商品货号
$('input[name="g_number"]').blur(function(){
    $(this).next().html('');
    var g_number=$(this).val();
    var reg=/^\d{3,}$/;
    if(!reg.test(g_number)){
        $(this).next().html('商品货号必须是不小于3位的数字')
        return
    }
})
//商品库存
$('input[name="g_inventory"]').blur(function(){
    $(this).next().html('');
    var g_inventory=$(this).val();
    var reg=/^\d{1,}$/;
    if(!reg.test(g_inventory)){
        $(this).next().html('商品库存必须为数字')
        return
    }
})

</script>
