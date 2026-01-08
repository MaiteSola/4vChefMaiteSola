# 🎯 API 4V CHEF - 100% Compatible con OpenAPI YAML

## ✅ Cambios Completados

Tu API ahora cumple **100% con el YAML de OpenAPI** usando nombres con guiones (kebab-case) en JSON.

---

## 📍 Endpoints Disponibles

### **1. Recetas (Recipes)**

#### `GET /recipes` - Listar recetas

```bash
# Todas las recetas
curl http://localhost:8000/recipes

# Filtrar por tipo
curl http://localhost:8000/recipes?type=1
```

**Respuesta (200):**

```json
[
  {
    "id": 1,
    "title": "Tiramisu",
    "number-diner": 4,
    "type": {
      "id": 1,
      "name": "Postre",
      "description": "Para endulzar un buen menú"
    },
    "ingredients": [
      {
        "id": 1,
        "name": "Sugar",
        "quantity": "250.5",
        "unit": "gr"
      }
    ],
    "steps": [
      {
        "id": 1,
        "order": 1,
        "description": "Mix the Eggs with the Sugar"
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
        "quantity": 3.5
      }
    ],
    "rating": {
      "number-votes": 255,
      "rating-avg": 4.2
    }
  }
]
```

---

#### `POST /recipes` - Crear receta

```bash
curl -X POST http://localhost:8000/recipes \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Tiramisu",
    "number-diner": 4,
    "type-id": 1,
    "ingredients": [
      {
        "name": "Sugar",
        "quantity": "250.5",
        "unit": "gr"
      },
      {
        "name": "Eggs",
        "quantity": "3",
        "unit": "units"
      }
    ],
    "steps": [
      {
        "order": 1,
        "description": "Mix the Eggs with the Sugar"
      },
      {
        "order": 2,
        "description": "Add the mascarpone"
      }
    ],
    "nutrients": [
      {
        "type-id": 1,
        "quantity": 3.5
      },
      {
        "type-id": 2,
        "quantity": 250
      }
    ]
  }'
```

**Respuesta (200):** Receta completa creada con todos los datos

**Error (400):**

```json
{
  "code": 400,
  "description": "Recipe type does not exist"
}
```

---

#### `POST /recipes/{recipeId}/rating/{rate}` - Valorar receta

```bash
# Valorar con 4 estrellas la receta con ID 5
curl -X POST http://localhost:8000/recipes/5/rating/4
```

**Parámetros:**

- `recipeId`: ID de la receta (integer)
- `rate`: Puntuación de 0 a 5 (integer)

**Respuesta (200):** Receta con rating actualizado

**Errores (400):**

```json
// Puntuación inválida
{
  "code": 400,
  "description": "Rating must be between 0 and 5"
}

// Ya votaste
{
  "code": 400,
  "description": "You have already rated this recipe"
}

// Receta no existe
{
  "code": 400,
  "description": "Recipe not found"
}
```

---

#### `DELETE /recipes/{recipeId}` - Borrar receta (soft delete)

```bash
curl -X DELETE http://localhost:8000/recipes/5
```

**Respuesta (200):** Receta marcada como eliminada

**Error (400):**

```json
{
  "code": 400,
  "description": "Recipe not found or already deleted"
}
```

---

### **2. Tipos de Recetas (Recipe Types)**

#### `GET /recipe-types` - Listar tipos de recetas

```bash
curl http://localhost:8000/recipe-types
```

**Respuesta (200):**

```json
[
  {
    "id": 1,
    "name": "Postre",
    "description": "Para endulzar un buen menú"
  },
  {
    "id": 2,
    "name": "Entrante",
    "description": "Primer plato"
  }
]
```

---

### **3. Tipos de Nutrientes (Nutrient Types)**

#### `GET /nutrient-types` - Listar tipos de nutrientes

```bash
curl http://localhost:8000/nutrient-types
```

**Respuesta (200):**

```json
[
  {
    "id": 1,
    "name": "Proteins",
    "unit": "gr"
  },
  {
    "id": 2,
    "name": "Carbohydrates",
    "unit": "gr"
  },
  {
    "id": 3,
    "name": "Calories",
    "unit": "kcal"
  }
]
```

---

## 🔑 Schemas JSON

### **Recipe** (Respuesta completa)

```typescript
{
  "id": number,
  "title": string,
  "number-diner": number,
  "type": RecipeType,
  "ingredients": Ingredient[],
  "steps": Step[],
  "nutrients": Nutrient[],
  "rating": Rating
}
```

### **RecipeNew** (Crear receta)

```typescript
{
  "title": string,
  "number-diner": number,
  "type-id": number,
  "ingredients": IngredientNew[],
  "steps": StepNew[],
  "nutrients": NutrientNew[]
}
```

### **Ingredient**

```typescript
{
  "id": number,        // Solo en respuestas
  "name": string,
  "quantity": number,
  "unit": string
}
```

### **Step**

```typescript
{
  "id": number,         // Solo en respuestas
  "order": number,
  "description": string
}
```

### **Nutrient**

```typescript
{
  "id": number,         // Solo en respuestas
  "type": NutrientType,
  "quantity": number
}
```

### **NutrientNew** (Crear)

```typescript
{
  "type-id": number,
  "quantity": number
}
```

### **Rating**

```typescript
{
  "number-votes": number,
  "rating-avg": number
}
```

### **RecipeType**

```typescript
{
  "id": number,
  "name": string,
  "description": string
}
```

### **NutrientType**

```typescript
{
  "id": number,
  "name": string,
  "unit": string
}
```

### **Error**

```typescript
{
  "code": number,
  "description": string
}
```

---

## 📝 Notas Importantes

1. ✅ **Todos los nombres usan kebab-case** (con guiones): `number-diner`, `type-id`, `rating-avg`
2. ✅ **Los IDs son integers** en el YAML pero PHP los maneja como int
3. ✅ **Rating se calcula automáticamente** basado en las valoraciones existentes
4. ✅ **Soft delete**: Las recetas eliminadas se marcan con `deletedAt` pero no se borran físicamente
5. ✅ **Validación IP**: Solo puedes votar una vez por receta (por IP)
6. ✅ **Puntuaciones**: De 0 a 5 estrellas

---

## 🧪 Testing con Postman/Insomnia

Puedes importar el YAML directamente en Postman o usar estos ejemplos curl para probar todos los endpoints.

**URL Base:** `http://localhost:8000`

---

## ✨ Diferencias con Versión Anterior

| Antes          | Ahora                            |
| -------------- | -------------------------------- |
| `/recetas`     | `/recipes`                       |
| `comensales`   | `number-diner`                   |
| `tipoId`       | `type-id`                        |
| `ingredientes` | `ingredients`                    |
| `pasos`        | `steps`                          |
| `nutrientes`   | `nutrients`                      |
| `nombre`       | `name`                           |
| `cantidad`     | `quantity`                       |
| `unidad`       | `unit`                           |
| `orden`        | `order`                          |
| `descripcion`  | `description`                    |
| N/A            | `rating` (nuevo campo calculado) |

---

**¡Tu API ahora coincide 100% con el OpenAPI YAML! 🎉**
