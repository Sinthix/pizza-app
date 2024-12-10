<template>
    <div>
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Ingredients</h3>
        <button class="btn btn-success" @click="showCreateIngredientModal">Add Ingredient</button>
      </div>
      <div v-if="ingredients.length > 0">
        <div class="list-group">
          <a
            v-for="ingredient in ingredients"
            :key="ingredient.id"
            class="list-group-item list-group-item-action"
            @click="editIngredient(ingredient)"
          >
            {{ ingredient.name }} - ${{ ingredient.cost_price.toFixed(2) }}
          </a>
        </div>
      </div>
      <div v-else>
        <p>No ingredients available.</p>
      </div>
      <IngredientModal
        v-if="showIngredientModal"
        :ingredient="selectedIngredient"
        @close="closeIngredientModal"
      />
    </div>
  </template>
  
  <script>
  import { useIngredientsStore } from '@/stores/useIngredientsStore';
  import IngredientModal from './IngredientModal.vue';
  
  export default {
    components: { IngredientModal },
    data() {
      return {
        showIngredientModal: false,
        selectedIngredient: null,
      };
    },
    computed: {
      ingredients() {
        const store = useIngredientsStore();
        return store.ingredients;
      },
    },
    methods: {
      showCreateIngredientModal() {
        this.selectedIngredient = null;
        this.showIngredientModal = true;
      },
      editIngredient(ingredient) {
        this.selectedIngredient = ingredient;
        this.showIngredientModal = true;
      },
      closeIngredientModal() {
        this.showIngredientModal = false;
      },
    },
  };
  </script>
  