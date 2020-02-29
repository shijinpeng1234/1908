<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Document</title>
</head>
<body>
    <form action="{{url('/student/update/'.$user->sid)}}" method="post" enctype="multipart/form-data">
    @csrf
        <table>
            <tr>
                <td>学生姓名</td>
                <td><input type="text" name="sname" value="{{$user->sname}}" /><b style="color:red">{{$errors->first('sname')}}</b></td>
            </tr>
            <tr>
                <td>性别</td>
                <td>
                    男<input type="radio" name="sex" value="1" {{$user->sex==1?'checked':''}}/>
                    女<input type="radio" name="sex" value="2" {{$user->sex==2?'checked':''}}/>
                    <b style="color:red">{{$errors->first('sex')}}</b>
                </td>
            </tr>
            <tr>
                <td>班级</td>
                <td>
                    <select name="class">
                        <option value="1" {{$user->class==1?'selected':''}}>一班</option>
                        <option value="2" {{$user->class==2?'selected':''}}>二班</option>
                    </select>

                </td>
            </tr>
            <tr>
                <td>图片</td>
                <td><img src="{{env('UPLOAD_URL')}}{{$user->simg}}" width='40' height='40'><input type="file" name="simg" value="{{$user->simg}}" /></td>
            </tr
            <tr>
                <td>成绩</td>
                <td>
                    <input type="text" name="score" value="{{$user->score}}" />
                    <b style="color:red">{{$errors->first('score')}}</b>
                </td>
            </tr>
            <tr>
                <td><input type="submit" value="编辑" /></td>
                <td></td>
            </tr>
        </table>
    </form>


</body>
</html>