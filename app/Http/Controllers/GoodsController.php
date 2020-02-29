<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Brand;
use App\Goods;
use Validator;

use Illuminate\Support\Facades\Cache;
class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *展示页面
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        echo "123";
        $g_name=request()->g_name??'';
        $where=[];
        if($g_name){
            $where[]=['g_name','like',"%$g_name%"];
        }
        //接收当前页码
        // $page=request()->page??1;
        //获取缓存的值
        // $arr=Cache::('goods_'.$page.'-'.$g_name);
        // if(!$arr){
            $pageSize=config('app.pageSize');
            $arr=Goods::leftjoin("brand",'goods.b_id','=','brand.b_id')
                  ->leftjoin("category",'goods.c_id','=','category.c_id')->where($where)->paginate($pageSize);
            //存入缓存
            //Cache::put('arr',$arr,60*60);
            // cache(['goods_'.$page.'_'.$g_name=>$arr],60*60*2);
        // }


        // dd($res);
        return view('goods/index',['arr'=>$arr]);
    }

    /**
     * Show the form for creating a new resource.
     *添加页面
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $arr=Category::all();
        $data=Brand::all();
        $arr=createTree($arr);
        return view('goods/create',['arr'=>$arr,'data'=>$data]);
    }

    /**
     * Store a newly created resource in storg_number.
     *执行添加
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=$request->except('_token');

        //第三种
        $validator=Validator::make($data,[
                'g_name'=>'required|unique:goods',
                'g_number'=>'required|unique:goods',
                'g_price'=>'required|integer',
                'g_inventory'=>'required|integer',
            ],[
                'g_name.required'=>'商品名称不能为空',
                'g_name.unique'=>'商品名称已存在',
                'g_number.required'=>'商品货号不能为空',
                // 'g_number.integer'=>'商品货号必须为数字',
                'g_number.unique'=>'商品货号已存在',
                'g_price.required'=>'商品价格不能为空',
                'g_price.integer'=>'商品价格必须为数字',
                'g_inventory.required'=>'商品库存不能为空',
                'g_inventory.integer'=>'商品库存必须为数字',
            ]);
            if($validator->fails()){
                return redirect('goods/create')->withErrors($validator)->withInput();
            }
        //判断有没有文件上传
        if($request->hasFile('g_img')){
            $data['g_img']=upload('g_img');
        }
        //多文件上传
        if($data['g_imgs']){
            $photos=Moreuploads('g_imgs');
            $data['g_imgs']=implode('|',$photos);
        }


        $res=Goods::create($data);
        if($res){
            return redirect('/goods');
        }
    }

    /**
     * Display the specified resource.
     *详情页面
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
        $info=Goods::find($id);
        $arr=Category::all();
        $data=Brand::all();
        $arr=createTree($arr);
        // dd($arr);
        return view('/goods/edit',['info'=>$info,'arr'=>$arr,'data'=>$data]);
    }

    /**
     * Update the specified resource in storg_number.
     *执行编辑
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data=$request->except('_token');
        // dd($data);
        //判断有没有文件上传
        if($request->hasFile('g_img')){
            $data['g_img']=upload('g_img');
        }
        //多文件上传
        if($data['g_imgs']){
            $photos=Moreuploads('g_imgs');
            $data['g_imgs']=implode('|',$photos);
        }
        $res=Goods::where('g_id',$id)->update($data);
        if($res!==false){
            return redirect('goods');
        }

    }

    /**
     * Remove the specified resource from storg_number.
     *删除
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd($id);
        $res=Goods::destroy($id);
        if($res){
            echo json_encode(['code'=>'00000','msg'=>'ok']);
        }
    }
    //ajax唯一性
    public function checkOnly()
    {
        $g_name=request()->g_name;
        $where=[];
        if($g_name){
            $where[]=['g_name','=',$g_name];
        }
        //排除自身
        $g_id=request()->g_id;
        if($g_id){
            $where[]=['g_id','!=',$g_id];
        }
        $count=Goods::where($where)->count();
        echo json_encode(['code'=>'00000','msg'=>'ok','count'=>$count]);
    }
}
