<?php
require_once __DIR__ . "/../../config/database;.php";

if (isset($_POST['update']) && $_SERVER['REQUEST_METHOD'] === "POST") {
try{
    $id = $_POST['id'];
    $title = $_POST['title'];
    $isbn = $_POST['isbn'];
    $year = $_POST['year'];
    $stock = $_POST['stock'];
    $categoryId = $_POST['category_id'];
    $description = $_POST['description'];
    
    $query = "update books set title = :title, isbn = :isbn,
            year = :year, stock = :stock, category_id = :category_id,
            description = :description where id = :id";
    $stmt = $pdo->prepare($query);            
    $stmt->execute([
        "title" => $title,
        "isbn" => $isbn,
        "year" => $year,
        "stock" => $stock,
        "category_id" => $categoryId,
        "description" => $description,
        "id" => $id
    ]);
    $query = "delete from book_author where book_id = :book_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        "book_id" => $id
    ]);
    $query = "insert into book_author (book_id, author_id) 
                values (:book_id, :author_id)
                ";
    $stmt = $pdo->prepare($query);
    $authorIds = isset($_POST['author_ids']) ? $_POST['author_ids'] : [];
    foreach ($authorIds as $authorId) {
        $stmt->execute([
        "book_id" => $id,
        "author_id" => htmlspecialchars($authorId)
        ]);
    }
    $pdo->commit();
    header("Location: ../../pages/books/index.php");
    exit;
}catch (PDOException $e){
        $pdo->rollBack();
        throw $e;
}
}
?>
