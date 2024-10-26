<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    use HasFactory;
    protected $fillable=[
        'claim_id',
        'customer',
        'insurance',
        'date',
        'status',
        'reason',
        'notes',
        'parent_id',
    ];

    public static $status=[
        'submitted'=>'Submitted',
        'acknowledged'=>'Acknowledged',
        'under_review'=>'Under Review',
        'approved'=>'Approved',
        'rejected'=>'Rejected',
        'closed'=>'Closed',
    ];

    public function customers()
    {
        return $this->hasOne('App\Models\User', 'id', 'customer');
    }
    public function insurances()
    {
        return $this->hasOne('App\Models\Insurance', 'id', 'insurance');
    }

    public function documents()
    {
        return $this->hasMany('App\Models\ClaimDocument', 'claim', 'id');
    }
}
