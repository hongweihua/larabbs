<?php
/**
 * Created by PhpStorm.
 * User: whhong
 * Date: 2018/2/11
 * Time: 16:12
 */
namespace App\Handlers;

use Intervention\Image\Facades\Image;
class ImageUploadHandler
{
    // 限制可上传图片后缀
    protected $allowed_ext = ["png", "jpg", "gif", "jpeg"];

    public function save($file, $folder, $file_prefix, $max_width)
    {
        // 构建文件存储规则  uploads/images/avatars/201702/11/
        // 文件切割能让查询效率更高
        $folder_name = "uploads/images/$folder/" . date("Ym", time()) . '/' . date("d", time()) . '/';

        // 文件存储的具体的物理路径 "public_path"是 public 目录所在的物理路径
        $upload_path = public_path() . '/' . $folder_name;
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';

        // 拼接文件名  加前缀为了增加文件的辨识度，前缀可以是相关模型的 ID
        $filename = $file_prefix . '_' . time() . '_' . str_random(10) . '.' . $extension;

        if (!in_array($extension, $this->allowed_ext)) {
            return false;
        }

        $file->move($upload_path, $filename);

        // 如果限制了图片宽度，就进行裁剪
        if ($max_width && $extension != 'gif') {

            // 此类中封装的函数，用于裁剪图片
            $this->reduceSize($upload_path . '/' . $filename, $max_width);
        }

        return [
            'path' => config('app.url') . "/$folder_name/$filename"
        ];
    }

    public function reduceSize($file_path, $max_width)
    {
        // 先实例化，使用文件的磁盘物理路径
        $image = Image::make($file_path);
        $image->resize($max_width, null, function ($constraint) {
            // 设定宽度是 $max_width，高度等比例双方缩放
            $constraint->aspectRatio();

            // 防止裁图时图片尺寸变大
            $constraint->upsize();
        });
        // 保存修改后的图片
        $image->save();
    }

}