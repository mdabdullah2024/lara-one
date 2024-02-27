<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingsModel extends Model
{
    use HasFactory;
    protected $table = 'settings';

    static public function getSingle()
    {
        return self::find(1);
    }

    public function getLogo()
    {
        if (!empty($this->logo_file)&& file_exists('public/upload/setting/'.$this->logo_file)) {
            return url('public/upload/setting/'.$this->logo_file);
        }else{
            return url('public/upload/no_image.png');
        }
    }

    public function Fevicon()
    {
        if (!empty($this->fevicon_file)&& file_exists('public/upload/setting/'.$this->fevicon_file)) {
            return url('public/upload/setting/'.$this->fevicon_file);
        }else{
            return url('public/upload/no_image.png');
        }
    }

}
