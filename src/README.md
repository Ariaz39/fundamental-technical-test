# Laravel API - JWT Authentication & Tasks CRUD

> Proyecto desarrollado como parte de una prueba técnica, con el objetivo de implementar un sistema de autenticación con
> JWT y un CRUD de tareas, aplicando buenas prácticas de arquitectura, validaciones y pruebas automatizadas.


## 📝 Descripción del Proyecto

Este proyecto es una API REST desarrollada en **Laravel 10** con **PHP 8.3**, **Nginx** y **PostgreSQL**, todo
desplegado mediante **Docker**.

Se implementó **JWT (JSON Web Token)** para la autenticación y protección de las rutas. La API gestiona tareas y está
estructurada bajo el **patrón de diseño Servicio y Repositorio**.  
Para garantizar la integridad de los datos, se utilizaron **Form Requests** en la validación.

Además, se desarrollaron **pruebas automatizadas con PHPUnit**, empleando una **base de datos SQLite en memoria**.  
El proyecto incluye **seeders y factories** para la generación de datos de prueba.

Finalmente, se proporciona un archivo **`collection.json`** que puede importarse directamente en herramientas como *
*Postman**, **Insomnia** u otras, facilitando así las pruebas de los endpoints expuestos.

🧑‍💻 **Tecnologías utilizadas:**

- Laravel 10
- PHP 8.3
- PostgreSQL
- Nginx
- Docker & Docker Compose
- JWT para autenticación
- PHPUnit para testing (SQLite)

## 🛠️ Requerimientos Previos

Antes de iniciar, asegúrate de contar con:

- Docker
- Docker Compose
- Git

## 🚀 Instalación y Montaje del Proyecto

⏳ **Tiempo estimado de instalación completa:** Aproximadamente 5 - 10 minutos.

1. Clonar el repositorio:

   ```bash
   git clone https://github.com/Ariaz39/fundamental-technical-test.git
   cd fundamental-technical-test
   ```

2. Crear un archivo `.env` a partir del ejemplo ejecutando el siguiente comando en la consola:

   ```bash
   cp src/.env.example src/.env
   ```

3. Ajustar las variables de entorno en `src/.env` reemplazando las variables con los mismos nombres por las siguientes
   líneas: (puedes usar VsCode o cualquier editor de texto)

   ```env
   DB_CONNECTION=pgsql
   DB_HOST=db
   DB_PORT=5432
   DB_DATABASE=fundamental_db
   DB_USERNAME=postgres
   DB_PASSWORD=secret
   ```

4. Ingresar a la carpeta docker

   ```bash
   cd docker
   ```

5. Levantar los contenedores con Docker:

   ```bash
   docker-compose up --build -d
   ```

6. Acceder al contenedor de la aplicación:

   ```bash
   docker exec -it laravel_app bash
   ```

7. Instalar dependencias dentro del contenedor:

   ```bash
   composer install
   ```

8. Generar la clave de la aplicación:

   ```bash
   php artisan key:generate
   ```

9. Ejecutar las migraciones y seeders:

   ```bash
   php artisan migrate --seed
   ```

10. Generar la clave de JWT (necesario para que los tokens funcionen):

```bash
php artisan jwt:secret
```

11. Asignar permisos a las carpetas de almacenamiento:

```bash
 chmod -R 777 storage
 ```

---
🌐 **Acceso a la aplicación:**

Una vez finalizados los pasos, la API estará disponible en:

- **API:** [http://localhost:8080](http://localhost:8080)

---

## 📄 Endpoints Disponibles

**Archivo de colección para pruebas (Postman/Insomnia)**: [collection.json](_devtools/collection.json)

### Autenticación (JWT):

| Método | Endpoint      | Descripción                                   |
|--------|---------------|-----------------------------------------------|
| POST   | /api/register | Registra un usuario y devuelve un token JWT.  |
| POST   | /api/login    | Autentica al usuario y devuelve un token JWT. |

### Tasks CRUD (Requiere autenticación con token JWT):

| Método | Endpoint        | Descripción                                   |
|--------|-----------------|-----------------------------------------------|
| GET    | /api/tasks      | Lista las tareas del usuario autenticado.     |
| POST   | /api/tasks      | Crea una nueva tarea.                         |
| GET    | /api/tasks/{id} | Muestra los detalles de una tarea específica. |
| PUT    | /api/tasks/{id} | Actualiza los campos de una tarea específica. |
| DELETE | /api/tasks/{id} | Elimina una tarea específica.                 |

El archivo `collection.json` se encuentra en la carpeta `/_devtools` en la raiz del proyecto y puede ser importado en
herramientas como **Postman**, **Insomnia** u otras, para facilitar las pruebas de los endpoints de la API.

## 🧪 Pruebas

### Pruebas de Autenticación (JWT):

| Método de prueba                                      | Descripción                                                       |
|-------------------------------------------------------|-------------------------------------------------------------------|
| test_user_can_register_and_get_jwt_token              | Verifica que un usuario pueda registrarse y obtener token JWT.    |
| test_user_can_login_and_get_jwt_token                 | Verifica que un usuario pueda iniciar sesión y obtener token JWT. |
| test_user_cannot_login_with_invalid_credentials       | Verifica que las credenciales inválidas devuelvan error 401.      |
| test_protected_route_requires_jwt_token               | Valida que no se acceda a rutas protegidas sin token JWT.         |
| test_user_can_access_protected_route_with_valid_token | Verifica que se acceda con token válido.                          |

### Pruebas de Tasks CRUD:

| Método de prueba                         | Descripción                                  |
|------------------------------------------|----------------------------------------------|
| it_can_list_tasks_for_authenticated_user | Lista tareas del usuario autenticado.        |
| it_cannot_list_tasks_without_token       | Bloquea acceso sin token JWT.                |
| it_can_create_a_task                     | Crea una tarea válida.                       |
| it_cannot_create_task_without_title      | Valida que el título sea requerido.          |
| it_can_show_a_task                       | Muestra detalles de una tarea del usuario.   |
| it_cannot_show_a_task_of_another_user    | Bloquea ver tareas de otros usuarios.        |
| it_can_update_a_task                     | Actualiza una tarea propia.                  |
| it_cannot_update_a_task_of_another_user  | Bloquea actualizar tareas de otros usuarios. |
| it_cannot_update_a_task_with_empty_data  | Bloquea actualizar con datos vacíos.         |
| it_can_delete_a_task                     | Elimina una tarea propia.                    |
| it_cannot_delete_a_task_of_another_user  | Bloquea eliminar tareas de otros usuarios.   |

## 🧑‍💻 Ejecución de Pruebas

1. Ingresar al contenedor de la aplicacion:

   ```bash
   docker exec -it laravel_app bash
   ```

2. Ejecutar todas las pruebas:

   ```bash
   php artisan test
   ```

3. Ejecutar pruebas de un archivo específico:

   ```bash
   php artisan test --filter=AuthTest
   php artisan test --filter=TaskTest
   php artisan test --filter=TaskRepositoryTest
   php artisan test --filter=TaskServiceTest
   ```

## 📂 Estructura Clave del Proyecto

```
fundamental/
├── _devtools/             # Herramientas para desarrollador
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

[![LinkedIn](https://img.shields.io/badge/LinkedIn-Ing.%20Alejandro%20Arias-blue?logo=linkedin)](https://www.linkedin.com/in/alejandro-arias/)
[![GitHub](https://img.shields.io/badge/GitHub-Ariaz39-black?logo=github)](https://github.com/Ariaz39/)

**Ing. Alejandro Arias**  
*Software Engineer | Fullstack Developer*
