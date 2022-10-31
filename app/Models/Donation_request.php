<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation_request extends Model 
{

    protected $table = 'donation_requests';
    public $timestamps = true;
    protected $fillable = array('patient_name', 'patient_phone', 'patient_age', 'city_id', 'hospital_name', 'hospital_address', 'blood_type_id', 'bags_num', 'details', 'client_id', 'longitude', 'latitude');

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function notifications()
    {
        return $this->hasOne('App\Models\Notification');
    }

    public function cities()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function BloodTypes()
    {
        return $this->belongsTo('App\Models\BloodType');
    }

}