<?php
const LOGIN_URL = "/pages/auth/login.php";
const BOOK_INDEX_URL = "/pages/books/index.php";
const FORBIDEN_URL = "/pages/error/403.php";


//mengecek apakah sebuah session sudah di mulai atau belom, jika belom maka session akan dimuali
function sessionStart() 
{
    if (session_status() == PHP_SESSION_NONE) 
    {
        session_start();
    }

}

//mengecek apakah seorang pengguna sudah login atau belo
function isLoggedIn ()
{
    session_start();
    $isLoggedIn = isset($_SESSION["user"]);
    return $isLoggedIn;
}

//mendapatkan data pengguna yang sudah login
function getAuthUser ()
{
    session_start();
    $user = $_SESSION["user"] ?? null;
    return $user;
}
//mengecek apakah role pengguna sesuai atau tidak
function hasRole(array $roles)
{
    $user = getAuthUser();
    $isUserHasAuthorizeRole = $user !== null & in_array($user["role"], $roles);
    return $isUserHasAuthorizeRole;
}

//menghandle pengguna yang belom login
function requiredAuth()
{
    if(!isLoggedIn()){
        $_SESSION['errors'] = [
            'login'=> 'Sihlakan Login terlebih dahulu sebelum mengakses halaman ini',
        ];
        header('Location : ' . LOGIN_URL);
        exit();
    }

}


//menghandle pengguna yang tidak memiliki role yang sesuai atau tidak ter autorisasi
function requiredRole(array $roles){
    requiredAuth();
    if(!hasRole('roles')){
        header('Location :'. FORBIDEN_URL);
        exit();
    }
}
//Menghandle pengguna yang sudah logins ebeleumnya
function requireGuest(){
    if(isLoggedIn()){
       header('Location :'. BOOK_INDEX_URL);
       exit();
    }

}
?>