<?php

require 'flight/Flight.php';

Flight::register('db', 'PDO', array('mysql:host=localhost;dbname=test','root',''));

Flight::route('GET /usuarios', function () {
    $sentence = Flight::db()->prepare("SELECT * FROM usuarios");
    $sentence->execute();
    $data = $sentence->fetchAll(PDO::FETCH_ASSOC);
    Flight::json($data);
});

Flight::route('GET /usuarios/@id', function ($id) {
    $sentence = Flight::db()->prepare("SELECT * FROM usuarios WHERE id = ?");
    $sentence->bindParam(1,$id);
    $sentence->execute();
    $data = $sentence->fetch(PDO::FETCH_ASSOC);
    Flight::json($data);
});

Flight::route('POST /usuarios', function () {
    $data = Flight::request()->data;
    $apellido_nombre = $data->apellido_nombre;
    $dni = $data->dni;
    
    $sentence = Flight::db()->prepare("INSERT INTO usuarios (apellido_nombre, dni) VALUES (?,?)");

    $sentence->bindParam(1,$apellido_nombre);
    $sentence->bindParam(2,$dni);

    $sentence->execute();
    $data->id = Flight::db()->lastInsertId();
    Flight::json($data);
});

Flight::route('DELETE /usuarios', function () {
    $data = Flight::request()->data;
    $id = $data->id;
    
    $sentence = Flight::db()->prepare("DELETE FROM usuarios WHERE id = ?");

    $sentence->bindParam(1,$id);

    $sentence->execute();
    Flight::jsonp(["Usuario eliminado"]);
});

Flight::route('PUT /usuarios', function() {
    $data = Flight::request()->data;
    $id = $data->id;
    $apellido_nombre = $data->apellido_nombre;
    $dni = $data->dni;
    
    $sentence = Flight::db()->prepare("UPDATE usuarios SET apellido_nombre = ?, dni = ? WHERE id = ?");

    $sentence->bindParam(1,$apellido_nombre);
    $sentence->bindParam(2,$dni);
    $sentence->bindParam(3,$id);

    $sentence->execute();
    Flight::jsonp(["Usuario actualizado"]);
});



Flight::start();
