<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

    protected $table = 'clients';
    public $timestamps = true;
    protected $fillable = array('name', 'phone', 'email', 'password', 'date_of_birth', 'blood_type_id', 'last_donation_date', 'gender','city_id', 'pin_code','api_token');

    public function setPasswordAttribute($value){
        $this->attributes['password']=bcrypt($value);

    }
    public function BloodType()
    {
        return $this->belongsTo('App\Models\BloodType');
    }

    public function cities()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function DonationRequests()
    {
        return $this->hasMany('App\Models\Donation_request');
    }
    public function tokens()
    {
        return $this->hasMany('App\Models\Token','client_id','id');
    }

    public function bloodTypes()
    {
        return $this->belongsToMany('App\Models\BloodType');
    }

    public function notifications()
    {
        return $this->belongsToMany('App\Models\Notification');
    }

    public function posts()
    {
        return $this->belongsToMany('App\Models\Post');
    }

    public function governorates()
    {
        return $this->belongsToMany('App\Models\Governorate');
    }

    protected $hidden =[
        'password','api_token'
    ];

}
