
# Gestión de citas - PHP / SQLite

## Descripción

Este proyecto es una aplicación web para la gestión de citas de pacientes que permite registrar, visualizar y eliminar citas utilizando PHP y SQLite.

---

## Requerimientos

- PHP (7.4 o superior).
- SQLite instalado.

---

## Levantamiento del proyecto

1. Clonar este repositorio.
2. Ir al directorio del proyecto.
3. Ejecutar el script para crear las tablas: 

`sqlite3 database.sqlite`  

3.1. Ejecutar el script de creacion 

`.read ./scripts/creacion.sql` 

4. Para revesar lo anterior, ejecuta: 

 `sqlite3 database.sqlite`    

4.1. Ejecutar el script de reverso

 `.read ./scripts/eliminacion.sql` 

5. Levanta el servidor PHP:

 `php -S localhost:8000`  

6. Abre en el navegador: http://localhost:8000  

---
