<template>
    <div class="modal fade show" tabindex="-1" style="display: block;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ editMode ? "Edit" : "Create" }} Ingredient</h5>
            <button type="button" class="btn-close" @click="$emit('close')" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="saveIngredient">
              <div class="mb-3">
                <label for="ingredient-name" class="form-label">Ingredient Name</label>
                <input
                  type="text"
                  class="form-control"
                  id="ingredient-name"
                  v-model="ingredientData.name"
                  required
                />
              </div>
              <div class="mb-3">
                <label for="ingredient-cost-price" class="form-label">Cost Price</label>
                <input
                  type="number"
                  class="form-control"
                  id="ingredient-cost-price"
                  v-model="ingredientData.cost_price"
                  step="0.01"
                  required
                />
              </div>
              <div class="mb-3">
                <label for="ingredient-percentage" class="form-label">Randomisation Percentage</label>
                <input
                  type="number"
                  class="form-control"
                  id="ingredient-percentage"
                  v-model="ingredientData.randomisation_percentage"
                  min="0"
                  max="100"
                  required
                />
              </div>
              <div class="mb-3">
                <label for="ingredient-image" class="form-label">Image</label>
                <input
                  type="file"
                  class="form-control"
                  id="ingredient-image"
                  @change="handleIngredientImageChange"
                />
              </div>
              <button type="submit" class="btn btn-primary">{{ editMode ? "Update" : "Create" }}</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { useIngredientsStore } from '@/stores/useIngredientsStore';
  
  export default {
    props: {
      ingredient: {
        type: Object,
        default: null,
      },
    },
    data() {
      return {
        ingredientData: {
          name: '',
          cost_price: '',
          randomisation_percentage: 0,
          image: null,
        },
        editMode: false,
      };
    },
    mounted() {
      if (this.ingredient) {
        this.editMode = true;
        this.ingredientData = { ...this.ingredient };
      }
    },
    methods: {
      async saveIngredient() {
        try {
          const store = useIngredientsStore();
          if (this.editMode) {
            await store.updateIngredient(this.ingredientData);
            alert('Ingredient updated successfully!');
          } else {
            await store.createIngredient(this.ingredientData);
            alert('Ingredient created successfully!');
          }

          this.ingredient = null;
          this.ingredientData = {};
          this.editMode = false;
          this.$emit('close'); 
        } catch (error) {
          console.error(error);
          alert('Failed to save ingredient.');
        }
      },
      handleIngredientImageChange(event) {
        const file = event.target.files[0];
        if (file) {
          this.ingredientData.image = file;
        }
      },
    },
  };
  </script>
  
  <style scoped>
  .modal {
    background-color: rgba(0, 0, 0, 0.5);
  }
  </style>
  