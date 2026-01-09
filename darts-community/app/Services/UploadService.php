<?php

namespace App\Services;

use App\Models\Player;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadService
{
    /**
     * Image dimensions for resizing.
     */
    private const PROFILE_PHOTO_SIZE = 400;
    private const COVER_PHOTO_WIDTH = 1200;
    private const COVER_PHOTO_HEIGHT = 400;

    /**
     * Upload and process a profile photo.
     */
    public function uploadProfilePhoto(Player $player, UploadedFile $file): string
    {
        // Delete old photo if exists
        $this->deletePhoto($player->profile_photo_path);

        // Resize and store the file
        $path = $this->resizeAndStore(
            $file,
            'avatars',
            self::PROFILE_PHOTO_SIZE,
            self::PROFILE_PHOTO_SIZE
        );

        // Update player
        $player->update(['profile_photo_path' => $path]);

        return $path;
    }

    /**
     * Upload and process a cover photo.
     */
    public function uploadCoverPhoto(Player $player, UploadedFile $file): string
    {
        // Delete old photo if exists
        $this->deletePhoto($player->cover_photo_path);

        // Resize and store the file
        $path = $this->resizeAndStore(
            $file,
            'covers',
            self::COVER_PHOTO_WIDTH,
            self::COVER_PHOTO_HEIGHT
        );

        // Update player
        $player->update(['cover_photo_path' => $path]);

        return $path;
    }

    /**
     * Resize image and store it.
     */
    protected function resizeAndStore(UploadedFile $file, string $directory, int $width, int $height): string
    {
        $image = imagecreatefromstring(file_get_contents($file->getPathname()));

        if ($image === false) {
            // Fallback: store without resizing if image creation fails
            return $file->store($directory, 'public');
        }

        $originalWidth = imagesx($image);
        $originalHeight = imagesy($image);

        // Create resized image with cover behavior (crop to fill)
        $resized = imagecreatetruecolor($width, $height);

        // Preserve transparency for PNG
        imagealphablending($resized, false);
        imagesavealpha($resized, true);
        $transparent = imagecolorallocatealpha($resized, 0, 0, 0, 127);
        imagefill($resized, 0, 0, $transparent);
        imagealphablending($resized, true);

        // Calculate crop dimensions (cover behavior)
        $ratio = max($width / $originalWidth, $height / $originalHeight);
        $srcWidth = (int) ($width / $ratio);
        $srcHeight = (int) ($height / $ratio);
        $srcX = (int) (($originalWidth - $srcWidth) / 2);
        $srcY = (int) (($originalHeight - $srcHeight) / 2);

        imagecopyresampled(
            $resized,
            $image,
            0, 0,
            $srcX, $srcY,
            $width, $height,
            $srcWidth, $srcHeight
        );

        // Generate filename and path
        $filename = Str::uuid() . '.jpg';
        $path = $directory . '/' . $filename;
        $fullPath = Storage::disk('public')->path($path);

        // Ensure directory exists
        $dir = dirname($fullPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        // Save as JPEG with quality 85
        imagejpeg($resized, $fullPath, 85);

        // Clean up
        imagedestroy($image);
        imagedestroy($resized);

        return $path;
    }

    /**
     * Delete a profile photo.
     */
    public function deleteProfilePhoto(Player $player): void
    {
        $this->deletePhoto($player->profile_photo_path);
        $player->update(['profile_photo_path' => null]);
    }

    /**
     * Delete a cover photo.
     */
    public function deleteCoverPhoto(Player $player): void
    {
        $this->deletePhoto($player->cover_photo_path);
        $player->update(['cover_photo_path' => null]);
    }

    /**
     * Delete a photo from storage.
     */
    protected function deletePhoto(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
