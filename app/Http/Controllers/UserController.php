<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Users;
use App\Admin;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function logindo(Request $request)
    {
        $data=$request->except('_token');
        $where=[
            ['u_name','=',$data['u_name']],
            ['u_pwd','=',$data['u_pwd']]
        ];
        $res=Admin::where($where)->first();
        // dd($res['level']);
        if($res){
            session(['adminuser'=>$res]);
            if($res['level']==1){
                return view('user/list');
            }else{
                return view('user/listdo');
            }
        }else{
            return redirect('user/login')->with('msg','没有此用户');
        }
    }
    public function index()
    {
        $data=Users::all();
        return view('user/index',['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *添加页面
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user/create');
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
        $res=Users::create($data);
        if($res){
            return redirect('/user');
        }
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
        $data=Users::find($id);
        // dd($data);
        return view('/user/edit',['data'=>$data]);
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
        $data=$request->except('_token');
        $res=Users::where('u_id',$id)->update($data);
        if($res!==false){
            return redirect('/user');
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
        $res=Users::destroy($id);
        if($res){
            return redirect('user');
        }
    }
}
