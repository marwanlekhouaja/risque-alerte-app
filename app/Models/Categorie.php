<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;
    protected $fillable = [
        'nomCategorie',
    ];

    public function incidents()
    {
        return $this->hasMany(Incident::class, 'id_category');
    }
}
