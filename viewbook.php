<?php

require_once "book.php";
$bookObj = new Book();

// Handle search and filter
$search = "";
$filter = "";
if (isset($_GET['search']) || isset($_GET['filter'])) {
    $search = isset($_GET['search']) ? trim($_GET['search']) : "";
    $filter = isset($_GET['filter']) ? trim($_GET['filter']) : "";
    $books = $bookObj->searchBooks($search, $filter);
} else {
    $books = $bookObj->viewBook();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Book</title>
    <link rel="stylesheet" href="viewbook.css">
    <style>
        body {
            background: #f4f7fa;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 700px;
            margin: 40px auto;
            background: #fff;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            padding: 20px 12px 12px 12px;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 16px;
            font-size: 1.2em;
        }
        form {
            display: flex;
            gap: 8px;
            margin-bottom: 16px;
        }
        input[type="text"], select {
            padding: 6px 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 1em;
        }
        input[type="text"] {
            flex: 1;
        }
        button[type="submit"] {
            padding: 6px 16px;
            background: #357ab7;
            color: #fff;
            border: none;
            border-radius: 3px;
            font-size: 1em;
            font-weight: 500;
            cursor: pointer;
        }
        button[type="submit"]:hover {
            background: #285a86;
        }
        .button {
            display: inline-block;
            padding: 7px 16px;
            background: #357ab7;
            color: #fff;
            border-radius: 3px;
            text-decoration: none;
            font-weight: 500;
            font-size: 1em;
            text-align: center;
        }
        .button:hover {
            background: #285a86;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 6px 8px;
            font-size: 0.98em;
        }
        th {
            background: #f7f7f7;
        }
        
    </style>
</head>
<body>
    <?php if (isset($_GET['deleted']) && $_GET['deleted'] == 1): ?>
    <div style="background:#d4edda;color:#155724;padding:10px 16px;border-radius:4px;margin-bottom:16px;">
        Book deleted successfully.
    </div>
<?php endif; ?>
    <div class="container">
        <h1>List of Books</h1>
        <form method="get">
            <input type="text" name="search" placeholder="Search by title, author, or genre" value="<?= htmlspecialchars($search) ?>">
            <select name="filter">
                <option value="">All Genres</option>
                <option value="history" <?= $filter == "history" ? "selected" : "" ?>>History</option>
                <option value="science" <?= $filter == "science" ? "selected" : "" ?>>Science</option>
                <option value="fiction" <?= $filter == "fiction" ? "selected" : "" ?>>Fiction</option>
            </select>
            <button type="submit">Search</button>
            <a href="viewbook.php" class="button" style="padding:6px 12px; background:#eee; color:#357ab7; border:1px solid #ccc;">Reset</a>
        </form>
        <table>
            <tr>
                <th>No.</th>
                <th>Title</th>
                <th>Author</th>
                <th>Genre</th>
                <th>Publication Year</th>
                <th>Publisher</th>
                <th>Copies</th>
                <th>Action<th>
            </tr>
           

            <?php
                if (!empty($books)) {
                    $no_counter = 1;
                    foreach ($books as $book) {
            ?>
                        <tr>
                            <td><?= $no_counter++ ?></td>
                            <td><?= $book["title"];?></td>
                            <td><?= $book["author"]; ?></td>
                            <td><?= $book["genre"]; ?></td>
                            <td><?= $book["publication_year"]; ?></td>
                            <td><?= $book["publisher"]; ?></td>
                            <td><?= $book["copies"]; ?></td>
                            <td>
                           <a href="updatebook.php?id=<?= $book["id"]?>">Update</a>
                           <a href="deletebook.php?id=<?= $book["id"]?>" onclick="return confirm ('<?= $message ?>')">Delete</a>

                    </td>

                        </tr>
            <?php
                    }
                } else {
            ?>
                <tr>
                    <td colspan="7">No books found.</td>
                </tr>
            <?php
                }
            ?>
        </table>
        <a href="addbook.php" class="button">Add Book</a>
    </div>
</body>
</html>