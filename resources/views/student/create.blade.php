<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Document</title>
</head>
<body>
    <form action="{{url('/student/store')}}" method="post" enctype="multipart/form-data">
    @csrf
        <table>
            <tr>
                <td>学生姓名</td>
                <td><input type="text" name="sname" /><b style="color:blue">{{$errors->first('sname')}}</b></td>
            </tr>
            <tr>
                <td>性别</td>
                <td>
                    男<input type="radio" name="sex" value="1" checked />
                    女<input type="radio" name="sex" value="2" /><b style="color:blue">{{$errors->first('sex')}}</b>
                </td>
            </tr>
            <tr>
                <td>班级</td>
                <td>
                    <select name="class">
                        <option value="1">一班</option>
                        <option value="2">二班</option>
                    </select>

                </td>
            </tr>
            <tr>
                <td>图片</td>
                <td><input type="file" name="simg" /></td>
            </tr>
            <tr>
                <td>成绩</td>
                <td><input type="text" name="score" /><b style="color:blue">{{$errors->first('score')}}</b></td>
            </tr>
            <tr>
                <td><input type="submit" value="添加" /></td>
                <td></td>
            </tr>
        </table>
    </form>


</body>
</html>