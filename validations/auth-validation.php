<?php
require_once __DIR__ ."/../repositories/user-repository.php";
function getRegisterRequest ($request) 
{
    return [
    'name'=>trim(htmlspecialchars($request['name'])),
    'email'=> trim($request['email']),
    'password'=> $request['password'],
    'password_confirmation'=> $request['password_confirmation'],
    ];

}
function validateRegister ($request)
{
    $errors = [];
    //validate name
    if ($request['name'] == '') {
        $errors['name'] = 'Nama lengkap wajib diisi';
    }elseif(mb_strlen($request['name']) < 150) {
        $errors['name'] = 'Nama lengkap tidak boleh lebih dari 150 Karakter';
    }
    //validate email
    if ($request['email'] == '') {
        $errors['email'] = 'Email wajib diisi';
    }elseif(mb_strlen($request['email']) < 150) {
        $errors['email'] = 'Email tidak boleh lebih dari 150 Karakter';
    }elseif(!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email yang dikirimkan tidak valid';
    }elseif(isEmailTaken($request['email'])) {
        $errors['email'] = "Email sudah didaftarkan sebelumnya";
    }

    //validate password
    if ($request['password'] == '') {
        $errors['password'] = 'Kata sandi wajib diisi';
    }elseif(mb_strlen($request['email']) < 8) {
        $errors['password'] = 'Kata sandi tidak boleh kurang dari dari 8 Karakter';
    }
    //validate password confirmation
        if ($request['password_confirmation'] == '') {
        $errors['password_confirmation'] = 'Kata sandi wajib diisi';
    }elseif(mb_strlen($request['email']) < 8) {
        $errors['password_confirmation'] = 'Kata sandi tidak boleh kurang dari dari 8 Karakter';
    }elseif($request['password'] != $request['password_confirmation']) {
        $errors['password_confirmation'] = 'Kata sandi yang dimasukkan tidak cocok';
    }
    
    return $errors;
}

function getLoginRequest($request)
{
    return [
        'email' => $request['email'],
        'password'=> $request['password'],
    ];
}
function validateLogin($request)
{   
    $errors = [];
    if($request['email'] == '') {
       $error['email'] = 'Email wajib diisi';
    }
    if($request['password'] == '') {
        $errors['password'] = 'Password wajib diisi';
    }

return $errors;
}
?>