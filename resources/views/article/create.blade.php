<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
<form action="{{url('/article/store')}}" method="post" enctype="multipart/form-data">
@csrf
    <table>
        <tr>
            <td>文章标题</td>
            <td>
                <input type="text" name="a_title"  />
                <b style="color:blue">{{$errors->first('a_title')}}</b>
            </td>
        </tr>
        <tr>
            <td>文章分类</td>
            <td>
                    <select name="a_classify">
                        <option value="">请选择--</option>
                        <option value="1">手机促销</option>
                        <option value="2">站内咨询</option>
                    </select>

            </td>
        </tr>
        <tr>
            <td>文章重要性</td>
            <td>
                <input type="radio" name="a_zy" checked value="1" />普通
                <input type="radio" name="a_zy" value="2" />置顶
                <b style="color:blue">{{$errors->first('a_zy')}}</b>
            </td>
        </tr>
        <tr>
            <td>是否显示</td>
            <td>
                <input type="radio" name="is_show" value="1" checked />显示
                <input type="radio" name="is_show" value="2" />不显示
                <b style="color:blue">{{$errors->first('is_show')}}</b>
            </td>
        </tr>
        <tr>
            <td>文章作者</td>
            <td><input type="text" name="a_author" /><b style="color:blue"></b></td>
        </tr>
        <tr>
            <td>作者Email</td>
            <td><input type="text" name="a_email" /></td>
        </tr>

        <tr>
            <td>网页描述</td>
            <td><textarea name="a_content"></textarea></td>
        </tr>
        <tr>
            <td>上传文件</td>
            <td><input type="file" name="a_img" /></td>
        </tr>
        <tr>
            <td><input type="button" value="确定" /></td>
            <td><input type="reset" value="重置" /></td>
        </tr>
    </table>
</form>


<script src="/static/js/jquery.min.js"></script>
<script>
$.ajaxSetup({ headers:{ 'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content') } });
    $('input[type="button"]').click(function(){
        var titleflag=true;
        $('input[name="a_title"]').next().html('');
        var a_title=$('input[name="a_title"]').val();
        var reg=/^[\u4e00-\u9fa50-9A-Za-z_]+$/;
        if(!reg.test(a_title)){
            $('input[name="a_title"]').next().html('文章标题由中文、数字、下划线组成且不能为空');
            return;
        }
        $.ajax({
            type:'post',
            url:"/article/checkOnly",
            data:{a_title:a_title},
            async:false,
            dataType:'json',
            success:function(result){
                // alert(result)
                // alert(result.count)
                if(result.count>0){
                    $('input[name="a_title"]').next().html('标题已存在')
                    titleflag=false
                }
            }
        })
        if(!titleflag){
            return ;
        }
        //作者
        var a_author=$('input[name="a_author"]').val();
        var reg=/^[\u4e00-\u9fa50-9A-Za-z_]{2,8}$/;
        if(!reg.test(a_author)){
            $('input[name="a_author"]').next().html('文章作者为2到8位数字字母下划线中文');
            return;
        }
        //form 提交
        $('form').submit();

    })
    $('input[name="a_author"]').blur(function(){
        $(this).next().html('');
        var a_author=$(this).val();
        console.log(a_author);
        var reg=/^[\u4e00-\u9fa50-9A-Za-z_]{2,8}$/;
        if(!reg.test(a_author)){
            $(this).next().html('文章作者为2到8位数字字母下划线中文');
            return;
        }
    })

    $('input[name="a_title"]').blur(function(){
        $(this).next().html('');
        var a_title=$(this).val();
        var reg=/^[\u4e00-\u9fa50-9A-Za-z_]+$/;
        if(!reg.test(a_title)){
            $(this).next().html('文章标题由中文、数字、下划线组成且不能为空');
            return;
        }
        // $.ajaxSetup({ headers:{ 'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content') } });
        // $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

        //验证唯一性
        $.ajax({
            type:'post',
            url:"/article/checkOnly",
            data:{a_title:a_title},
            dataType:'json',
            success:function(result){
                // alert(result)
                // alert(result.count)
                if(result.count>0){
                    $('input[name="a_title"]').next().html('标题已存在')
                }
            }
        })
    })




</script>

</body>
</html>





