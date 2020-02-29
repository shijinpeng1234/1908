<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use Validator;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $u_name=request()->u_name??'';
        $where=[];
        if($u_name){
            $where[]=['u_name','like',"%$u_name%"];
        }
        $pageSize=config('app.pageSize');
        // dd($pageSize);
        $arr=Admin::where($where)->paginate($pageSize);
        // dd($res);
        return view('admin/index',['arr'=>$arr]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=$request->except('_token');
        // dd($data);
        $validator=Validator::make($data,[
                    'u_name'=>'required|unique:admin',
                    'u_pwd'=>'required',
                    'u_pwds'=>'required',
                    'u_tel'=>'required',
                    'u_email'=>'required',
            ],[
                    'u_name.required'=>'账号不能为空',
                    'u_name.unique'=>'账号已存在',
                    'u_pwd.required'=>'密码不能为空',
                    'u_pwds.required'=>'确认密码不能为空',
                    'u_tel.required'=>'手机号不能为空',
                    'u_email.required'=>'邮箱不能为空',
            ]);
        if($validator->fails()){
                return redirect('admin/create')->withErrors($validator)->withInput();
            }
        //判断是否上传图片
        if($request->hasFile('u_img')){
            $data['u_img']=upload('u_img');
        }
        $res=Admin::create($data);
        if($res){
            return redirect('/admin');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data=Admin::find($id);
        // dd($data);
        return view('admin/edit',['data'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data=$request->except('_token');
        // dd($data);
        //判断是否上传图片
        if($request->hasFile('u_img')){
            $data['u_img']=upload('u_img');
        }
        $res=Admin::where('u_id',$id)->update($data);
        if($res!==false){
            return redirect('/admin');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd($id);
        $res=Admin::destroy($id);
        if($res){
            echo json_encode(['code'=>'00000','msg'=>'ok']);
        }
    }
     //ajax唯一性
    public function checkOnly()
    {
        $u_name=request()->u_name;
        $where=[];
        if($u_name){
            $where[]=['u_name','=',$u_name];
        }
        //排除自身
        $u_id=request()->u_id;
        if($u_id){
            $where[]=['u_id','!=',$u_id];
        }
        $count=Admin::where($where)->count();
        echo json_encode(['code'=>'00000','msg'=>'ok','count'=>$count]);
    }
}
