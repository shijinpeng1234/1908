<table border=1 class="table">
    <tr>
        <td>编号</td>
        <td>文章标题</td>
        <td>文章分类</td>
        <td>文章重要性</td>
        <td>是否显示</td>
        <td>描述</td>
        <td>图片</td>
        <td>添加日期</td>
        <td>操作</td>
    </tr>
    @foreach($data as $k=>$v)
    <tr a_id={{$v->a_id}}>
        <td>{{$v->a_id}}</td>
        <td>{{$v->a_title}}</td>
        <td>{{$v->a_classify==1?'手机促销':'站内咨询'}}</td>
        <td>{{$v->a_zy==1?'普通':'置顶'}}</td>
        <td>{{$v->is_show==1?'√':'×'}}</td>
        <td>{{$v->a_content}}</td>
        <td><img src="{{env('UPLOAD_URL')}}{{$v->a_img}}" width='40' height='40'></td>
        <td>{{date('Y-m-d H:i:s'),$v->a_time}}</td>
        <td>
            <a href="{{url('article/edit/'.$v->a_id)}}">编辑</a>
            <!-- <a href="{{url('article/destroy/'.$v->a_id)}}" class="del">删除</a> -->
            <a href="javascript:void(0)" onclick="del({{$v->a_id}})">删除</a>
        </td>
    </tr>
    @endforeach

</table>
