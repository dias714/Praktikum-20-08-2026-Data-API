<?php

require_once "koneksi.php";

if (!isset($_GET["id"])) {
    die("ID tidak ditemukan.");
}

$id = (int) $_GET["id"];

$stmt = $koneksi->prepare("
    DELETE FROM users
    WHERE id = ?
");

$stmt->bind_param("i", $id);

$stmt->execute();

header("Location: index.html");
exit;