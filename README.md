# Sistema de Inventario Castores

## IDE utilizado
- Visual Studio Code v1.102.2

## Versión del lenguaje de programación
- PHP 8.x

## DBMS utilizado
- MySQL (probado con MySQL 5.7 y 8.0)
- Gestor local recomendado: MAMP (Windows/Mac) con puertos:
    - Apache Port: 8888
    - MySQL: 8889


## Pasos para correr la aplicación

1. **Clona o descarga este repositorio en tu máquina local.**

2. **Abre la carpeta del proyecto en Visual Studio Code.**

3. **Configura la base de datos:**
   - Abre MAMP y asegúrate de que los servicios de Apache y MySQL estén activos.
   - Ingresa a phpMyAdmin (`http://localhost:8888/phpMyAdmin/`).
   - Importa el archivo [`SCRIPTS/db.sql`](SCRIPTS/db.sql) para crear la base de datos y las tablas.

4. **Configura la conexión a la base de datos:**
   - Edita el archivo [`config/database.php`](config/database.php) si es necesario.
   - Por defecto, los datos de conexión para MAMP en Windows son:
     - Host: `localhost`
     - Puerto: `8889`
     - Usuario: `root`
     - Contraseña: `root`

5. **Inicia el servidor local:**
   - Coloca la carpeta del proyecto dentro de la carpeta `htdocs` de MAMP.
   - Accede a la aplicación desde tu navegador:  
     `http://localhost:8888/proyecto-castores/views/login.php`

6. **Crea una cuenta y comienza a usar el sistema.**

---

**Notas:**
- Si tienes problemas de conexión, revisa los datos en `config/database.php`.
- El sistema requiere PHP 8 o superior.
- Para dudas o errores, revisa los mensajes en pantalla o la consola de MAMP.

---

## Autor

**Michelle Sanchez**
- GitHub:  [Myshelluwu](https://github.com/Myshelluwu)
- LinkedIn: [Michelle Sánchez Barba](https://www.linkedin.com/in/myshell-sanchez/)