<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $c_name=request()->c_name??'';
        $where=[];
        if($c_name){
            $where[]=['c_name','like',"%$c_name%"];
        }
        $data=Category::where($where)->get();
        $data=$this->createTree($data);
        // dd($data);
        return view('category/index',['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *添加页面
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data=Category::all();
        // dd($data);
        // $data=$this->createTree($data);
        $data= createTree($data);
        return view('category/create',['data'=>$data]);
    }

    public function createTree($data,$pid=0,$level=1)
    {
        if(!$data){
            return;
        }
        static $newarray=[];
        foreach($data as $k=>$v){
            if($v->pid==$pid){
                $v->level=$level;
                $newarray[]=$v;

                //调用本身
                $this->createTree($data,$v->c_id,$level+1);
            }
        }
        return $newarray;
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
        $res=Category::create($data);
        if($res){
           return redirect('/category');
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
        $arr=Category::find($id);
        $data=Category::get();
        $data=$this->createTree($data);
        // dd($arr);
        return view('category/edit',['arr'=>$arr,'data'=>$data]);
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
        // dd($data);
        $res=Category::where('c_id',$id)->update($data);
        if($res){
            return redirect('/category');
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
        $where=[
            ['pid','=',$id]
        ];
        $count=Category::where($where)->count();
        if($count>0){
            echo "<script>alert('此分类下有子分类，不能删除')</script>";die;
        }else{
           $res=Category::destroy($id);
            if($res){
                return redirect('/category');
            }
        }

    }

}