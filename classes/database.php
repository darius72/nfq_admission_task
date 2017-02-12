<?php

/**
 * Created by PhpStorm.
 * User: Darius
 * Date: 2017.02.10
 * Time: 21:31
 */

require_once('book.php');
require_once('bookBig.php');

class database {
    private $servername = "localhost";
    private $username = "id783838_root";
    private $password = "5had0w";
    private $dbname = "id783838_mydb";
    private $dbtable = "mybooks";
    private $conn;
    private $connected;

    function __construct() {
        $this->conn = new mysqli(
                $this->servername,
                $this->username,
                $this->password,
                $this->dbname
            );
        if ($this->conn->connect_error) {
            $this->connected = false;
        } else {
            $this->connected = true;
        }
    }

    function Connected() {
        return $this->connected;
    }

    function GetBooks($order, $limit, $offset) {
        $list = array();
        $sql = "SELECT id, name, year, author, genre FROM $this->dbtable ORDER BY $order LIMIT $offset, $limit";
        $result = $this->conn->query($sql);
        while($row = $result->fetch_assoc()) {
            $list[] = new book(
                    $row["id"],
                    $row["name"],
                    $row["author"],
                    $row["year"],
                    $row["genre"]
                );
        }
        return $list;
    }

    function GetBooksSearch($key, $search) {
        $list = array();
        $sql = "SELECT id, name, year, author, genre FROM $this->dbtable WHERE $key = '$search'";
        $result = $this->conn->query($sql);
        while($row = $result->fetch_assoc()) {
            $list[] = new book(
                $row["id"],
                $row["name"],
                $row["author"],
                $row["year"],
                $row["genre"]
            );
        }
        return $list;
    }

    function GetBook($bookId) {
        $sql = "SELECT id, name, year, author, genre, about FROM $this->dbtable WHERE id = $bookId";
        $result = $this->conn->query($sql);
        while($row = $result->fetch_assoc()) {
            return new bookBig(
                $row["id"],
                $row["name"],
                $row["author"],
                $row["year"],
                $row["genre"],
                $row["about"]
            );
        }
        return null;
    }

    function GetTableRowCount() {
        $sql = "SHOW TABLE STATUS FROM $this->dbname LIKE '$this->dbtable'";
        $result = $this->conn->query($sql);
        while($row = $result->fetch_assoc()) {
            return $row['Rows'];
        }
        return null;
    }

}