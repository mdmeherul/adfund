<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    use Notifiable;


    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'phone_number',
        'profile',
        'lang',
        'subscription',
        'subscription_expire_date',
        'parent_id',
        'is_active',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function totalUser()
    {
        return User::whereNotIn('type',['customer','agent'])->where('parent_id', $this->id)->count();
    }
    public function totalCustomer()
    {
        return User::where('type','customer')->where('parent_id', $this->id)->count();
    }
    public function totalAgent()
    {
        return User::where('type','agent')->where('parent_id', $this->id)->count();
    }

    public function totalContact()
    {
        return Contact::where('parent_id', '=', parentId())->count();
    }

    public function roleWiseUserCount($role)
    {
        return User::where('type', $role)->where('parent_id',parentId())->count();
    }
    public static function getDevice($user)
    {
        $mobileType = '/(?:phone|windows\s+phone|ipod|blackberry|(?:android|bb\d+|meego|silk|googlebot) .+? mobile|palm|windows\s+ce|opera mini|avantgo|mobilesafari|docomo)/i';
        $tabletType = '/(?:ipad|playbook|(?:android|bb\d+|meego|silk)(?! .+? mobile))/i';
        if(preg_match_all($mobileType, $user))
        {
            return 'mobile';
        }
        else
        {
            if(preg_match_all($tabletType, $user)) {
                return 'tablet';
            } else {
                return 'desktop';
            }

        }
    }



    public function subscriptions()
    {
        return $this->hasOne('App\Models\Subscription','id','subscription');
    }



    public static $systemModules=[
        'user',
        'customer',
        'agent',
        'policy',
        'insurance',
        'insured detail',
        'nominee',
        'claim',
        'document',
        'payment',
        'tax',
        'contact',
        'note',
        'logged history',
        'settings',
    ];

    public function customer()
    {
        return $this->hasOne('App\Models\Customer','user_id','id');
    }
    public function agent()
    {
        return $this->hasOne('App\Models\Agent','user_id','id');
    }
}
