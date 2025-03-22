#!/bin/bash
set -e

# Iniciar SQL Server en segundo plano
/opt/mssql/bin/sqlservr &

# Esperar a que el servicio esté disponible
echo "Esperando a que SQL Server esté disponible..."
sleep 20

# Crear base de datos y usuario si no existen
echo "Creando base de datos y usuario..."
/opt/mssql-tools18/bin/sqlcmd -S localhost -U sa -P Password2025 -C -Q "
IF NOT EXISTS (SELECT name FROM sys.databases WHERE name = 'deliverydb')
BEGIN
    CREATE DATABASE deliverydb;
END
GO"

# Ejecutar script de inicialización si existe
if [ -f /script_ini.sql ]; then
    echo "Ejecutando script de inicialización..."
    /opt/mssql-tools18/bin/sqlcmd -S localhost -U sa -P "Password2025" -C -d deliverydb -i /script_ini.sql
fi

# Mantener el contenedor activo
wait






#!/bin/bash
set -e

# Iniciar SQL Server en segundo plano
/opt/mssql/bin/sqlservr &

# Esperar a que el servicio esté listo
echo "Esperando a que SQL Server esté disponible..."
sleep 20  # Ajusta el tiempo según sea necesario

# Ejecutar el script SQL si existe
if [ -f /script-ini.sql ]; then
    echo "Ejecutando script de inicialización..."
    /opt/mssql-tools/bin/sqlcmd -S localhost -U sa -P Password2025 -d master -i /script-ini.sql
fi

# Mantener el contenedor en ejecución
wait
