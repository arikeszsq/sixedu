<?php

namespace App\Http\Controllers;


class UploadController extends Controller
{
    public function file()
    {
        //获取文件名
        $filename = $_FILES['file']['name'];
        //获取文件临时路径
        $temp_name = $_FILES['file']['tmp_name'];
        //获取大小
        $size = $_FILES['file']['size'];
        //获取文件上传码，0代表文件上传成功
        $error = $_FILES['file']['error'];
        //判断文件大小是否超过设置的最大上传限制
        if ($size > 2 * 1024 * 1024) {
//            文件大小超过2M大小
        }
        $arr = pathinfo($filename);
        //获取文件的后缀名
        $ext_suffix = $arr['extension'];
        //设置允许上传文件的后缀
        $allow_suffix = array('jpg', 'gif', 'jpeg', 'png');
        //判断上传的文件是否在允许的范围内（后缀）==>白名单判断
        if (!in_array($ext_suffix, $allow_suffix)) {
            //上传的文件类型只能是jpg,gif,jpeg,png
            return false;
        }
        //检测存放上传文件的路径是否存在，如果不存在则新建目录
        if (!file_exists('file_uploads')) {
            mkdir('file_uploads', 777);
        }
        //为上传的文件新起一个名字，保证更加安全
        $new_filename = date('YmdHis', time()) . rand(100, 1000) . '.' . $ext_suffix;
        //将文件从临时路径移动到磁盘
        $dest = 'file_uploads/' . $new_filename;
        if (move_uploaded_file($temp_name, $dest)) {
            return $dest;
            //文件上传成功！
        } else {
            //'文件上传失败,错误码：$error'
        }
    }
}
