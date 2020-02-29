<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\People;
use App\Http\Requests\StorePeoplePost;
use Validator;
class PeopleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $username=request()->username??'';
        $where=[];
        if($username){
            $where[]=['username','like',"%$username%"];
        }

        //DB 操作
        // $data=DB::table('people')->get();

        //ORM 操作
        $pageSize=config('app.pageSize');
        $data=People::where($where)->paginate($pageSize);

        // dd($data);
        return view('people.index',['data'=>$data,'username'=>$username]);
    }

    /**
     * Show the form for creating a new resource.
     *添加页面
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('people/create');
    }

    /**
     * Store a newly created resource in storage.
     *执行添加
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    // public function store(StorePeoplePost $request)
    {
        // $request->validate([
        //         'username'=>'required|unique:people|max:12|min:2',
        //         'age'=>'required|integer|min:1|max:130',
        //     ],[
        //         'username.required'=>'姓名不能为空',
        //         'username.unique'=>'姓名已存在',
        //         'username.max'=>'姓名长度不能超过12位',
        //         'username.min'=>'姓名长度不能少于2位',
        //         'age.required'=>'年龄不能为空',
        //         'age.integer'=>'年龄必须为数字',
        //         'age.min'=>'年龄数据不合法',
        //         'age.max'=>'年龄数据不合法',
        //     ]);

        $data=$request->except('_token');
        //第三种
        $validator=Validator::make($data,[
                'username'=>'required|unique:people|max:12|min:2',
                'age'=>'required|integer|min:1|max:130',
            ],[
                'username.required'=>'姓名不能为空',
                'username.unique'=>'姓名已存在',
                'username.max'=>'姓名长度不能超过12位',
                'username.min'=>'姓名长度不能少于2位',
                'age.required'=>'年龄不能为空',
                'age.integer'=>'年龄必须为数字',
                'age.min'=>'年龄数据不合法',
                'age.max'=>'年龄数据不合法',
            ]);
            if($validator->fails()){
                return redirect('people/create')->withErrors($validator)->withInput();
            }

        //判断有没有文件上传
        if($request->hasFile('head')){
            $data['head']=$this->upload('head');
        }
        $data['add_time']=time();
        // dd($data);

        // DB 操作
        // $res=DB::table('people')->insert($data);

        //ORM 操作
        // $res=People::insert($data);
        $res=People::create($data);

        if($res){
            return redirect('/people');
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
        // $user=DB::table('people')->where('p_id',$id)->first();

        //ORM 操作
        //$user=People::where('p_id',$id)->first();
        $user=People::find($id);

        // dd($user);
        return view('people.edit',['user'=>$user]);
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
        //echo $id;
        $user=$request->except('_token');
        //判断有没有文件上传
        if($request->hasFile('head')){
            $user['head']=$this->upload('head');
        }
        //DB 操作
        // $res=DB::table('people')->where('p_id',$id)->update($user);
        //ORM操作
        $res=People::where('p_id',$id)->update($user);

        if($res!==false){
            return redirect('/people');
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
        // $res=DB::table('people')->Where('p_id',$id)->delete();
        //ORM操作
        $res=People::destroy($id);
        if($res){
            return redirect('/people');
        }
    }
}
