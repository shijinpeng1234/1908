<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use DB;
use Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sname=request()->sname??'';
        $class=request()->class??'';
        $where=[];
        if($sname){
            $where[]=['sname','like',"%$sname%"];
        }
        if($class){
            $where[]=['class','=',$class];
        }
        $pagSize=config('app.pageSize');
        $data=DB::table('student')->where($where)->paginate($pagSize);
        // dd($data);
        return view('student.index',['data'=>$data,'sname'=>$sname,'class'=>$class]);
    }

    /**
     * Show the form for creating a new resource.
     *添加页面
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('student/create');
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
        $validator=Validator::make($data,[
                    'sname'=>['required','unique:student','regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9]{2,12}$/u'],
                    'sex'=>'numeric',
                    'score'=>'required|numeric|between:0,100',
            ],[
                    'sname.required'=>'姓名不能为空',
                    'sname.unique'=>'姓名已存在',
                    'sname.regex'=>'姓名必须是中文，数字，字母，下划线',
                    'sex.numeric'=>'性别为数字',
                    'score.required'=>'成绩不能为空',
                    'score.numeric'=>'必须是数字',
                    'score.between'=>'成绩不能超过100',

            ]);
        if($validator->fails()){
                return redirect('student/create')
                        ->withErrors($validator)
                        ->withInput();
            }

        //判断有没有文件上传
        if($request->hasFile('simg')){
            $data['simg']=$this->upload('simg');
        }

        $res=DB::table('student')->insert($data);
        if($res){
            return redirect('/student');
        }
    }
    public function upload($filename){
        if(request()->file($filename)->isValid()){
            $file=request()->file($filename);
            $store_result=$file->store('uploads');

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
        $user=DB::table('student')->where('sid',$id)->first();
        // dd($user);
        return view('student.edit',['user'=>$user]);
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
        // dd($user);
        $validator=Validator::make($user,[
                    'sname'=>[
                            'regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9_-]{2,12}$/u',
                            Rule::unique('student')->ignore($id,'sid'),
                            ],
                    // 'sname'=>['required','regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9]{2,12}$/u'],
                    'sex'=>'numeric',
                    'score'=>'required|numeric|between:0,100',
            ],[
                    // 'sname.required'=>'姓名不能为空',
                    'sname.unique'=>'姓名已存在',
                    'sname.regex'=>'姓名必须是中文，数字，字母，下划线',
                    'sex.numeric'=>'性别为数字',
                    'score.required'=>'成绩不能为空',
                    'score.numeric'=>'必须是数字',
                    'score.between'=>'成绩不能超过100',

            ]);
        if($validator->fails()){
                return redirect('student/edit/'.$id)
                        ->withErrors($validator)
                        ->withInput();
            }

        //判断有没有文件上传
        if($request->hasFile('simg')){
            $user['simg']=$this->upload('simg');
        }
        $res=DB::table('student')->where('sid',$id)->update($user);
        if($res!==false){
            return redirect('/student');
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
        // echo $id;
        $res=DB::table('student')->Where('sid',$id)->delete();
        if($res){
            return redirect('/student');
        }
    }
}
