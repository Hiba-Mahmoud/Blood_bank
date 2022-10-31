<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\City;
use App\Models\Client;
use App\Models\Contact;

use App\Mail\ResetPassword;
use App\Models\Governorate;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Token;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
// use Validator;


class AuthController extends Controller
{
    private function apiResponse($status, $msg, $data)
    {

        $response = [
            'status' => $status,
            'message' => $msg,
            'data' => $data,

        ];

        return response()->json($response);
    }
    public function register(Request $request)
    {
        // dd($request);
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:50|regex:/(^([a-zA-Z]+)(\d+)?$)/u',
                'phone' => 'required|string|max:11|min:11|',
                'email' => 'required|string|unique:clients|email|string|max:50',
                'password' => 'required|string',
                'date_of_birth' => 'required',
                'governorate_id'=>'required',
                'last_donation_date' => 'required',
                'city_id' => 'required|numeric',
                'blood_type_id' => 'required|numeric',
                'gender'=>'required'

            ],
            [
                'name.required' => 'nmae is required',
                'name.string' => 'name isnot valid',
                'name.max' => 'name isnot valid',
                'name.regex' => 'name isnot valid',
                'phone.required' => 'phone is required',
                'phone.max' => 'phone is unvalid',
                'phone.min' => 'phone is unvalid',
                'email' => 'email is required'
            ]
        );


        if ($validator->fails()) {
            $errors = $validator->errors();
            return $this->apiResponse(0, 'error', $errors);
            // return $errors;
        };
        $client = Client::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' =>$request->phone,
            'gender' =>$request->gender,
            'city_id' =>$request->city_id,
            'date_of_birth'=>$request->date_of_birth,
            'last_donation_date'=>$request->last_donation_date,
            'blood_type_id'=>$request->blood_type_id,
            'password' => Hash::make($request->password),
            'api_token' =>  Str::random(40),
            'pin_code' =>  rand(1111, 9999),
        ]);
        $user =Client::where('phone',$request->phone)
                ->with('cities','BloodType','governorates')->get();
        // $request->merge(['password' => bcrypt($request->password)]);
        // $client = Client::create($request->all());
        // $client->api_token = Str::random(40);
        // $client->pin_code = rand(1111, 9999);
        // dd($client);
        // $client->save();
        $client->bloodTypes()->attach($request->blood_type_id);
        $client->governorates()->attach($request->governorate_id);
        return $this->apiResponse(1, 'success', [
            'api_token' => $client->api_token,
            'client' => $user
        ]);
    }








    //contactUs
    public function contactUs(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string',
                'email' => 'required|string',
                'phone' => 'required|string|min:11|max:11|regex:/^01[0125][0-9]{8}$/',
                'subject' => 'required|string',
                'message' => 'required|string',
            ],
            [
                'name.required' => 'name is required',
                'email.required' => 'name is required',
                'phone.required' => 'name is required',
                'subject.required' => 'name is required',
                'message.required' => 'name is required',
            ]
        );
        if ($validator->fails()) {
            $errors = $validator->errors();
            return $this->apiResponse(0, 'error', $errors);
            // return $errors;
        };

        $validator = Contact::create($request->all());
        $validator->save();
        return $this->apiResponse(1, 'success', $validator);
    }


    //login
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:11|min:11|regex:/^01[0125][0-9]{8}$/',
            'password' => 'required|string'
        ], [
            'phone.reuired' => 'phphone is required',
            'password.reuired' => 'password is required',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(0, 'error', $validator->errors());
        }


        $client = Client::where('phone', $request->phone)->first();
        if ($client) {
            if (Hash::check($request->password, $client->password)) {
                return $this->apiResponse(1, 'success', [
                    'api_token' => $client->makeVisible('api_token'),
                ]);
            } else {
                return $this->apiResponse(0, 'error', 'your password is uncorrect');
            }
        } else {
            return $this->apiResponse(0, 'error', 'do you have an account?if you dont please sign up');
        }
    }


    //reset password
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:11|min:11|regex:/^01[0125][0-9]{8}$/',
        ], [
            'phone.reuired' => 'phphone is required',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(0, 'error', $validator->errors());
        }

        $client = Client::where('phone', $request->phone)->first();
        if ($client) {

            $code = rand(1111, 9999);
            $update = $client->update(['pin_code' => $code]);
            if ($update) {
                Mail::to($client->email)
                    ->send(new ResetPassword($code));

                // Mail::send('emails.auth.reset', [$code], function($mail) use ($client){
                //     $mail->from('hello@example.com', "From for rent");
                //     $mail->to($client->email);
                //     $mail->subject('Reset password for your account');
                //});

                return $this->apiResponse(1, 'success', 'we send you a reset code pleaswe check you email');
            }
            else {
                return $this->apiResponse(0, 'error', 'please try again');
            }
        }
        else {
            return $this->apiResponse(0, 'error', 'do you have an account?if you dont please sign up');
        }
    }

    public function updatePasswod(Request $request){
        $validator = Validator::make($request->all(),[
            'pin_code'=>'required',
            'password'=>'required|string|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'password_confirmation'=>'required',
            'phone'=>'required'
        ],[
            'pin_code'=>'code is equired',
            'password.required'=>'password is equired',
            'password.confirmed'=>'password dosent match',
            'phone'=>'phone is equired',
        ]);

        if($validator->fails()){
            return $this->apiResponse(0,'error',$validator->errors());
        }

        $client = Client::where('phone',$request->phone)->first();
        $request->merge(['password' => bcrypt($request->password)]);

         $updatePasswod = $client->update(['pin_code'=>$request->pin_code]);

         if($updatePasswod){
             return $this->apiResponse(1,'success',$updatePasswod);
            }else{
             return $this->apiResponse(0,'error','please try again');
         }
    }


    //profile
    public function profile(){
        $client = Auth::user()->with('cities','bloodTypes','governorates')->get();
        return $this->apiResponse(1,'success',$client);
    }

    //update profile
    public function updateProfile(Request $request){

        $validator = Validator::make(
            $request->all(),
            [
                'name' => Rule::unique('clients')->ignore($request->user()->id),
                'phone' => Rule::unique('clients')->ignore($request->user()->id),
                'email' => Rule::unique('clients')->ignore($request->user()->id),
                'password' => 'confirmed',
                'date_of_birth' => Rule::unique('clients')->ignore($request->user()->id),
                'governorate_id'=>Rule::unique('clients')->ignore($request->user()->id),
                'last_donation_date' => Rule::unique('clients')->ignore($request->user()->id),
                'city_id' => Rule::unique('clients')->ignore($request->user()->id),
                'blood_type_id' => Rule::unique('clients')->ignore($request->user()->id),
                'gender'=>Rule::unique('clients')->ignore($request->user()->id)

            ],
            [
                'name.required' => 'nmae is required',
                'name.string' => 'name isnot valid',
                'name.max' => 'name isnot valid',
                'name.regex' => 'name isnot valid',
                'phone.required' => 'phone is required',
                'phone.max' => 'phone is unvalid',
                'phone.min' => 'phone is unvalid',
                'email' => 'email is required'
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors();
            return $this->apiResponse(0, 'error', $errors);
            // return $errors;
        };
        $user = auth()->user();
        $update = $user->update($request->all());

        return $this->apiResponse(1, 'success', $user);

    }

    public function notificationSettings(Request $request){
        $user = auth()->user();
        if($request->has('governorate_id')){
            $user->governorates()->detach($request->governorate_id);
            $user->governorates()->attach($request->governorate_id);

        }
        if($request->has('blood_type_id')){
            $user->bloodTypes()->detach($request->blood_type_id);
            $user->bloodTypes()->attach($request->blood_type_id);

        }
        return $this->apiResponse(1, 'success', $user);


    }

//registerToken

public function registerToken(Request $request){
    $validator = Validator::make($request->all(),[
        'token'=>'required',
        'type'=>'required|in:android,ios'
    ]);

    // dd($request);
    if($validator->fails()){
        $errors = $validator->errors();
        return $this->apiResponse(0,'error',$errors);

    }
    Token::where('token',$request->token)->delete();
    auth()->user()->tokens()->create($request->all());
    return $this->apiResponse(1,'success','success');
}

//remove token
 public function removeToken(Request $request)
{
    $validator= Validator::make($request->all(),[
        'token'=>'required'
    ]);

    if($validator->fails()){
        $errors = $validator->errors();
        return $this->apiResponse(0,'error',$errors);
    }
    Token::where('token',$request->token)->delete();
    return $this->apiResponse(1,'success','token has een deleted successfully');


}


}
