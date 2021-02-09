# NIVELICS - PRUEBA TECNICA

Desarrollo de la prueba técnica para la empresa NIVELICS utilizando Laravel 8 y trabajando bajo la metodología TDD.

## Instalación

1. Clone el proyecto.

```bash
git clone https://github.com/edtlsoft/nivelics.git
```


2. Ingrese al directorio que se le acabo de crear

```bash
cd nivelics
```

3. Instale las dependencias de php con composer

```bash
composer install
```

4. Instale las dependencias de JavaScript con npm

```bash
npm install
```

5. Compile los archivos JavaScript

```bash
npm run dev
```

6. Copie el archivo .env.example a .env y remplace los valores con los de su configuracion

```bash
cp .env.example .env
```

7. Genere la key para el proyecto

```bash
php artisan key:generate
```

8. Ejecute las migraciones y los seeders

```bash
php artisan migrate --seed
```

9. Ejecute los feature tests

```bash
php aritisan test
```

10. Instale los drivers pertinentes para chrome

```bash
php artisan dusk
```

11. Actualice del archivo .env.dusk.local con los valores de su configuracion

```bash
.env.dusk.local
```

12. Ejecute el servidor de Laravel

```bash
php artisan serve
```

12. Asegurese de que la variable de entorno APP_URL contenga la url del servidor ejecutado en el paso anterior

```bash
APP_URL=http://127.0.0.1:8000
```

13. Ejecute los browsers tests

```bash
php artisan dusk
```

14. Ingrese al link que se le muestra en la terminal
```bash
http://127.0.0.1:8000/
```

15. Al ejecutar los seeders se le creo un usuario con las siguientes credenciales
```bash
Usuario: edward@edtlsoft.com
Contraseña: 123
```
