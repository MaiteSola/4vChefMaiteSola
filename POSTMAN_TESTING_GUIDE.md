# 📮 Guía de Pruebas con Postman - API 4V CHEF

## 🚀 Cómo Importar la Colección

### Opción 1: Importar Archivo JSON

1. Abre **Postman**
2. Click en **Import** (esquina superior izquierda)
3. Selecciona el archivo `4vChef_Postman_Collection.json`
4. Click en **Import**

### Opción 2: Importar desde el YAML

1. En Postman, click en **Import**
2. Selecciona el archivo `4VChef2.yaml`
3. Postman generará automáticamente la colección desde el OpenAPI spec

---

## 📋 Orden Sugerido de Pruebas

### **PASO 1: Verificar Datos Base** 🔍

Antes de crear recetas, verifica que existan tipos:

1. **GET - List All Recipe Types**

   - ✅ Debe devolver tipos como "Postre", "Entrante", etc.
   - 📝 Anota los IDs que te devuelve (necesarios para crear recetas)

2. **GET - List All Nutrient Types**
   - ✅ Debe devolver nutrientes como "Proteínas", "Carbohidratos"
   - 📝 Anota los IDs para usarlos en recetas

---

### **PASO 2: Crear Recetas** ✏️

3. **POST - Create New Recipe (Simple)**

   - ⚠️ **IMPORTANTE**: Antes de ejecutar, verifica que `type-id` existe
   - Edita el JSON si es necesario con un ID válido
   - ✅ Respuesta esperada: 200 OK con la receta completa
   - 📝 Anota el `id` de la receta creada

4. **POST - Create Recipe with Nutrients**
   - ⚠️ Verifica que los `type-id` en `nutrients` existan
   - ✅ Respuesta: 200 OK con receta + nutrientes

---

### **PASO 3: Listar y Filtrar** 📖

5. **GET - List All Recipes**

   - ✅ Debe mostrar las recetas que creaste
   - Verifica que los campos usan kebab-case: `number-diner`, `ingredients`, etc.

6. **GET - Filter Recipes by Type**
   - Cambia el parámetro `type` al ID que quieras filtrar
   - ✅ Solo debe devolver recetas de ese tipo

---

### **PASO 4: Valoraciones** ⭐

7. **POST - Rate Recipe (5 stars)**

   - ⚠️ Cambia el ID de receta (`/recipes/1/rating/5`) si es necesario
   - ✅ Primera valoración debe funcionar correctamente
   - Verifica que la respuesta incluya el `rating` actualizado

8. **POST - Rate Recipe (3 stars)** ❌
   - ⚠️ Usa el mismo ID de receta
   - ❌ **DEBE FALLAR** con error 400: "You have already rated this recipe"
   - Esto prueba que la validación por IP funciona

---

### **PASO 5: Borrado** 🗑️

9. **DELETE - Remove Recipe**
   - ⚠️ Usa un ID de receta existente
   - ✅ Respuesta: 200 OK con la receta
   - Luego ejecuta **GET - List All Recipes** para verificar que ya no aparece

---

### **PASO 6: Casos de Error** ❌

10. **Error - Invalid Recipe Type**

    - ✅ DEBE devolver: `{"code": 400, "description": "Recipe type does not exist"}`

11. **Error - Invalid Rating**

    - ✅ DEBE devolver: `{"code": 400, "description": "Rating must be between 0 and 5"}`

12. **Error - Recipe Not Found**
    - ✅ DEBE devolver: `{"code": 400, "description": "Recipe not found or already deleted"}`

---

## ✅ Checklist de Verificación

Marca cada punto al verificarlo:

### Formato de Respuestas

- [ ] Los campos numéricos de salida usan kebab-case (`number-diner`, `rating-avg`)
- [ ] Los ingredientes tienen: `name`, `quantity`, `unit`
- [ ] Los pasos tienen: `order`, `description`
- [ ] Los nutrientes tienen: `id`, `type`, `quantity`
- [ ] Existe el campo `rating` con `number-votes` y `rating-avg`

### Funcionalidad

- [ ] Crear receta sin nutrientes funciona
- [ ] Crear receta con nutrientes funciona
- [ ] Listar todas las recetas funciona
- [ ] Filtrar por tipo funciona
- [ ] Valorar receta (primera vez) funciona
- [ ] Valorar receta (segunda vez) falla correctamente
- [ ] Borrado lógico funciona
- [ ] Recetas borradas no aparecen en listados

### Validaciones

- [ ] Tipo de receta inválido retorna error 400
- [ ] Puntuación fuera de rango (0-5) retorna error 400
- [ ] Receta inexistente retorna error 400
- [ ] Doble valoración desde misma IP retorna error 400

---

## 🔧 Tips para Testing

### Cambiar IDs en las Requests

Si tus IDs de BD son diferentes, edita las requests:

1. Click en la request
2. En el Body o URL, cambia los valores
3. Click en **Send**

### Ver las Respuestas Formateadas

1. Ejecuta una request
2. En la pestaña de respuesta, click en **Pretty**
3. Selecciona **JSON** para ver el formato correcto

### Variables de Entorno (Opcional)

Si quieres cambiar el puerto o host:

1. En Postman, ve a **Environments**
2. Edita la variable `baseUrl`
3. Cambia `http://localhost:8000` a tu URL

---

## 🐛 Problemas Comunes

### Error: "Connection refused"

- ✅ Verifica que Symfony está corriendo: `symfony server:start`
- ✅ Comprueba que el puerto es 8000

### Error: "Recipe type does not exist"

- ✅ Ejecuta primero **GET - List All Recipe Types**
- ✅ Usa un `type-id` válido en el POST

### Error: "Undefined type_id"

- ✅ Verifica que usas `type-id` (con guión) y NO `type_id` o `typeId`

### No aparece el campo "rating"

- ✅ Limpia la caché: `symfony console cache:clear`
- ✅ Verifica que la receta tiene valoraciones

---

## 📊 Ejemplo de Respuesta Completa

```json
{
  "id": 1,
  "title": "Tiramisu Clásico",
  "number-diner": 4,
  "type": {
    "id": 1,
    "name": "Postre",
    "description": "Para endulzar un buen menú"
  },
  "ingredients": [
    {
      "id": 1,
      "name": "Azúcar",
      "quantity": "250",
      "unit": "gr"
    }
  ],
  "steps": [
    {
      "id": 1,
      "order": 1,
      "description": "Batir las yemas con el azúcar"
    }
  ],
  "nutrients": [
    {
      "id": 1,
      "type": {
        "id": 1,
        "name": "Proteins",
        "unit": "gr"
      },
      "quantity": 12.5
    }
  ],
  "rating": {
    "number-votes": 2,
    "rating-avg": 4.0
  }
}
```

---

**¡Todo listo para probar tu API! 🎉**

Si encuentras algún problema, revisa que:

1. Symfony está corriendo
2. Los IDs que usas existen en tu base de datos
3. Los nombres de campos usan kebab-case (`type-id`, no `typeId`)
