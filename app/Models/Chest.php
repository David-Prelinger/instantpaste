<?php

namespace App\Models;

use App\Http\Controllers\ChestController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ip_address',
        'text',
        'file_path'
    ];

    protected $table = 'chests';

    /**
     * @param string $ipAddress
     */
    public function setIpAddress(string $ipAddress) {
        $this->ip_address = $ipAddress;
    }

    /**
     * @param string $text
     */
    public function setText(string $text) {
        $this->text = $text;
    }

    /**
     * @param string $filePath
     */
    public function setFilePath(string $filePath) {
       $this->file_path = $filePath;
    }

    /**
     * @return string|null
     */
    public function getFilePath(): ?string {
        return $this->file_path;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getIpAddress(): string {
        return $this->ip_adress;
    }

    public static function getChestByIpAddress(string $ipAddress) {
        $chest = Chest::query()->where('ip_address', '=', $ipAddress)->get()->first();
        if(is_null($chest)) {
            $chest = Chest::query()->create(['ip_address'=>$ipAddress]);
        }
        return $chest;
    }

    public function getId() {
        return $this->id;
    }
}
