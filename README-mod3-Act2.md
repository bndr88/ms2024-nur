# Presentación Actividad Nro. 2 - Módulo 3
# UNIVERSIDAD NUR - Diplomado Arq. con Microservicios

## Descripción de la presentación 

Se desarrollaron las pruebas de intregración con Postman. Para lo cual se usaron las técnicas aprendidas en clase como ser:
- **`Generar Datos Aleatorios`**: Se prepararon peticiones que permiten generar peticiones con datos aleatorios de tipo:
   - **UUID**: Para los IDs de la clase Paciente y diagnóstico
   - **Texto**: Para los Nombres de la clase Paciente 
   - **Fecha**: Para las fechas de nacimiento de la clase Paciente 
- **`Verificar si la petición se realizó correctamente`**: Se hizo el script que verifica si la petición llegó con respuesta 201 o 202.
- **`Verificar UUID recibido`**: Se hizo el script que verifica si el UUID recibido en la respuesta tiene el formato correcto.
- **`Otras Pruebas`**: Se prepararon peticiones POST, GET, DELETE para probar otros Endpoints:
   - **Crear Tipo de Diagnostico**: Crea Tipo de diagnóstico solo con la descripción y se verifica que el ID generado por el backend esté correcto.
   - **Crear Diagnostico**: Se crea un diagnóstico, pero es necesario definir *IDs de Clientes* y *ID Tipo de Diagnostico* ya *creados*.
   - **Eliminar Paciente**: Se elimina el paciente con un ID definido en la petición.
   - **Eliminar Diagnóstico**: Se elimina el diagnóstico con un ID definido en la petición.
   - **Obter Paciente**: Se obtiene el Paciente con un ID definido en la petición.


## Estructura del Proyecto

Este microservicio se encarga de gestionar todo el historial de diagnósticos de un paciente y las entrevistas que solicitó

- **`src/`**: Contiene el código fuente principal organizado en capas siguiendo los principios de Arquitectura Limpia.
  - **Dominio**: Representa las reglas de negocio y la lógica central.
  - **Aplicación**: Contiene casos de uso y servicios.
  - **Infraestructura**: Implementa el acceso a datos usando Eloquent como ORM, además de otras integraciones externas.
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

