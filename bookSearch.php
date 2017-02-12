<?php
/**
 * Created by PhpStorm.
 * User: Darius
 * Date: 2017.02.12
 * Time: 01:57
 */

require_once ('classes/database.php');
//require_once ('classes/book.php');
require_once ('classes/pageDisplay.php');

$key;
$search;

(isset($_POST['search']) ? $search = pageDisplay::checkFormInput($_POST['search']) : header("Location: index.php"));
if (isset($_POST['Key'])) {
    switch ($_POST['Key']) {
        case 'name':
        case 'author':
        case 'year':
        case 'genre':
            $key = $_POST['Key'];
            break;
        default:
            header("Location: index.php");
            break;
    }
} else {
    header("Location: index.php");
}

echo "<a href='index.php'> Back to Book List </a><br>";
$db = new database();
if ($db->Connected()) {
    $books = $db->GetBooksSearch($key, $search);
    if ($books) {
        echo "<table border='1'><tr>
        <th><a href='index.php'> Name </a></th>
        <th><a href='index.php'> Author </a></th>
        <th><a href='index.php'> Year </a></th>
        <th><a href='index.php'> Genre </a></th></tr>";

        foreach($books as $book) {
            echo "<tr><td><a href='bookinfo.php?id=".$book->id."'>" . $book->name . "</a></td>
           <td>" . $book->author . "</td>
           <td>" . $book->year . "</td>
           <td>" . $book->genre . "</td></tr>";
        }
        echo '</table>';
    } else {
        echo "Search returned 0 results";
    }
}