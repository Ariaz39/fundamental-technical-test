<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Laravel API - JWT Authentication & Tasks CRUD

## 🛠️ Requerimientos Previos

Antes de iniciar, asegúrate de contar con:
- Docker
- Docker Compose
- Git

## 🚀 Instalación y Montaje del Proyecto

1. Clonar el repositorio:

   ```bash
   git clone https://github.com/Ariaz39/fundamental-technical-test.git
   cd fundamental
   ```

2. Crear un archivo `.env` a partir del ejemplo:

   ```bash
   cp src/.env.example src/.env
   ```

3. Ajustar las variables de entorno en `src/.env` si es necesario, especialmente:

   ```env
   DB_CONNECTION=pgsql
   DB_HOST=db
   DB_PORT=5432
   DB_DATABASE=fundamental
   DB_USERNAME=postgres
   DB_PASSWORD=secret
   ```

4. Levantar los contenedores con Docker:

   ```bash
   docker-compose up --build -d
   ```

5. Acceder al contenedor de la aplicación:

   ```bash
   docker exec -it laravel_app bash
   ```

6. Instalar dependencias dentro del contenedor:

   ```bash
   composer install
   ```

7. Generar la clave de la aplicación:

   ```bash
   php artisan key:generate
   ```

8. Ejecutar las migraciones y seeders:

   ```bash
   php artisan migrate --seed
   ```
   
9. Asignar permisos a las carpetas de almacenamiento:

   ```bash
    chmod -R 777 storage
    ```

## 📄 Endpoints Disponibles

### Autenticación (JWT):
| Método | Endpoint       | Descripción                                       |
|--------|----------------|---------------------------------------------------|
| POST   | /api/register  | Registra un usuario y devuelve un token JWT.     |
| POST   | /api/login     | Autentica al usuario y devuelve un token JWT.    |

### Tasks CRUD (Requiere autenticación con token JWT):
| Método | Endpoint         | Descripción                                  |
|--------|------------------|----------------------------------------------|
| GET    | /api/tasks        | Lista las tareas del usuario autenticado.   |
| POST   | /api/tasks        | Crea una nueva tarea.                       |
| GET    | /api/tasks/{id}   | Muestra los detalles de una tarea específica. |
| PUT    | /api/tasks/{id}   | Actualiza los campos de una tarea específica. |
| DELETE | /api/tasks/{id}   | Elimina una tarea específica.               |

## 🧪 Pruebas

### Pruebas de Autenticación (JWT):
| Método de prueba                                | Descripción                                             |
|-------------------------------------------------|---------------------------------------------------------|
| test_user_can_register_and_get_jwt_token        | Verifica que un usuario pueda registrarse y obtener token JWT. |
| test_user_can_login_and_get_jwt_token           | Verifica que un usuario pueda iniciar sesión y obtener token JWT. |
| test_user_cannot_login_with_invalid_credentials | Verifica que las credenciales inválidas devuelvan error 401. |
| test_protected_route_requires_jwt_token         | Valida que no se acceda a rutas protegidas sin token JWT. |
| test_user_can_access_protected_route_with_valid_token | Verifica que se acceda con token válido. |

### Pruebas de Tasks CRUD:
| Método de prueba                                  | Descripción                                              |
|---------------------------------------------------|----------------------------------------------------------|
| it_can_list_tasks_for_authenticated_user          | Lista tareas del usuario autenticado.                    |
| it_cannot_list_tasks_without_token                | Bloquea acceso sin token JWT.                            |
| it_can_create_a_task                              | Crea una tarea válida.                                   |
| it_cannot_create_task_without_title               | Valida que el título sea requerido.                      |
| it_can_show_a_task                                | Muestra detalles de una tarea del usuario.               |
| it_cannot_show_a_task_of_another_user             | Bloquea ver tareas de otros usuarios.                    |
| it_can_update_a_task                              | Actualiza una tarea propia.                              |
| it_cannot_update_a_task_of_another_user           | Bloquea actualizar tareas de otros usuarios.             |
| it_cannot_update_a_task_with_empty_data           | Bloquea actualizar con datos vacíos.                     |
| it_can_delete_a_task                              | Elimina una tarea propia.                                |
| it_cannot_delete_a_task_of_another_user           | Bloquea eliminar tareas de otros usuarios.               |

## 🧑‍💻 Ejecución de Pruebas

1. Ingresar al contenedor:

   ```bash
   docker exec -it laravel_app bash
   ```

2. Ejecutar todas las pruebas:

   ```bash
   php artisan test
   ```

3. Ejecutar pruebas específicas:

   ```bash
   php artisan test --filter=AuthTest
   php artisan test --filter=TaskTest
   ```

## 📂 Estructura Clave del Proyecto
```
fundamental/
│
├── docker/                # Configuración Docker
│
├── src/                   # Código fuente Laravel
│   ├── app/
│   │   ├── Http/
│   │   │   ├── Controllers/    # Controladores de la API
│   │   │   ├── Middleware/
│   │   │   ├── Repositories/   # Repositorios de la aplicación
│   │   │   ├── Requests/       # Validación de datos de entrada
│   │   │   └── Services/       # Lógica de negocio
│   │   ├── Models/
│   │
│   ├── database/           # Migraciones, seeders y factories
│   ├── routes/             # Definición de rutas
│   └── tests/              # Pruebas unitarias y de integración
```

## ✍️ Autor
**Alejandro Arias**

