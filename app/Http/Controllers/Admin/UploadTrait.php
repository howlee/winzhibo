<?php
/**
 * Created by PhpStorm.
 * User: maozhijun
 * Date: 17/5/22
 * Time: 13:09
 */

namespace App\Http\Controllers\Admin;


use App\Models\Upload;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait UploadTrait
{

    public function saveUploadedFile(UploadedFile $file, $disks)
    {
        $env = env('APP_URL');
        $length = $file->getClientSize();
        $md5 = md5_file($file->getRealPath());
        $extension = $file->guessClientExtension();
        $mime = $file->getMimeType();
        $suffix = last(explode('/', $mime));
        $upload = Upload::query()->where(['md5' => $md5, 'length' => $length, 'env' => $env])->first();
        if (isset($upload)) {
            return $upload;
        }
        $upload = new Upload();
        $upload->md5 = $md5;
        $upload->length = $length;
        $upload->suffix = $suffix;
        $upload->extension = $extension;
        $upload->mime = $mime;
        $path = $file->storeAs(date('Ymd'), str_random() . '.' . $extension, $disks);
        $upload->path = $path;
        $upload->disks = $disks;
        $upload->env = $env;
        $upload->save();
        return $upload;
    }

    public function saveUrlFile($url, $disks)
    {
        $env = env('APP_URL');

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
//        echo $response;
        $md5 = md5($response);
        $mime = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        if (strpos($mime, ';') !== false) {
            $mime = explode(';', $mime)[0];
        }
        $length = curl_getinfo($ch, CURLINFO_SIZE_DOWNLOAD);
        $suffix = last(explode('/', $mime));
        $upload = Upload::query()->where(['md5' => $md5, 'length' => $length, 'env' => $env])->first();
        if (isset($upload)) {
//            echo $upload->getUrl();
            return $upload;
        }
        $upload = new Upload();
        $upload->md5 = $md5;
        $upload->length = $length;
        $upload->suffix = $suffix;
        $upload->extension = $suffix;
        $upload->mime = $mime;
        $path = date('Ymd') . '/' . str_random() . '.' . $suffix;
        Storage::disk($disks)->put($path, $response);
        $upload->env = $env;
        $upload->path = $path;
        $upload->disks = $disks;
//        echo $upload->getUrl();
        $upload->save();
        return $upload;
    }


    /**
     * @param $imgSrc    目标图片，可带相对目录地址，
     * @param $markImg   水印图片，可带相对目录地址，支持PNG和GIF两种格式，如水印图片在执行文件mark目录下，可写成：mark/mark.gif
     * @param $markText  给图片添加的水印文字
     * @param $TextColor 水印文字的字体颜色
     * @param $markPos   图片水印添加的位置，取值范围：0~9
     *                    0：随机位置，在1~8之间随机选取一个位置
     *                    1：顶部居左 2：顶部居中 3：顶部居右 4：左边居中
     *                    5：图片中心 6：右边居中 7：底部居左 8：底部居中 9：底部居右
     * @param $fontType  具体的字体库，可带相对目录地址
     * @param $markType  图片添加水印的方式，img代表以图片方式，text代表以文字方式添加水印
     */
    function setWater($imgSrc, $markImg, $markText, $TextColor, $markPos, $fontType, $markType) {
        $srcInfo = @getimagesize($imgSrc);
        $srcImg_w  = $srcInfo[0];
        $srcImg_h  = $srcInfo[1];
        switch ($srcInfo[2]) {
            case 1:
                $srcim =imagecreatefromgif($imgSrc);
                break;
            case 2:
                $srcim =imagecreatefromjpeg($imgSrc);
                break;
            case 3:
                $srcim =imagecreatefrompng($imgSrc);
                break;
            default:
                exit;
        }
        if(!strcmp($markType,"img")) {
            if(!file_exists($markImg) || empty($markImg)) {
                return;
            }
            $markImgInfo = @getimagesize($markImg);
            $markImg_w  = $markImgInfo[0];
            $markImg_h  = $markImgInfo[1];
            if($srcImg_w < $markImg_w || $srcImg_h < $markImg_h) {
                return;
            }
            switch ($markImgInfo[2]) {
                case 1:
                    $markim =imagecreatefromgif($markImg);
                    break;
                case 2:
                    $markim =imagecreatefromjpeg($markImg);
                    break;
                case 3:
                    $markim =imagecreatefrompng($markImg);
                    break;
                default:
                    return;
            }
            $logow = $markImg_w;
            $logoh = $markImg_h;
        }
        if(!strcmp($markType,"text")) {
            $fontSize = 16;
            if(!empty($markText)) {
                if(!file_exists($fontType)) {
                    return;
                }
            } else {
                return;
            }
            $box = @imagettfbbox($fontSize, 0, $fontType,$markText);
            $logow = max($box[2], $box[4]) - min($box[0], $box[6]);
            $logoh = max($box[1], $box[3]) - min($box[5], $box[7]);
        }
        if($markPos == 0) {
            $markPos = rand(1, 9);
        }
        switch($markPos) {
            case 1:
                $x = +5;
                $y = +5;
                break;
            case 2:
                $x = ($srcImg_w - $logow) / 2;
                $y = +5;
                break;
            case 3:
                $x = $srcImg_w - $logow - 5;
                $y = +15;
                break;
            case 4:
                $x = +5;
                $y = ($srcImg_h - $logoh) / 2;
                break;
            case 5:
                $x = ($srcImg_w - $logow) / 2;
                $y = ($srcImg_h - $logoh) / 2;
                break;
            case 6:
                $x = $srcImg_w - $logow - 5;
                $y = ($srcImg_h - $logoh) / 2;
                break;
            case 7:
                $x = +5;
                $y = $srcImg_h - $logoh - 5;
                break;
            case 8:
                $x = ($srcImg_w - $logow) / 2;
                $y = $srcImg_h - $logoh - 5;
                break;
            case 9:
                $x = $srcImg_w - $logow - 5;
                $y = $srcImg_h - $logoh -5;
                break;
            default:
                exit;
        }
        $dst_img = @imagecreatetruecolor($srcImg_w, $srcImg_h);
        imagecopy ( $dst_img, $srcim, 0, 0, 0, 0, $srcImg_w, $srcImg_h);
        if(!strcmp($markType,"img")) {
            imagecopy($dst_img, $markim, $x, $y, 0, 0, $logow, $logoh);
            imagedestroy($markim);
        }
        if(!strcmp($markType,"text")) {
            $rgb = explode(',', $TextColor);
            $color = imagecolorallocate($dst_img, $rgb[0], $rgb[1], $rgb[2]);
            imagettftext($dst_img, $fontSize, 0, $x, $y, $color, $fontType,$markText);
        }
        switch ($srcInfo[2]) {
            case 1:
                imagegif($dst_img, $imgSrc);
                break;
            case 2:
                imagejpeg($dst_img, $imgSrc);
                break;
            case 3:
                imagepng($dst_img, $imgSrc);
                break;
            default:
                return;
        }
        imagedestroy($dst_img);
        imagedestroy($srcim);
    }

    public function getPathByDisks($disks) {
        return config("filesystems.disks.".$disks.".root");
    }

}