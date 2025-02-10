# PRESENTACIÓN ACTIVAD NRO. 3 - MÓDULO 3
# Universidad NUR - Diplomado en Arq. con Microservicios

Respositorio del Proyecto para ir aplicando todo lo aprendido en el Diplomado en Arq. con Microservicios.

## Descripción de la presentación 

Se desarrollaron los Contract Test con PACT. Se realizaron las siguientes activiades:
- **`Creación de Front-end`**: Se creó un proyecto simple usando un poco de HTML y JS. El mismo se encuentra en /tests/Pact/proyecto-consumidor.zip 
- **`CORS`**: Se "deshabilitó" la verificación CORS. 
- **`Inclusión de dependencias`**: Al proyecto del consumidor se agregó toas las dependencias necesarias:.
   - **Node.js**
   - **npm**
   - **Mocha**: Para pruebas de JavaScript.
   - **Chai**: Para hacer las pruebas más legibles.
   - **PACT**: Para generar el contrato (Pacto), se lo instaló mediante el comando:
   ```bash
   npm i -S @pact-foundation/pact@latest
   ```
- **`Generación del pacto en Consumidor`**: En el proyecto consumidor se configuró todos los archivos (Ver cambios en repositorio) y se usó la el comando de más abajo para ejecutar el test y generar el pacto (contrato) que se generó en /tests/pacts/pacts/Frontend-Backend.json:
   ```bash
   npx mocha tests/pacts/pactTest.js
   ```
- **`Prueba del pacto en el Proveedor`**: Se copió el pacto generado en el consumidor (Frontend-Backend.json) al proyecto proveedor. Está ubicado en /tests/Pact/contracts/Frontend-Backend.json y se desarrollaron los siguientes archivos:
   - **ProviderTest.php**: Para pruebas de JavaScript.


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

![Modelo de Dominio](https://github.com/nur-university/nur-ms2024-m2-act-3-bndr88/blob/175dd7db90d454b9b8a25d985263bef90850a093/Modelo-Dominio-3.0.jpg)

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

