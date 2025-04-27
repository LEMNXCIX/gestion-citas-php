<?php

class CitasService
{
    private $repository;
    private $serviceEspecialidades;
    private $serviceUsuario;

    public function __construct($repository, $serviceEspecialidades, $serviceUsuario)
    {
        $this->repository = $repository;
        $this->serviceEspecialidades = $serviceEspecialidades;
        $this->serviceUsuario = $serviceUsuario;
    }

    public function listarCitas()
    {
        try {
            $citas_sanitizadas = [];
            $citas = $this->repository->obtenerTodas();

            foreach ($citas as $cita) {
                $cita_sani = [
                    'id_cita' => $cita['id_cita'],
                    'estado' => $cita['estado'],
                    'fecha_hora_programacion' => $cita['fecha_hora_programacion'],
                ];

                // Obtener y agregar datos del usuario
                $usuario = $this->serviceUsuario->obtenerUsuarioById($cita['usuario_id']);
                if (is_array($usuario)) {
                    $cita_sani['usuario'] = [
                        'id_usuario' => $usuario['id_usuario'],
                        'nombre' => $usuario['nombre'],
                    ];
                }

                // Obtener y agregar datos de la especialidad
                $especialidad = $this->serviceEspecialidades->obtenerEspecialidadById($cita['especialidad_id']);
                if (is_array($especialidad)) {
                    $cita_sani['especialidad'] = [
                        'id_especialidad' => $especialidad['id_especialidad'],
                        'nombre' => $especialidad['nombre'],
                        'alias' => $especialidad['alias'],
                    ];
                }
                $citas_sanitizadas[] = $cita_sani;
            }

            return $citas_sanitizadas;
        } catch (Exception $e) {

            return [
                'error' => true,
                'success' => false,
                'mensaje' => 'No se pudieron obtener las citas',
                'error_details' => $e->getMessage(),
            ];
        }
    }

    public function crearCita($datos)
    {
        if (empty($datos['nombre']) || empty($datos['especialidad']) || empty($datos['programado'])) {
            return [
                'error' => false,
                'success' => false,
                'mensaje' => 'No se recibieron valores para la creacion de la cita.',
                'error_details' => [
                    'Valores de nombre, especialidad o programado se enceuntran vacios'
                ]
            ];
        }
        $nombre = trim($datos['nombre']);
        if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $nombre)) {
            return [
                'error' => false,
                'success' => false,
                'mensaje' => 'Nombre no valido.',
                'error_details' => [
                    'Caracteres especiales encontrados en el valor'
                ]
            ];
        }

        // Crear siempre el usuario por ahora
        $usuario = $this->serviceUsuario->crearUsuario($nombre);
        if ($usuario['error']) {
            throw new Exception($usuario['mensaje']);
        }

        $usuario = $usuario['data'];
        $usuario_id = $usuario['id_usuario'];

        // Obtener la especialidad por alias
        $especialidad_alias = trim($datos['especialidad']);

        $especialidad = $this->serviceEspecialidades->obtenerEspecialidadByAlias($especialidad_alias);

        if (empty($especialidad) || empty($especialidad['id_especialidad'])) {
            return [
                'error' => false,
                'success' => true,
                'mensaje' => 'Especialidad no encontrada.'
            ];
        }

        $fecha_programada = trim($datos['programado']);
        $horaActual = new DateTime();
        $fecha_actual = $horaActual->format('Y-m-d\TH:i');
        error_log( date_default_timezone_get());
        error_log($fecha_programada);
        error_log($fecha_actual);
        if ($fecha_programada < $fecha_actual) {
            return [
                'error' => false,
                'success' => false,
                'mensaje' => 'Se ha seleccionado una fecha de programacion no valida'
            ];
        }
        error_log( date_default_timezone_get());
        error_log($fecha_programada);
        error_log($fecha_actual);

        try {
            if ($this->repository->insertar($usuario_id, $especialidad['id_especialidad'], "pendiente", $fecha_programada)) {
                return [
                    'error' => false,
                    'success' => true,
                    'mensaje' => 'Cita creada correctamente.'
                ];
            } else {
                return [
                    'error' => true,
                    'success' => false,
                    'mensaje' => "No se pudo crear la cita."
                ];
            }
        } catch (Exception $e) {
            return [
                'error' => true,
                'success' => false,
                'mensaje' => 'No se pudo crear la cita.',
                'error_details' => [
                    $e->getMessage()
                ]
            ];
        }
    }

    public function eliminarCita($id_Cita)
    {
        try {
            if ($this->repository->eliminar($id_Cita)) {
                return [
                    'error' => false,
                    'success' => true,
                    'mensaje' => 'Cita eliminada correctamente.',
                ];
            } else {
                return [
                    'error' => true,
                    'success' => false,
                    'mensaje' => "No se pudo crear la cita.",
                    'error_details' => [
                        "No se pudo eliminar la cita con ID {$id_Cita}"
                    ]
                ];
            }
        } catch (Exception $e) {
            return [
                'error' => true,
                'success' => false,
                'mensaje' => 'Error al eliminar la cita.',
                'error_details' => [
                    $e->getMessage()
                ]
            ];
        }
    }
}
