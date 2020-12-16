<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'chest_id',
        'file_path',
    ];

    protected $table = 'files';

    /**
     * @return mixed
     */
    function getFilePath(): string {
        return $this->file_path;
    }

    /**
     * @param $filePath
     */
    function setFilePath(string $filePath) {
        $this->file_path = $filePath;
    }

    static function hasPermission(string $ip, string $fileName): bool {
        $chest = Chest::getChestByIpAddress($ip);
        if(is_null($chest)) {
           return false;
        } else {
            return File::query()->where('chest_id', '=', $chest->getId())
                ->where('file_path', '=', $fileName)->exists();
        }
    }
}
