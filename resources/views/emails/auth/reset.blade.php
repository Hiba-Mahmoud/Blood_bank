@component('mail::message')
# Introduction

Reset password
@component('mail::button', ['url' => ''])
Button Text
@endcomponent
<p>your reset code is : {{$code}}</p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent

{{-- <h3>Welcome <bold> {{$name}} </bold></h3>
<br>
<h2>This is Your Code to reset your password</h2>
<br>
<h2 style="color: red">{{$code}}</h2>
<br>
<h3><bold>Thank you.</bold></h3> --}}
