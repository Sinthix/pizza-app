<template>
  <div>
    <div class="d-flex justify-content-between mb-3">
      <h2>Ingredients</h2>
      <button class="btn btn-success" @click="showCreateIngredientModal">Create Ingredient</button>
    </div>
    <div v-if="ingredients && ingredients.length > 0">
      <div class="row">
        <div class="col-md-4" v-for="ingredient in ingredients" :key="ingredient.id">
          <div class="card mb-4">
            <img
              :src="ingredient.image_url"
              :alt="ingredient.name"
              class="card-img-top"
              style="height: 200px; object-fit: cover"
            />
            <div class="card-body">
              <h5 class="card-title">{{ ingredient.name }}</h5>
              <p class="card-text">Cost Price: ${{ ingredient.cost_price }}</p>
              <p class="card-text">Randomization Percentage: {{ ingredient.randomization_percentage }}%</p>
              <button class="btn btn-info" @click="viewIngredientDetails(ingredient.id)">View Details</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-else>
      <p>No ingredients available. Please create one.</p>
    </div>

    <IngredientModal v-if="showCreateIngredientModalFlag" @close="showCreateIngredientModal" />
  </div>
</template>

<script>
import { useIngredientsStore } from '@/stores/useIngredientsStore';
import IngredientModal from './IngredientModal.vue';

export default {
  components: {
    IngredientModal,
  },
  data() {
    return {
      ingredients: [],
      showCreateIngredientModalFlag: false,
    };
  },
  methods: {
    async viewIngredientDetails(ingredientId) {
      const ingredient = this.ingredients.find((i) => i.id === ingredientId);
      alert(JSON.stringify(ingredient));
    },
    showCreateIngredientModal() {
      this.showCreateIngredientModalFlag = !this.showCreateIngredientModalFlag;
    },
  },
  async mounted() {
    const store = useIngredientsStore();
    try {
      await store.fetchIngredients();
      this.ingredients = store.ingredients;
    } catch (error) {
      console.error('Failed to fetch ingredients:', error);
    }
  },
};
</script>

<style scoped>
</style>
