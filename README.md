# 4VChef API

API REST para la gestión de recetas culinarias, desarrollada con Symfony 7.3. Esta aplicación permite crear, consultar y valorar recetas, cumpliendo estrictamente con la especificación OpenAPI proporcionada.

## 🚀 Requisitos Previo

Asegúrate de tener instalado en tu sistema:

- **PHP** >= 8.2 (con extensiones `intl`, `pdo_mysql`, `xsl`)
- **Composer** (Gestor de dependencias)
- **Symfony CLI** (Recomendado para ejecutar el servidor local)
- **Base de Datos**: MySQL o MariaDB.

## 📦 Instalación

1.  **Clonar el repositorio** (o extraer el ZIP):

    ```bash
    git clone https://github.com/maitesola/4vchef-api.git
    cd 4vchef-api
    ```

2.  **Instalar dependencias**:

    ```bash
    composer install
    ```

    > _Nota: Este proceso actualizará automáticamente Symfony a la versión 7.3.x para evitar vulnerabilidades conocidas._

3.  **Configurar Base de Datos**:

    - Copia el archivo `.env` a un nuevo archivo `.env.local` (opcional, pero recomendado).
    - Edita la variable `DATABASE_URL` con tus credenciales:

    ```env
    DATABASE_URL="mysql://usuario:contraseña@127.0.0.1:3306/4vchef?serverVersion=8.0&charset=utf8mb4"
    ```

4.  **Crear la Base de Datos**:

    ```bash
    php bin/console doctrine:database:create
    ```

5.  **Ejecutar Migraciones**:
    Crea las tablas necesarias en la base de datos:
    ```bash
    php bin/console doctrine:migrations:migrate
    ```

## 🧪 Carga de Datos de Prueba (Fixtures)

Para probar la API con datos reales (recetas como "Tiramisú" o "Paella", tipos de nutrientes, etc.), hemos preparado un conjunto de datos iniciales.

Ejecuta el siguiente comando para borrar la base de datos actual y cargar los datos de prueba:

```bash
php bin/console doctrine:fixtures:load --no-interaction
```

Esto creará:

- Recetas reales de ejemplo (Tiramisú, Paella, Gazpacho...).
- Tipos de receta: Postre, Principal, Entrante.
- Tipos de nutriente: Proteínas, Kcal, Grasas, etc.
- Una receta "borrada lógicamente" para pruebas de filtrado.

## 🛠️ Ejecución

Inicia el servidor local de Symfony:

```bash
symfony server:start
```

La API estará disponible en `http://localhost:8000` (o el puerto que te asigne).

## ✅ Pruebas (Testing)

El proyecto incluye tests unitarios y funcionales con PHPUnit para asegurar que cumple con los requisitos.

1.  **Preparar BBDD de Test**:

    ```bash
    php bin/console --env=test doctrine:database:create
    php bin/console --env=test doctrine:migrations:migrate
    php bin/console --env=test doctrine:fixtures:load --no-interaction
    ```

2.  **Ejecutar los tests**:
    ```bash
    php bin/phpunit
    ```

## 📚 Documentación de API

La API sigue estrictamente el archivo `4VChef2.yaml`.

### Endpoints Principales

- `GET /recipes`: Listar recetas activas (filtro opcional `?type=ID`).
- `POST /recipes`: Crear nueva receta (validación estricta de datos).
- `DELETE /recipes/{id}`: Borrado lógico de receta.
- `POST /recipes/{id}/rating/{rate}`: Puntuar receta (0-5 estrellas).
- `GET /recipe-types`: Catálogo de tipos de receta.
- `GET /nutrient-types`: Catálogo de tipos de nutriente.

### Postman

Se incluye un archivo `4vChef_Postman_Collection.json` en la raíz para importar y probar rápidamente todos los endpoints.

## ⚠️ Notas de Desarrollo

- Los mensajes de error de validación están traducidos al **Castellano** (`es`).
- Se ha verificado que no existe código de depuración "basura" (`dd()`, `dump()`, etc.).
- El proyecto utiliza `symfony/serializer` con anotaciones `#[SerializedName]` para cumplir con el formato JSON exigido (ej: `number-diner` en lugar de `numberDiner`).

---

**Desarrollado para 4vCHEF - 2º DAM Desarrollo Web**
