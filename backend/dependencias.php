<?php
require_once 'contenedor.php';
require_once 'connection.php';
// Repositorioas
require_once 'repositories/citasRepository.php';
require_once 'repositories/usuariosRepository.php';
require_once 'repositories/especialidadRepository.php';
// Servicices
require_once 'services/citasService.php';
require_once 'services/especialidadService.php';
require_once 'services/usuariosService.php';

$contenedor = new Contenedor();

$contenedor->registrar('dbConnection', function () {
    return new DatabaseConnection();
});

$contenedor->registrar('citasRepository', function () use ($contenedor) {
    $conn = $contenedor->resolver('dbConnection')->getConnection();
    return new CitasRepository($conn);
});

$contenedor->registrar('especialidadRepository', function () use ($contenedor) {
    $conn = $contenedor->resolver('dbConnection')->getConnection();
    return new EspecialidadRepository($conn);
});

$contenedor->registrar('usuariosRepository', function () use ($contenedor) {
    $conn = $contenedor->resolver('dbConnection')->getConnection();
    return new UsuariosRepository($conn);
});

$contenedor->registrar('especialidadService', function () use ($contenedor) {
    $repository = $contenedor->resolver('especialidadRepository');
    return new EspecialidadService($repository);
});

$contenedor->registrar('citasService', function () use ($contenedor) {
    $repository = $contenedor->resolver('citasRepository');
    $especialidadService = $contenedor->resolver('especialidadService');
    $usuariosService = $contenedor->resolver('usuariosService');
    return new CitasService($repository, $especialidadService, $usuariosService);
});

$contenedor->registrar('usuariosService', function () use ($contenedor) {
    $repository = $contenedor->resolver('usuariosRepository');
    return new UsuariosService($repository);
});

return $contenedor;
