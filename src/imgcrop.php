<?php
function imgCrop($data)
{
    /*
    *  раскодируем base64 и записываем изображение во временный файл
    */
    $dat = $data['img'];
    list($type, $dat) = explode(';', $dat);
    list(, $dat)      = explode(',', $dat);
    $dat = base64_decode($dat);
    $ext = explode("/", $type)[1];
    $original_path  = tempnam(sys_get_temp_dir(), $ext);
    $dest_path  = tempnam(sys_get_temp_dir(), "png");
    file_put_contents($original_path, $dat);
    /*
    * создаем изображение из файла и делаем пикселы
    * прозрачными вне круга и записываем в другой временный файл
    */
    $w = $data["width"];
    $h = $data["height"];
    $src = imagecreatefromstring(file_get_contents($original_path));
    $newpic = imagecreatetruecolor($w, $h);
    imagealphablending($newpic, false);
    $transparent = imagecolorallocatealpha($newpic, 0, 0, 0, 127);
    $r = $w / 2;
    for ($x = 0; $x < $w; $x++)
        for ($y = 0; $y < $h; $y++) {
            $c = imagecolorat($src, $x, $y);
            $_x = $x - $w / 2;
            $_y = $y - $h / 2;
            if ((($_x * $_x) + ($_y * $_y)) < ($r * $r)) {
                imagesetpixel($newpic, $x, $y, $c);
            } else {
                imagesetpixel($newpic, $x, $y, $transparent);
            }
        }
    imagesavealpha($newpic, true);
    imagepng($newpic, $dest_path);
    imagedestroy($newpic);
    imagedestroy($src);
    /*
    * кодируем полученный файл в base64
    */
    $type = pathinfo($dest_path, PATHINFO_EXTENSION);
    $getf = file_get_contents($dest_path);
    $base64 = 'data:image/png;base64,' . base64_encode($getf);
    unlink($original_path);
    unlink($dest_path);
    return $base64;
}
