-- Crear tabla de usuarios
CREATE TABLE usuarios (
    id_usuario INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre TEXT NOT NULL,
    estado TEXT NOT NULL DEFAULT ('activo') CHECK (estado IN ('activo', 'inactivo')),
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Crear tabla de especialidades
CREATE TABLE especialidades (
    id_especialidad INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre TEXT NOT NULL,
    alias TEXT NOT,
    estado TEXT NOT NULL DEFAULT ('activo') CHECK (estado IN ('activo', 'inactivo')),
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insertar especialidades predefinidas
INSERT INTO especialidades (nombre, alias) VALUES ('Medicina General', 'medicina');
INSERT INTO especialidades (nombre, alias) VALUES ('Pediatría', 'pediatria');
INSERT INTO especialidades (nombre, alias) VALUES ('Dermatología', 'dermatologia');

-- Crear tabla de citas
CREATE TABLE citas (
    id_cita INTEGER PRIMARY KEY AUTOINCREMENT,
    usuario_id INTEGER NOT NULL,
    especialidad_id INTEGER NOT NULL,
    estado TEXT NOT NULL CHECK (estado IN ('pendiente', 'confirmada', 'cancelada','reprogramada','eliminada')),
    fecha_hora_programacion DATETIME NOT NULL,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (especialidad_id) REFERENCES especialidades(id_especialidad)
);