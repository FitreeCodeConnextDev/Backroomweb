<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

if (!function_exists('upload_product_bmp')) {

    function upload_product_bmp(
        UploadedFile $file,
        string $fileName,
        string $directory = 'product',
        int $maxSize = 500
    ): void {

        $relativePath = $directory . '/' . $fileName;
        $fullPath = storage_path('app/public/' . $relativePath);

        // ลบไฟล์เก่า
        if (Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }

        // โหลดรูปด้วย GD
        switch ($file->getMimeType()) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($file->getPathname());
                break;

            case 'image/png':
                $image = imagecreatefrompng($file->getPathname());
                break;

            default:
                throw new Exception(__('product.product_img_invalid'));
        }

        if (!$image) {
            throw new Exception(__('product.product_img_read_error'));
        }

        // Resize
        $width  = imagesx($image);
        $height = imagesy($image);

        if ($width > $maxSize || $height > $maxSize) {

            $ratio = min($maxSize / $width, $maxSize / $height);
            $newW = (int) ($width * $ratio);
            $newH = (int) ($height * $ratio);

            $resized = imagecreatetruecolor($newW, $newH);

            // พื้นหลังขาว (กัน PNG โปร่งใส)
            $white = imagecolorallocate($resized, 255, 255, 255);
            imagefill($resized, 0, 0, $white);

            imagecopyresampled(
                $resized,
                $image,
                0,
                0,
                0,
                0,
                $newW,
                $newH,
                $width,
                $height
            );

            imagedestroy($image);
            $image = $resized;
        }

        // สร้างโฟลเดอร์
        if (!file_exists(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0755, true);
        }

        // บันทึกเป็น BMP
        imagebmp($image, $fullPath);
        imagedestroy($image);
    }
}
