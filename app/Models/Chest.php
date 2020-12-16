<?php

namespace App\Models;

use App\Http\Controllers\ChestController;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\File;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    ];
    protected $with = ['files'];

    protected $table = 'chests';

    /**
     * @param string $ipAddress
     */
    public function setIpAddress(string $ipAddress) {
        $this->ip_address = $ipAddress;
    }

    /**
     * @param ?string $text
     */
    public function setText(?string $text) {
        $this->text = $text;
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
        return $this->ip_address;
    }

    public static function getChestByIpAddress(string $ipAddress): ?Chest {
        $chest = Chest::query()->where('ip_address', '=', $ipAddress)->get()->first();
        /*if(is_null($chest)) {
            $chest = Chest::query()->create(['ip_address'=>$ipAddress]);
        }*/
        return $chest;
    }

    public function getId() {
        return $this->id;
    }

    /**
     * @return Collection
     */
    public function files(): HasMany {
        return $this->hasMany(File::class);
    }
}
