<?php

$koneksi = new mysqli("localhost", "root", "", "data_api");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

$url = "https://jsonplaceholder.typicode.com/users";

$json = file_get_contents($url);

if ($json === false) {
    die("Gagal mengambil data dari JSONPlaceholder.");
}

$data = json_decode($json, true);

foreach ($data as $user) {

    $id = $user['id'];
    $name = $user['name'];
    $username = $user['username'];
    $email = $user['email'];

    $street = $user['address']['street'];
    $suite = $user['address']['suite'];
    $city = $user['address']['city'];
    $zipcode = $user['address']['zipcode'];

    $stmt = $koneksi->prepare("
        INSERT INTO users
        (id, name, username, email, street, suite, city, zipcode)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
            name = VALUES(name),
            username = VALUES(username),
            email = VALUES(email),
            street = VALUES(street),
            suite = VALUES(suite),
            city = VALUES(city),
            zipcode = VALUES(zipcode)
    ");

    $stmt->bind_param(
        "isssssss",
        $id,
        $name,
        $username,
        $email,
        $street,
        $suite,
        $city,
        $zipcode
    );

    $stmt->execute();
}

echo "Data berhasil dimasukkan ke database.";

$koneksi->close();