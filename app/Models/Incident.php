<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;
    protected $fillable = [
        'incident_name',
        'id_category',
        'id_user',
        'detail',
        'autrePrecisions',
        'photo',
        'prefecture',
        'adresse',
        'date',
        'longitude',
        'latitude',
    ];

    public function category(){
        return $this->belongsTo(Categorie::class, 'id_category');
    }
    public function user(){
        return $this->belongsTo(User::class, 'id_user');
    }
}
