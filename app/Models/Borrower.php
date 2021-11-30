<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Borrower extends Model
{
    use HasFactory, SoftDeletes;

    public function agreementDetails() {
        return $this->belongsTo('App\Models\Agreement', 'agreement_id', 'id');
    }

    public function borrowerAgreementRfq()
    {
        return $this->hasOne('App\Models\AgreementRfq', 'borrower_id', 'id');
    }
}
