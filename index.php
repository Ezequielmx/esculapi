<?php

require 'flight/Flight.php';

Flight::register('db', 'PDO', array('mysql:host=localhost;dbname=test','root',''));

//---USUARIOS ------------------------------------------------------------------------//

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

//---VEHICULOS ------------------------------------------------------------------------//

Flight::route('GET /vehiculos', function () {
    $sentence = Flight::db()->prepare("SELECT * FROM vehiculos");
    $sentence->execute();
    $data = $sentence->fetchAll(PDO::FETCH_ASSOC);
    Flight::json($data);
});

Flight::route('GET /vehiculos/@id', function ($id) {
    $sentence = Flight::db()->prepare("SELECT * FROM vehiculos WHERE id = ?");
    $sentence->bindParam(1,$id);
    $sentence->execute();
    $data = $sentence->fetch(PDO::FETCH_ASSOC);
    Flight::json($data);
});

Flight::route('POST /vehiculos', function () {
    $data = Flight::request()->data;
    $id = $data->id;
    $patente = $data->patente;
    $tipo = $data->tipo;
    $marca_modelo = $data->marca_modelo;
    
    $sentence = Flight::db()->prepare("INSERT INTO vehiculos (id, patente, tipo, marca_modelo) VALUES (?,?,?,?)");

    $sentence->bindParam(1,$id);
    $sentence->bindParam(2,$patente);
    $sentence->bindParam(3,$tipo);
    $sentence->bindParam(4,$marca_modelo);

    $sentence->execute();
    $data->id = Flight::db()->lastInsertId();
    Flight::json($data);
});

Flight::route('DELETE /vehiculos', function () {
    $data = Flight::request()->data;
    $id = $data->id;
    
    $sentence = Flight::db()->prepare("DELETE FROM vehiculos WHERE id = ?");

    $sentence->bindParam(1,$id);

    $sentence->execute();
    Flight::jsonp(["Vehiculo eliminado"]);
});

Flight::route('PUT /vehiculos', function() {
    $data = Flight::request()->data;
    $id = $data->id;
    $patente = $data->patente;
    $tipo = $data->tipo;
    $marca_modelo = $data->marca_modelo;
    
    $sentence = Flight::db()->prepare("UPDATE vehiculos SET patente = ?, tipo = ?, marca_modelo = ? WHERE id = ?");

    $sentence->bindParam(1,$patente);
    $sentence->bindParam(2,$tipo);
    $sentence->bindParam(3,$marca_modelo);
    $sentence->bindParam(4,$id);

    $sentence->execute();
    Flight::jsonp(["Vehiculo actualizado"]);
});

//---ASIGNACIONES ------------------------------------------------------------------------//
flight::route('GET /asignaciones/activas', function () {
    $sentence = Flight::db()->prepare("SELECT * FROM asignaciones WHERE devuelto = 0");
    $sentence->execute();
    $data = $sentence->fetchAll(PDO::FETCH_ASSOC);
    Flight::json($data);
});

flight::route('GET /asignaciones/porfecha', function () {
    $desde = Flight::request()->query['desde'];
    $hasta = Flight::request()->query['hasta'];
    $sentence = Flight::db()->prepare("SELECT * FROM asignaciones WHERE desde BETWEEN ? AND ? OR hasta BETWEEN ? AND ?");
    $sentence->bindParam(1,$desde);
    $sentence->bindParam(2,$hasta);
    $sentence->execute();
    $data = $sentence->fetchAll(PDO::FETCH_ASSOC);
    Flight::json($data);
});

Flight::route('GET /asignaciones/@id', function ($id) {
    $sentence = Flight::db()->prepare("SELECT * FROM asignaciones WHERE id = ?");
    $sentence->bindParam(1,$id);
    $sentence->execute();
    $data = $sentence->fetch(PDO::FETCH_ASSOC);
    Flight::json($data);
});

Flight::route('POST /asignaciones', function () {
    $data = Flight::request()->data;
    $id = $data->id;
    $id_usuario = $data->id_usuario;
    $id_vehiculo = $data->id_vehiculo;
    $desde = $data->desde;
    $hasta = $data->hasta;
    $devuelto = $data->devuelto;
    
    $sentence = Flight::db()->prepare("INSERT INTO asignaciones (id, id_usuario, id_vehiculo, desde, hasta, devuelto) VALUES (?,?,?,?,?,?)");

    $sentence->bindParam(1,$id);
    $sentence->bindParam(2,$id_usuario);
    $sentence->bindParam(3,$id_vehiculo);
    $sentence->bindParam(4,$desde);
    $sentence->bindParam(5,$hasta);
    $sentence->bindParam(6,$devuelto);

    $sentence->execute();
    $data->id = Flight::db()->lastInsertId();
    Flight::json($data);
});

Flight::route('DELETE /asignaciones', function () {
    $data = Flight::request()->data;
    $id = $data->id;
    
    $sentence = Flight::db()->prepare("DELETE FROM asignaciones WHERE id = ?");

    $sentence->bindParam(1,$id);

    $sentence->execute();
    Flight::jsonp(["Asignacion eliminada"]);
});

Flight::route('PUT /asignaciones', function() {
    $data = Flight::request()->data;
    $id = $data->id;
    $id_usuario = $data->id_usuario;
    $id_vehiculo = $data->id_vehiculo;
    $desde = $data->desde;
    $hasta = $data->hasta;
    $devuelto = $data->devuelto;
    
    $sentence = Flight::db()->prepare("UPDATE asignaciones SET id_usuario = ?, id_vehiculo = ?, desde = ?, hasta = ?, devuelto = ? WHERE id = ?");

    $sentence->bindParam(1,$id_usuario);
    $sentence->bindParam(2,$id_vehiculo);
    $sentence->bindParam(3,$desde);
    $sentence->bindParam(4,$hasta);
    $sentence->bindParam(5,$devuelto);
    $sentence->bindParam(6,$id);

    $sentence->execute();
    Flight::jsonp(["Asignacion actualizada"]);
});

Flight::start();
