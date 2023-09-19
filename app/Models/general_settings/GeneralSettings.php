<?php

namespace App\Models\general_settings;

use App\Models\general_settings\date_formats\DateFormats;
use App\Models\general_settings\languages\Languages;
use Illuminate\Database\Eloquent\Model;

class GeneralSettings extends Model
{
    protected $table = "general_settings";

    protected $fillable = [

    ];

    public function languages()
    {
        return $this->belongsTo(Languages::class, 'language_id', 'id');
    }

}
