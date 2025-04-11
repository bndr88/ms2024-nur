# PRESENTACIÓN ACTIVAD NRO. 1 - MÓDULO 5
# Universidad NUR - Diplomado en Arq. con Microservicios

Respositorio del Proyecto para ir aplicando todo lo aprendido en el Diplomado en Arq. con Microservicios.

## Descripción de la presentación

Para esta presentación se realizaron las siguientes actividades:
sonarlint
- **`Sonarlint`**: Se instaló la extensión SonarLint (SonarQube for IDEs) para integrar el análisis estático de código directamente en el entorno de desarrollo y detectar posibles errores, vulnerabilidades y malas prácticas en tiempo real.
- **`PHP Intelephense`**: Se instaló la extensión PHP Intelephense como linter para el análisis estático del código PHP, lo cual facilita la detección temprana de errores y mejora la calidad del código durante el desarrollo.
- **`.editorconfig`**: Se agregó un archivo .editorconfig al proyecto con configuraciones básicas de estilo para los editores, incluyendo la regla que fuerza el uso de tabs en lugar de espacios para la indentación. Este archivo ayuda a mantener consistencia en aspectos generales del formato, especialmente cuando se utiliza un editor compatible.
- **`PHP-CS-Fixer`**: Se configuró PHP-CS-Fixer como herramienta principal de code formatting para archivos PHP. Las reglas específicas de formateo se encuentran definidas en el archivo .php-cs-fixer.dist.php, ya que .editorconfig no puede cubrir todos los aspectos del estilo en archivos PHP. Este paquete permite aplicar automáticamente las convenciones establecidas, mejorando la coherencia del código y facilitando su mantenimiento. Se usa este comando para iniciar el "formateo" del código.
   ```bash
   ".\vendor\bin\php-cs-fixer" fix .
   ```
- **`Husky`**: Se integró Husky para gestionar hooks de Git. En particular, se configuró un hook pre-commit que ejecuta automáticamente PHP-CS-Fixer antes de confirmar cambios. Esto garantiza que el código PHP esté correctamente formateado según las reglas del proyecto antes de ser versionado, reforzando buenas prácticas de desarrollo desde el entorno local. En el Pre-commit se puso las dos reglas descritas más abajo para formatear el código y ejecutar los test antes de hacer un commit.

   ```bash
   ".\vendor\bin\php-cs-fixer" fix .
	".\vendor\bin\pest" ./tests/Unit
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

