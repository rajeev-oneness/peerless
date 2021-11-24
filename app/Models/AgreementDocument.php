<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AgreementDocument extends Model
{
    use HasFactory, SoftDeletes;

    public function siblingsDocuments()
    {
        return $this->hasMany('App\Models\AgreementDocument', 'parent_id', 'id');
    }
}
