# PRESENTACIÓN ACTIVAD NRO. 1 - MÓDULO 4
# Universidad NUR - Diplomado en Arq. con Microservicios

Respositorio del Proyecto para ir aplicando todo lo aprendido en el Diplomado en Arq. con Microservicios.

## Descripción de la presentación 

Para esta presenteción, se realizaron las siguientes actividades:
- **`.Dockerignore`**: Se elaboró un archivo .dockerignore para generar omitir ciertos archivos que no se desea que se agreguen a la imagen.
- **`Dockerfile`**: Se elaboró un archivo Dockerfile para generar una imagen de todo el proyecto, usando los siguientes comandos:
   - **`Crear la imagen`**
   ```bash
   docker build -t wendermendez/nutrinur:1.0 .
   ```
   - **`Crear contenedor`**
   ```bash
   docker run -d -p 8080:80 --name mi-microservicio wendermendez/nutrinur:1.0
   ```
   Luego se desarrolló un endPoint de prueba:
   **`Hola`**
   - **Método**: `GET`
   - **URL**: `/hola`
   - **Parámetros (Body)**: Ninguno
   - **Descripción**: Este endpoint permite tener una respuesta de prueba desde el contenedor. Para no usar acceso a la Base de Datos
   - **Respuesta esperada**:
      {
         "message": "Hola Mundo"
      }

- **`DockerHub`**: Se subió la imagen a un repositorio público de dockerHub (wendermendez/nutrinur) usando los siguientes comandos:
   - **`Login`**
   ```bash
   docker login
   ```
   - **`Subir la imagen`**
   ```bash
   docker push wendermendez/nutrinur:1.1
   ```

## Estructura del Proyecto

Este microservicio se encarga de gestionar todo el historial de diagnósticos de un paciente y las entrevistas que solicitó

- **`src/`**: Contiene el código fuente principal organizado en capas siguiendo los principios de Arquitectura Limpia.
  - **Dominio**: Representa las reglas de negocio y la lógica central.
  - **Aplicación**: Contiene casos de uso y servicios.
  - **Infraestructura**: Implementa el acceso a datos usando Eloquent como ORM, además de otras integraciones externas.
- **`tests/`**: Contiene el código de los diferentes tipos de tests aplicados al proyecto
  - **Dominio**: Representa las reglas de negocio y la lógica central.
  - **Aplicación**: Contiene casos de uso y servicios.
- **`vendor/`**: Incluye las dependencias externas instaladas mediante Composer.
- **`composer.json`**: Define las dependencias y configuraciones del proyecto.
- **`composer.lock`**: Bloquea las versiones de las dependencias.
- **`Modelo-Dominio-3.0.jpg`**: Imagen del modelo de dominio asociado al proyecto.
- **`README.md`**: Documentación del proyecto.

## APIs Disponibles

A continuación, se describen las APIs disponibles en el proyecto, cómo utilizarlas en Postman, los parámetros requeridos y los resultados esperados.

### 1. Agregar un Paciente
- **Método**: `POST`
- **URL**: `/pacientes`
- **Parámetros (Body)**:
  {
      "nombre": "Nombre del paciente",
      "fechaNacimiento": "YYYY-MM-DD"
  }
- **Descripción**: Este endpoint permite registrar un nuevo paciente en el sistema.

- **Respuesta esperada**:
   {
      "success": true,
      "pacienteId": "12345"
   }

### 2. Eliminar un Paciente
- **Método**: `DELETE`
- **URL**: `/pacientes/{id}`
- **Parámetros (URL)**:
  {
      "id" (string): Identificador único del paciente que se desea eliminar
  }
- **Descripción**: Este endpoint permite registrar un nuevo paciente en el sistema.

- **Respuesta esperada**:
   {
      "success": true
   }

## Modelo de Dominio

El proyecto utiliza el siguiente modelo de dominio:

![Modelo de Dominio](https://github.com/bndr88/ms2024-nur/blob/main/Modelo-Dominio-3.0.jpg)

## Requisitos Previos

- PHP versión 8.3.
- Composer 2.8.4.
- Servidor web Apache.
- Base de datos compatible MySQL.

## Ejecución

1. **Levantar el Servidor Local**
   Se puede usar el servidor embebido de PHP para pruebas locales:
   ```bash
   php -S localhost:8000 -t ./src/Presentacion/
   ```
   Es importante notar que la capa Presentación contiene el archivo index.php que arranca la aplicación.

2. **Acceso a la Aplicación**
   Abrir un navegador web y acceder a `http://localhost:8000`.

## Principios Implementados

- **DDD (Domain-Driven Design):** El dominio se diseña primero, asegurando que las reglas de negocio sean independientes de la infraestructura.
- **Microservicios:** Arquitectura distribuida para dividir la lógica en componentes pequeños y autónomos.
- **CQRS:** Separación de las responsabilidades de comando y consulta para mayor eficiencia y claridad.
- **Arquitectura Limpia:** División clara de responsabilidades entre capas para facilitar la mantenibilidad y escalabilidad.

