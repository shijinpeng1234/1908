@extends('layouts.shop')
  @section('title','注册')

  @section('content')
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>会员注册</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="/static/index/images/head.jpg" />
     </div><!--head-top/-->
     <form action="{{url('/regdo')}}" method="post" class="reg-login">
     @csrf
      <h3>已经有账号了？点此<a class="orange" href="login.html">登陆</a></h3>
      <div class="lrBox">
       <div class="lrList"><input type="text" placeholder="输入手机号码或者邮箱号" class="u_tel" name="u_tel"/><b style="color:blue"></b></div>
       <div class="lrList2"><input type="text" placeholder="输入短信验证码" class="code" name="code"/><b style="color:blue"></b>
        <button type="button" id="code">获取验证码</button>
       <!-- <a id="code">获取验证码</a></div> -->

       <div class="lrList"><input type="text" placeholder="设置新密码（6-18位数字或字母）"  name="u_pwd" class="u_pwd" /><b style="color:blue"></b></div>
       <div class="lrList"><input type="text" placeholder="再次输入密码" class="u_pwds" name="u_pwds" /><b style="color:blue"></b></div>
      </div><!--lrBox/-->
      <div class="lrSub">
       <input type="submit" value="立即注册" />
      </div>
     </form><!--reg-login/-->
    @endsection

<script src="/static/js/jquery.min.js"></script>
<script>
//手机号
$(document).on('blur','.u_tel',function(){
    $(this).next().html('')
    var u_tel=$(this).val()
    if(u_tel==""){
      $(this).next().html('手机号不能为空')
    }
})
//验证码
$(document).on('blur','.code',function(){
    $(this).next().html('')
    var code=$(this).val()
    if(code==""){
      $(this).next().html('验证码不能为空')
    }
})
//密码
$(document).on('blur','.u_pwd',function(){
    $(this).next().html('')
    var u_pwd=$(this).val()
    if(u_pwd==""){
      $(this).next().html('密码不能为空')
    }
})
//确认密码
$(document).on('blur','.u_pwds',function(){
    $(this).next().html('')
    var u_pwds=$(this).val()
    var u_pwd=$('.u_pwd').val()
    if(u_pwds==""){
      $(this).next().html('确认密码不能为空')
      return
    }
    if(u_pwd!=u_pwds){
      $(this).next().html('两次密码不一致')
    }
})

$(document).on('click','#code',function(){
    var u_tel=$(".u_tel").val()
    // console.log(u_tel)
    if(!u_tel){
      alert('请输入手机号');
      return
    }
    $.get('/send',{u_tel:u_tel},function(res){
      if(res.code=='00000'){
        alert('发送成功')
      }
    },'json')
})










</script>