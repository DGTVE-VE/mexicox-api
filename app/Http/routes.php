<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

Route::get('/', function () {
    return view('welcome');
});

Route::post('v1/suscribe', function () {
    try {
        JWTAuth::parseToken()->authenticate();
        $data = Illuminate\Support\Facades\Input::get('data');        
        $base64 = base64_decode ($data);
        $key = env('ENC_KEY');
        
        $json = openssl_decrypt($base64,"AES-256-ECB",$key);  
        $rawUserData = json_decode($json, true);
        $newUser = new \App\Model\Auth_user();
        
        $newUser->username  = $rawUserData['sobrenombre'];
        $newUser->email     = $rawUserData['email'];
        $newUser->password   = $rawUserData['password'];
        $newUser->first_name= $rawUserData['nombre'];
        $newUser->last_name = $rawUserData['apellidos'];
        $newUser->is_active = 1;
        $newUser->date_joined = date('Y-m-d H:i:s');
        
        $newUser->save();
        
        $profile = new App\Model\Auth_userprofile;
        $profile->name = $rawUserData['nombre'] . ' ' . $rawUserData['apellidos'];
        $profile->gender = $rawUserData['genero'];
        $profile->year_of_birth = $rawUserData['anioNacimiento'];
        $profile->level_of_education = $rawUserData['nivelEstudios'];
        $profile->country = $rawUserData['pais'];
        $profile->city = $rawUserData['estado'];
        $profile->mailing_address = $rawUserData['codigoPostal'];
        
        $profile->courseware = 'course.xml';
        $profile->allow_certificate = 1;
        $profile->meta = '{"session_id": null}';
        $profile->goals = '';
        
        $newUser->profile()->save($profile);
        
        return response('Usuario registrado', 201);
    } catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
});
Route::get('phpinfo', function () {
    phpinfo(); 
});
Route::get('decrypt', function () {
   $data = '68H5y5qsB+1HuAZnucmC+Zc1sGoT2GGQTsWHVJ6wd+jSuV1p1YG4RBBesDt6OHB+BGb4NgP3k/Lk
bGxnJ2lHig+3pcTdJ5M8Zph6Kg5fDjwcDqWLuRSYQ0tPxgrdZIrCensWzqgjcdi4JJ8kHsruLCnY
mAPbsautRmFfLRWK+qnp0On7CuMfco0+dx9iOt5EuZhcULrwZgTrKHyadhI1uX47w5wHxyx5P7vZ
I/QCJH4RYUiHXKX9C8kE0zu6ENBtJVKiLHuop5SO+qHB6m0mMZV+7efzUzWIKFZ4wX+Q5cTap8/i
3l+g3ga2t9lGxLzhn2fhaknuuJQ3cu7k3p2GBuxdTzrsTULGybcYAaXZwMh1tSkw5rzhCD3YMBeA
GR4OE8tIrWthZ07b3BcN1Y6vX8DE5/DUJhv/PitwL8hitW2euMiXDAwwlUBfcWVM1AKXOykOnugQ
FbEtYxYVd4q1RJqH415j884Z+ttkBQl5itQ=';
   $user = openssl_decrypt($data,"AES-256-ECB","sjmTvKPJmA6f5o1HalCvoEUB9p4BSjRu");
   var_dump ($user);
   print openssl_error_string ( );
});

Route::get('v1/test', function () {
    try {
        JWTAuth::parseToken()->authenticate();
        $payload = JWTAuth::parseToken()->getPayload();
        var_dump($payload);
    } catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
});
