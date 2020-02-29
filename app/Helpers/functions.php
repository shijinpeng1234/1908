<?php

/**
 * 公用的方法  返回json数据，进行信息的提示
 * @param $status 状态
 * @param string $message 提示信息
 * @param array $data 返回数据
 */

//分类表
function createTree($data,$pid=0,$level=1)
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
                createTree($data,$v->c_id,$level+1);
            }
        }
        return $newarray;
    }
//文件上传
function upload($filename){
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
//多文件上传
    function Moreuploads($filename){
       $photo = request()->file($filename);
       if(!is_array($photo)){
         return;
       }

       foreach( $photo as $v ){
          if ($v->isValid()){
            $store_result[] = $v->store('uploads');
          }
       }

       return $store_result;
    }