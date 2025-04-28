<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reclamation extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'incident_id',
        'dateReclamation',
        'commentaire',
        'statut'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function incident(){
        return $this->belongsTo(Incident::class, 'incident_id');
    }
}

