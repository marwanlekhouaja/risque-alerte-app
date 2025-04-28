<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'adresse',
        'telephone',
        'remember_token'
    ];

    public function reclamations(){
        return $this->hasMany(Reclamation::class, 'user_id');
    }

    public function incidents(){
        return $this->hasMany(Incident::class, 'id_user');
    }
}

