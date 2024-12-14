<template>
  <div>
    <div v-if="loading" class="loader-container">
      <div class="loader"></div>
    </div>
    <div v-else>
    <div class="d-flex justify-content-between mb-3">
      <h2>Ingredients</h2>
      <button class="btn btn-outline-dark" @click="showCreateIngredientModal">Create Ingredient</button>
    </div>
    <div v-if="ingredients && ingredients.length > 0">
      <div class="row">
        <div class="col-md-4" v-for="ingredient in ingredients" :key="ingredient.id">
          <div class="card mb-4">
            <img
              :src="ingredient.image"
              :alt="ingredient.name"
              class="card-img-top"
              style="height: 200px; object-fit: cover"
            />
            <div class="card-body">
              <h5 class="card-title">{{ ingredient.name }}</h5>
              <p class="card-text">Cost Price: {{ ingredient.cost_price }}€</p>
              <p class="card-text">Randomization Percentage: {{ ingredient.randomisation_percentage }}%</p>
              <button class="btn btn-outline-info me-2" @click="showIngredientDetails(ingredient)">View Details</button>
              <button class="btn btn-outline-secondary me-2" @click="showEditIngredientModal(ingredient)">Edit</button>
              <button class="btn btn-outline-danger" @click="confirmDeleteIngredient(ingredient.id)">Delete</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-else>
      <p>No ingredients available. Please create one.</p>
    </div>

    <IngredientModal 
      v-if="showCreateIngredientModalFlag" 
      :ingredient="currentIngredient"
      @close="showCreateIngredientModal" 
      />
  
    <IngredientDetails
        v-if="showIngredientDetailsFlag"
        :ingredient="currentIngredient"
        @close="closeIngredientDetailsModal"
      />
  </div>
  </div>
</template>

<script>
import { useToast } from 'vue-toastification';
import { useIngredientsStore } from '@/stores/useIngredientsStore';
import IngredientModal from './IngredientModal.vue';
import IngredientDetails from './IngredientDetails.vue';

export default {
  components: {
    IngredientModal,
    IngredientDetails
  },
  data() {
    return {
      ingredients: [],
      showCreateIngredientModalFlag: false,
      loading: false,
      showIngredientDetailsFlag: false,
      currentIngredient: false
    };
  },
  methods: {
    showCreateIngredientModal() {
      this.showCreateIngredientModalFlag = !this.showCreateIngredientModalFlag;
    },
    showEditIngredientModal(ingredient) {
        this.currentIngredient = ingredient;
        this.showCreateIngredientModalFlag = true;
    },
    closeIngredientDetailsModal() {
      this.showIngredientDetailsFlag = false;
      this.currentIngredient = null;
    },
    showIngredientDetails(ingredient) {
        this.currentIngredient = ingredient;
        this.showIngredientDetailsFlag = true;
    },
    async confirmDeleteIngredient(ingredientId) {
      const toast = useToast();
      const confirmDelete = confirm('Are you sure you want to delete this ingredient?');
      if (confirmDelete) {
        try {
          const store = useIngredientsStore();
          await store.deleteIngredient(ingredientId);
          this.ingredients = this.ingredients.filter((ingredient) => ingredient.id !== ingredientId);
          toast.success('Ingredient deleted successfully!');
        } catch (error) {
          toast.error('Failed to delete ingredient:', error);
        }
      }
    },
  },
  async mounted() {
    const toast = useToast();
    this.loading = true;
    const store = useIngredientsStore();
    try {
      await store.fetchIngredients();
      this.ingredients = store.ingredients;
    } catch (error) {
      toast.error('Failed to fetch ingredients:', error);
    } finally {
      this.loading = false;
    }
  },
};
</script>

<style scoped>
</style>
