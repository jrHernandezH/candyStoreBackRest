# Backen de la Aplicación 2.0.0

Esta es la segunda versión de la aplicacion Eccomerce de CandyStore, que propociona una API RESTFULL para interactuar con la base de datos y manejar las operaciones relacionadas con los modelos de la base de datos. El principal cambio es que dejamos atras el RESTLESS para pasar a RESTFULL.

## Estructura del Proyecto

El proyecto está organizado en las siguientes carpetas:

- **models:** Contiene los modelos de datos que representan las tablas de la base de datos.
- **controllers:** Aquí se encuentran los controladores que manejan las solicitudes HTTP y proporcionan las respuestas JSON.
- **database:** En esta carpeta se encuentran los scripts de base de datos para inicializar, migrar o actualizar la base de datos.

## Contenido de las Carpetas

### models

- `usuario.js`: Define el modelo de datos para los usuarios.
- `producto.js`: Define el modelo de datos para los productos.
- `pedido.js`: Define el modelo de datos para los pedidos.
- Otros archivos de modelos según sea necesario para la aplicación.

### controllers

- `usuariosController.js`: Contiene las API para manejar las operaciones relacionadas con los usuarios.
- `productosController.js`: Contiene las API para manejar las operaciones relacionadas con los productos.
- `pedidosController.js`: Contiene las API para manejar las operaciones relacionadas con los pedidos.
- Otros archivos de controladores según sea necesario para la aplicación.

### database

- `script.sql`: Script SQL para inicializar la base de datos.
- `migracion_v1_v2.sql`: Script SQL para migrar de la versión 1 a la versión 2 de la base de datos.
- `backup_2022_04_08.sql`: Copia de seguridad de la base de datos realizada el 8 de abril de 2022.
- Otros archivos de scripts de base de datos según sea necesario para la aplicación.

## Uso

Para iniciar el servidor de desarrollo backend se utilizo la herramienta de XAMPP en donde la otra diferencia es hacerlo portable y no depender directamente del Sistema Operativo de Ubuntu en donde se desarrollo
