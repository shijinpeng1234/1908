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
<!-- @if ($errors->any())
<div class="alert alert-danger">
<ul>
@foreach ($errors->all() as $error)
<li>{{$error}}</li>
@endforeach
</ul>
</div>
@endif -->

<form action="{{url('/admin/store')}}" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
@csrf
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">账号</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" id="firstname"
                   placeholder="请输入账号" name="u_name">
                   <b style="color:blue">{{$errors->first('u_name')}}</b>
        </div>
    </div>
    <div class="form-group">
        <label for="lastname" class="col-sm-2 control-label">密码</label>
        <div class="col-sm-7">
            <input type="password" class="form-control" id="lastname"
                   placeholder="请输入密码" name="u_pwd">
                   <b style="color:blue">{{$errors->first('u_pwd')}}</b>
        </div>
    </div>
    <div class="form-group">
        <label for="lastname" class="col-sm-2 control-label">确认密码</label>
        <div class="col-sm-7">
            <input type="password" class="form-control" id="lastname"
                   placeholder="请再次输入密码" name="u_pwds">
                   <b style="color:blue"></b>
        </div>
    </div>
    <div class="form-group">
        <label for="lastname" class="col-sm-2 control-label">手机号</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" id="lastname"
                   placeholder="请输入手机号" name="u_tel">
                   <b style="color:blue">{{$errors->first('u_tel')}}</b>
        </div>
    </div>
    <div class="form-group">
        <label for="lastname" class="col-sm-2 control-label">邮箱</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" id="lastname"
                   placeholder="请输入邮箱" name="u_email">
                   <b style="color:blue">{{$errors->first('u_email')}}</b>
        </div>
    </div>
    <div class="form-group">
        <label for="lastname" class="col-sm-2 control-label">头像</label>
        <div class="col-sm-7">
            <input type="file" name="u_img" />
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-7">
            <!-- <button type="submit" class="btn btn-default">添加</button> -->
            <input type="button" class="btn btn-default" value="添加">
        </div>
    </div>
</form>

</body>
</html>
<script>
$.ajaxSetup({ headers:{ 'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content') } });
//表单提交
$('input[type="button"]').click(function(){
        var titleflag=true;
        $('input[name="u_name"]').next().html('');
        var u_name=$('input[name="u_name"]').val();
        var reg=/^\d{6,13}$/;
        if(!reg.test(u_name)){
            $('input[name="u_name"]').next().html('账号必须为6-13位数字');
            return;
        }
        $.ajax({
            type:'post',
            url:"/admin/checkOnly",
            data:{u_name:u_name},
            async:false,
            dataType:'json',
            success:function(result){
                // alert(result)
                // alert(result.count)
                if(result.count>0){
                    $('input[name="u_name"]').next().html('商品名称已存在')
                    titleflag=false
                }
            }
        })
        if(!titleflag){
            return ;
        }
        var u_pwd=$('input[name="u_pwd"]').val();
        var reg=/^\w{1,}$/;
        if(!reg.test(u_pwd)){
            $('input[name="u_pwd"]').next().html('密码不能为空、不能有特殊符号');
            return;
        }

        var u_pwds=$('input[name="u_pwds"]').val();
        var reg=/^\w{1,}$/;
        if(!reg.test(u_pwds)){
            $('input[name="u_pwds"]').next().html('确认密码不能为空、不能有特殊符号');
            return;
        }
        if(u_pwd!=u_pwds){
            $('input[name="u_pwds"]').next().html('两次密码不一致');
            return;
        }

        var u_tel=$('input[name="u_tel"]').val();
        var reg=/^\d{11}$/;
        if(!reg.test(u_tel)){
            $('input[name="u_tel"]').next().html('电话必须是11位数字');
            return;
        }

        var u_email=$('input[name="u_email"]').val();
        var reg=/^\w{6,18}@qq|163(\.)com$/
        if(!reg.test(u_email)){
            $('input[name="u_email"]').next().html('邮箱必须是6到18位数字字母下划线且包含@qq或163.com符号');
            return;
        }

        //form 提交
        $('form').submit();

    })




//账号
$('input[name="u_name"]').blur(function(){
    $(this).next().html('');
    var u_name=$(this).val();
    var reg=/^\d{6,13}$/;
    if(!reg.test(u_name)){
        $(this).next().html('账号必须为6-13位数字')
        return
    }
    //Ajax验证商品名称唯一性
    $.ajax({
            type:'post',
            url:"/admin/checkOnly",
            data:{u_name:u_name},
            dataType:'json',
            success:function(result){
                // alert(result)
                // alert(result.count)
                if(result.count>0){
                    $('input[name="u_name"]').next().html('商品名称已存在')
                }
            }
        })

})
//密码
$('input[name="u_pwd"]').blur(function(){
    $(this).next().html('');
    var u_pwd=$(this).val();
    var reg=/^\w{1,}$/;
    if(!reg.test(u_pwd)){
        $(this).next().html('密码不能为空、不能有特殊符号')
        return
    }
})
//确认密码
$('input[name="u_pwds"]').blur(function(){
    $(this).next().html('');
    var u_pwds=$(this).val();
    var u_pwd=$('input[name="u_pwd"]').val()
    var reg=/^\w{1,}$/;
    if(!reg.test(u_pwds)){
        $(this).next().html('密码不能为空、不能有特殊符号')
        return
    }
    if(u_pwd!=u_pwds){
         $(this).next().html('两次密码不一致')
         return
    }
})
//电话
$('input[name="u_tel"]').blur(function(){
    $(this).next().html('');
    var u_tel=$(this).val();
    var reg=/^\d{11}$/;
    if(!reg.test(u_tel)){
        $(this).next().html('电话必须是11位数字')
        return
    }
})
//邮箱
$('input[name="u_email"]').blur(function(){
    $(this).next().html('');
    var u_email=$(this).val();
    var reg=/^\w{6,18}@qq|163(\.)com$/;
    if(!reg.test(u_email)){
        $(this).next().html('邮箱必须是6到18位数字字母下划线且包含@qq或163.com符号')
        return
    }
})






</script>