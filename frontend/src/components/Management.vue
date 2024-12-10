<template>
  <div class="container mt-4">
    <h2 class="text-center mb-4">Pizza Management</h2>

    <ul class="nav nav-tabs" id="managementTabs" role="tablist">
      <li class="nav-item" role="presentation">
        <button
          class="nav-link"
          id="pizzas-tab"
          data-bs-toggle="tab"
          data-bs-target="#pizzas"
          type="button"
          role="tab"
          aria-controls="pizzas"
          aria-selected="false"
        >
          Pizzas
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button
          class="nav-link active"
          id="ingredients-tab"
          data-bs-toggle="tab"
          data-bs-target="#ingredients"
          type="button"
          role="tab"
          aria-controls="ingredients"
          aria-selected="true"
        >
          Ingredients
        </button>
      </li>
    </ul>

    <div class="tab-content mt-3">
      <div
        class="tab-pane fade show active"
        id="ingredients"
        role="tabpanel"
        aria-labelledby="ingredients-tab"
      >
        <h3>Manage Ingredients</h3>
        <form @submit.prevent="addIngredient" class="row g-3">
          <div class="col-md-4">
            <input
              type="text"
              class="form-control"
              v-model="newIngredient.name"
              placeholder="Ingredient Name"
              required
            />
          </div>
          <div class="col-md-4">
            <button type="submit" class="btn btn-primary">Add Ingredient</button>
          </div>
        </form>

        <ul class="list-group mt-3">
          <li
            v-for="ingredient in ingredientsStore.ingredients"
            :key="ingredient.id"
            class="list-group-item d-flex justify-content-between align-items-center"
          >
            {{ ingredient.name }}
            <button
              class="btn btn-sm btn-danger"
              @click="deleteIngredient(ingredient.id)"
            >
              Delete
            </button>
          </li>
        </ul>
      </div>

      <div
        class="tab-pane fade"
        id="pizzas"
        role="tabpanel"
        aria-labelledby="pizzas-tab"
      >
        <h3>Manage Pizzas</h3>
        <form @submit.prevent="addPizza" class="row g-3">
          <div class="col-md-4">
            <input
              type="text"
              class="form-control"
              v-model="newPizza.name"
              placeholder="Pizza Name"
              required
            />
          </div>
          <div class="col-md-4">
            <button type="submit" class="btn btn-primary">Add Pizza</button>
          </div>
        </form>

        <ul class="list-group mt-3">
          <li
            v-for="pizza in pizzasStore.pizzas"
            :key="pizza.id"
            class="list-group-item d-flex justify-content-between align-items-center"
          >
            {{ pizza.name }}
            <button
              class="btn btn-sm btn-danger"
              @click="deletePizza(pizza.id)"
            >
              Delete
            </button>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import { useIngredientsStore } from '@/stores/useIngredientsStore';
import { usePizzasStore } from '@/stores/usePizzasStore';

export default {
  setup() {
    const ingredientsStore = useIngredientsStore();
    const pizzasStore = usePizzasStore();

    ingredientsStore.fetchIngredients();
    pizzasStore.fetchPizzas();

    const newIngredient = { name: '' };
    const newPizza = { name: '' };

    const addIngredient = () => {
      ingredientsStore.addIngredient(newIngredient);
      newIngredient.name = '';
    };

    const deleteIngredient = (id) => {
      ingredientsStore.deleteIngredient(id);
    };

    const addPizza = () => {
      pizzasStore.addPizza(newPizza);
      newPizza.name = '';
    };

    const deletePizza = (id) => {
      pizzasStore.deletePizza(id);
    };

    return {
      ingredientsStore,
      pizzasStore,
      newIngredient,
      newPizza,
      addIngredient,
      deleteIngredient,
      addPizza,
      deletePizza,
    };
  },
};
</script>
