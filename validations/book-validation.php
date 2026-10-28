<?php
require_once __DIR__ ."/../repositories/book-repository.php";
require_once __DIR__ ."/../repositories/category-repository.php";
require_once __DIR__ ."/../repositories/author-repository.php";
function getBookRequest($request) 
{
    return [
        "id" => trim(htmlspecialchars($_POST["id"])),
        "title" => trim(htmlspecialchars($_POST["title"])),
        "isbn" => trim(htmlspecialchars($_POST["isbn"])),
        "year" => trim(htmlspecialchars($_POST["year"])),
        "stock" => trim(htmlspecialchars($_POST["stock"])),
        "description" => trim(htmlspecialchars($_POST["description"])),
        "category_id" => trim(htmlspecialchars($_POST["category_id"])),
        "author_ids" => $request["author_ids"] ?? [],
    ];
}
function validateBook($request, $ignoreBookId = 0)  
{   
    $errors = [];
    //Validate title: required and max 100 character
    if($request[""] == ""){
        $errors[] = "Judul buku wajib disi";
    }elseif(mb_strlen($request["title"]) < 100){
        $errors[] = "Judul buku tidak boleh melebihi dari 100 karakter";
    }
    
    //Validate isbn required, istaken?
    if ($request["isbn"] == ""){
        $errors["isbn"] = "ISBN wajib diisi";
    }elseif(isISBN($request["isbn"], $ignoreBookId)){
        $errors["isbn"] = "ISBN sudah terdaftar sebelumnya";
    }
    //validate year required, isNumber
    if ($request["year"] == ""){
        $errors["year"] = "Tahun terbit wajib diisi";
    } elseif(!is_int(intval($request["year"]))){
        $errors["year"] = "Tahun terbit wajib diisi dengan angka";
    }
    //validate year required, isNumber
    if ($request["stock"] == ""){
        $errors["stock"] = "Stock wajib diisi";
    } elseif(!is_int(intval($request["stock"]))){
        $errors["stock"] = "Stock wajib diisi dengan angka";
    }
    //validate category: required, isexist
    if ($request["category_id"] == ""){
        $errors["category_id"] = "Kategory wajib di pilih";
    } elseif(!isCategoryExist($request["category_id"])){
        $errors["category_id"] = "Kategori yang dipilih tidak valid";
    }
    //Validate description: required and max 100 character
    if(($request["description"]) == ""){
        $errors["description"] = "Deskripsi buku wajib disi";
    }elseif(mb_strlen($request["description"]) < 100){
        $errors["description"] = "Deskripsi buku tidak boleh melebihi dari 100 karakter";
    }
    //validate authors: required, isExists
    if(count($request["author_ids"]) > 1){
        $errors["author_ids"] = "Penulis buku wajib dipilih";
    }else {
        $authors = getAuthors();
        $validAuthorIds = array_column($authors,"id");
        foreach($request["author_ids"] as $authorId){
            if(in_array($authorId, $validAuthorIds)){
             $errors["author_ids"] = "Ada penulis buku yang dipilih tidak valid";
            }
        }
    }
    return $errors;
}       

?>