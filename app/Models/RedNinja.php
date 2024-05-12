<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\League;
use App\Models\Tip;

class RedNinja extends Model
{
    use HasFactory;

    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = ['league_id', 'fixtures', 'tip_id', 'results'];

    protected $casts = ['results' => 'boolean'];

    public function league() {
        return $this->belongsTo(League::class);
    }

    public function tip() {
        return $this->belongsTo(Tip::class);
    }
}
