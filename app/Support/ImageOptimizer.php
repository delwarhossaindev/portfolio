<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Downscales and re-encodes uploaded images before they hit the public disk,
 * so a 5 MB phone photo doesn't end up on the homepage.
 */
class ImageOptimizer
{
    /**
     * Store the upload in $folder on the public disk, at most $maxDim px on
     * its longest side. PNGs keep transparency; everything else becomes JPEG.
     * Falls back to storing the original file if GD can't read it.
     *
     * @return string Path relative to the public disk.
     */
    public static function store(UploadedFile $file, string $folder, int $maxDim = 1600, int $quality = 85): string
    {
        if (! function_exists('imagecreatefromstring')) {
            return $file->store($folder, 'public');
        }

        $tmpPath = null;

        try {
            $img = @imagecreatefromstring((string) file_get_contents($file->getRealPath()));
            if (! $img) {
                return $file->store($folder, 'public');
            }

            $isPng = $file->getMimeType() === 'image/png';
            $srcW = imagesx($img);
            $srcH = imagesy($img);

            if ($srcW > $maxDim || $srcH > $maxDim) {
                $scale = $maxDim / max($srcW, $srcH);
                $dstW = (int) round($srcW * $scale);
                $dstH = (int) round($srcH * $scale);

                $dst = imagecreatetruecolor($dstW, $dstH);
                if ($isPng) {
                    imagealphablending($dst, false);
                    imagesavealpha($dst, true);
                }
                imagecopyresampled($dst, $img, 0, 0, 0, 0, $dstW, $dstH, $srcW, $srcH);
                imagedestroy($img);
                $img = $dst;
            }

            $tmpPath = tempnam(sys_get_temp_dir(), 'img_');
            if ($isPng) {
                imagesavealpha($img, true);
                imagepng($img, $tmpPath, 8);
                $extension = 'png';
            } else {
                imageinterlace($img, true); // progressive JPEG: renders sooner on slow connections
                imagejpeg($img, $tmpPath, $quality);
                $extension = 'jpg';
            }
            imagedestroy($img);

            $path = $folder . '/' . Str::random(40) . '.' . $extension;
            Storage::disk('public')->put($path, (string) file_get_contents($tmpPath));

            return $path;
        } catch (\Throwable $e) {
            Log::warning('Image optimization failed, storing original', ['error' => $e->getMessage()]);

            return $file->store($folder, 'public');
        } finally {
            if ($tmpPath && is_file($tmpPath)) {
                @unlink($tmpPath);
            }
        }
    }
}
