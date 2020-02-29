<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Document</title>
</head>
<body>
<form>
    <input type="text" name="sname" value="{{$sname}}" placeholder="姓名搜索" />
    <select name="class">
        <option value="">选择班级</option>
        <option value="1" {{$class==1?'selected':''}}>一班</option>
        <option value="2" {{$class==2?'selected':''}} >二班</option>
    </select>

    <input type="submit" value="搜索" />
</form>

    <table border=1>
    @csrf
        <tr>
            <td>id</td>
            <td>学生姓名</td>
            <td>性别</td>
            <td>班级</td>
            <td>成绩</td>
            <td>图片</td>
            <td>操作</td>
        </tr>
       @foreach($data as $k=>$v)
        <tr>
            <td>{{$v->sid}}</td>
            <td>{{$v->sname}}</td>
            <td>{{$v->sex==1?'男':'女'}}</td>
            <td> @if($v->class==1) 一班 @else 二班 @endif</td>
            <td>{{$v->score}}</td>
            <td><img src="{{env('UPLOAD_URL')}}{{$v->simg}}" width='40' height='40'></td>
            <td>
                <a href="{{url('student/edit/'.$v->sid)}}">编辑</a>
                <a href="{{url('student/destroy/'.$v->sid)}}">删除</a>
            </td>
        </tr>
        @endforeach
    </table>
{{$data->appends(['sname'=>$sname,'class'=>$class])->links()}}


</body>
</html>