<?php

require_once "book.php";
$bookObj = new Book();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["id"])) {
        $upd = trim(htmlspecialchars($_GET["id"]));
        
        $books = $bookObj->viewBook();
        $bookFound = false;
        foreach ($books as $book) {
            if ($book["id"] == $upd) {
                $bookFound = true;
                break;
            }
        }
        if (!$bookFound) {
            echo "<a href='viewbook.php'>View Book</a>";
            exit("Book not found");
        } else {
            $bookObj->deleteBook($upd);
            header("Location: viewbook.php");
            exit();
        }
    } else {
        echo "<a href='viewbook.php'>View Book</a>";
        exit("Book not found");
    }
}
