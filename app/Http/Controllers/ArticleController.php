<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use DB;
use Validator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class articleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Redis::flushall();
        // Cache::flush();
        $a_title=request()->a_title??'';
        $a_classify=request()->a_classify??'';
        $where=[];
        if($a_title){
            $where[]=['a_title','like',"%$a_title%"];
        }
        if($a_classify){
            $where[]=['a_classify','=',$a_classify];
        }
        //接收当前页码
        $page=request()->page??1;
        $data=Redis::get('data_'.$page.'_'.$a_title);

        //获取缓存
        // $data=cache('data_'.$page.'_'.$a_title);
        dump($data);
        if(!$data){
            echo "DB";
            $pageSize=config('app.pageSize');
            $data=Article::where($where)->paginate($pageSize);
            // cache(['data_'.$page.'_'.$a_title=>$data],60*5);
            $data=serialize($data);
            Redis::setex('data_'.$page.'_'.$a_title,20,$data);
        }
        $query=request()->all();
        // dump($query);
        //是Ajax请求 即实现Ajax分页
        if(request()->ajax()){
             $data=unserialize($data);
             return view('article.ajaxpage',['data'=>$data,'a_classify'=>$a_classify,'query'=>$query]);
        }
        $data=unserialize($data);
        return view('article.index',['data'=>$data,'a_classify'=>$a_classify,'query'=>$query]);
    }

    /**
     * Show the form for creating a new resource.
     *添加页面
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('article/create');
    }

    /**
     * Store a newly created resource in storage.
     *执行添加
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

        $data=$request->except('_token');
        // dd($data);
        //第三种
        $validator=Validator::make($data,[
                // 'a_tile'=>['required','unique:article','regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9]{2,12}$/u'],
                'a_title'=>'required|unique:article',
                'a_zy'=>'required',
                'is_show'=>'required',
            ],[
                'a_title.required'=>'文章标题不能为空',
                'a_title.unique'=>'文章标题已存在',
                // 'a_title.regex'=>'文章标题必须是中文、数字、字母、下划线',
                'a_zy.required'=>'文章重要性不能为空',
                'is_show.required'=>'是否显示不能为空',
            ]);
            if($validator->fails()){
                return redirect('article/create')->withErrors($validator)->withInput();
            }

        //判断有没有文件上传
        if($request->hasFile('a_img')){
            $data['a_img']=$this->upload('a_img');
        }
        $data['a_time']=time();
        // dd($data);

        // DB 操作
        // $res=DB::table('article')->insert($data);

        //ORM 操作
        // $res=article::insert($data);
        $res=Article::create($data);

        if($res){
            return redirect('/article');
        }
    }

    public function upload($filename){
        //判断文件上传中是否出错
        if(request()->file($filename)->isValid()){
            //接收
            $photo=request()->file($filename);
            //上传
            $store_result=$photo->store('uploads');
            return $store_result;
        }
        exit('未获取到上传文件');
    }

    /**
     * Display the specified resource.
     *预览详情页
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *编辑页面
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //DB 操作
        // $user=DB::table('article')->where('a_id',$id)->first();

        //ORM 操作
        //$user=article::where('a_id',$id)->first();
        $data=Article::find($id);

        // dd($user);
        return view('article.edit',['data'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     *执行编辑
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // echo $id;die;
        $user=$request->except('_token');
        //判断有没有文件上传
        if($request->hasFile('a_img')){
            $user['a_img']=$this->upload('a_img');
        }
        //DB 操作
        // $res=DB::table('article')->where('a_id',$id)->update($user);
        //ORM操作
        $res=Article::where('a_id',$id)->update($user);

        if($res!==false){
            return redirect('/article');
        }
    }

    /**
     * Remove the specified resource from storage.
     *删除
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //echo $id
        //DB操作
        // $res=DB::table('article')->Where('a_id',$id)->delete();
        //ORM操作
        $res=Article::destroy($id);
        if($res){
            echo json_encode(['code'=>'00000','msg'=>'ok']);
        }
    }
    public function checkOnly(){
        // echo "123";die;
        $a_title=request()->a_title;
        $where=[];
        if($a_title){
            $where[]=['a_title','=',$a_title];
        }
        //排除自身
        $a_id=request()->a_id;
        if($a_id){
            $where[]=['a_id','!=',$a_id];
        }
        $count=Article::where($where)->count();
        echo json_encode(['code'=>'00000','msg'=>'ok','count'=>$count]);
    }
}
