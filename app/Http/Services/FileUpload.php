<?php


namespace App\Http\Services;

class FileUpload
{
    public static function upload($file, $path, $name)
    {
        $path = trim($path, '\/') . '/';
        $name = trim($name, '\/') . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
        if (!is_dir($path)) {
            if (!mkdir($path, 0777, true)) {
                die('directory not created');
            }
        }
        is_writable($path);
        if (is_uploaded_file($file['tmp_name'])) {
            if (move_uploaded_file($file['tmp_name'], $path . $name)) {
                return '/' . $path . $name;
            }
        }

        error('file', 'failed to upload file');
        return back();
    }
}
