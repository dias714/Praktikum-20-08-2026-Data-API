<?php

header("Content-Type: application/json; charset=UTF-8");

require_once "koneksi.php";

$sql = "SELECT id, name, username, email, street, suite, city, zipcode
        FROM users
        ORDER BY id ASC";

$result = $koneksi->query($sql);

$data = [];

while ($row = $result->fetch_assoc()) {

    $data[] = [
        "id" => (int) $row["id"],
        "name" => $row["name"],
        "username" => $row["username"],
        "email" => $row["email"],
        "address" => [
            "street" => $row["street"],
            "suite" => $row["suite"],
            "city" => $row["city"],
            "zipcode" => $row["zipcode"]
        ]
    ];
}

echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

$koneksi->close();