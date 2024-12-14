<template>
    <div class="modal fade show" tabindex="-1" style="display: block;">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ editMode ? "Edit" : "Create" }} Pizza</h5>
            <button type="button" class="btn-close" @click="$emit('close')" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="savePizza" enctype="multipart/form-data">
              <div class="mb-3">
                <label for="pizza-name" class="form-label">Pizza Name</label>
                <input
                  type="text"
                  class="form-control"
                  id="pizza-name"
                  v-model="pizzaData.name"
                  required
                />
              </div>
  
              <div class="mb-3">
                <label class="form-label">Select Ingredients (Max 8)</label>
                <div v-if="ingredients && ingredients.length > 0">
                  <div
                    v-for="ingredient in ingredients"
                    :key="ingredient.id"
                    class="form-check"
                  >
                    <input
                      class="form-check-input"
                      type="checkbox"
                      :id="'ingredient-' + ingredient.id"
                      :value="ingredient"
                      :checked="isIngredientSelected(ingredient)"
                      @change="toggleIngredientSelection(ingredient)"
                      
                      :disabled="isIngredientDisabled(ingredient)"
                    />
                    <label
                      class="form-check-label"
                      :for="'ingredient-' + ingredient.id"
                    >
                      {{ ingredient.name }} ({{ ingredient.cost_price }}€)
                    </label>
                  </div>
                  <div v-if="selectedIngredients.length >= 8" class="text-danger mt-2">
                    Maximum of 8 ingredients allowed.
                  </div>
                </div>
                <div v-else>
                  <p>No ingredients available.</p>
                </div>
              </div>
  
              <div class="mb-3">
                <label class="form-label">Selling Price</label>
                <p class="form-control">
                  {{ sellingPrice }}€
                </p>
              </div>
  
              <div class="mb-3">
                <div v-if="editMode">
                  <img :src="pizza.image" class="edit-pizza-img" alt="">
                </div>
                <label for="pizza-image" class="form-label">Image</label>
                <input
                  type="file"
                  class="form-control"
                  id="pizza-image"
                  accept="image/png, image/jpeg, image/gif, image/jpg, image/svg+xml"
                  @change="handlePizzaImageChange"
                />
              </div>
  
              <button type="submit" class="btn btn-primary">
                {{ editMode ? "Update" : "Create" }}
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { useToast } from 'vue-toastification'; 
  import { useIngredientsStore } from '@/stores/useIngredientsStore';
  import { usePizzasStore } from '@/stores/usePizzasStore';
  
  export default {
    props: {
      pizza: {
        type: Object,
        default: null,
      },
    },
    data() {
      return {
        pizzaData: {
          name: '',
          image: null,
          ingredients: [],
        },
        ingredients: [],
        selectedIngredients: [],
        editMode: false,
        sellingPrice: 0,
      };
    },
    computed: {
    },
    watch: {
      selectedIngredients: {
        handler(newIngredients) {
          this.sellingPrice = this.calculateSellingPrice(newIngredients);
        },
        deep: true,
      }
    },
    async mounted() {
      const toast = useToast();
      const store = useIngredientsStore();
        try {
          await store.fetchIngredients();
          this.ingredients = store.ingredients;
        } catch (error) {
          toast.error('Failed to fetch ingredients:', error);
        }
      if (this.pizza) {
        this.editMode = true;
        try {
          this.pizzaData = {
            ...this.pizza
          };
          this.selectedIngredients = [...this.pizza.ingredients];
          
        } catch (error) {
          toast.error('Error mapping pizza ingredients:', error);
        }
      }
    },
    methods: {
      calculateSellingPrice() {
        const totalCost = this.selectedIngredients.reduce((sum, ingredient) => {
        const costPrice = Number(ingredient.cost_price);
        if (isNaN(costPrice)) {
          return sum;
        }
        return sum + costPrice;
      }, 0);
        let total = totalCost + totalCost * 0.5
        return Number.parseFloat(total).toFixed(2);
      },
      isIngredientDisabled(ingredient) {
        return (
          this.selectedIngredients.length >= 8 &&
          !this.selectedIngredients.includes(ingredient)
        );
      },
      async savePizza() {
        const toast = useToast();
        try {
          if (this.selectedIngredients.length === 0) {
            toast.error('You must select at least one ingredient.');
            return;
          }
          this.pizzaData.ingredients = this.selectedIngredients.map(ingredient => ingredient.id);
          this.pizzaData.selling_price = this.calculateSellingPrice();
          
          const store = usePizzasStore();
          if (this.editMode) {
            await store.updatePizza(this.pizzaData);
            toast.success('Pizza updated successfully!');
          } else {
            await store.addPizza(this.pizzaData);
            toast.success('Pizza created successfully!');
          }
          this.pizzaData = {};
          this.editMode = false;
          this.selectedIngredients = [];
          this.sellingPrice = 0;

          this.$emit('close');

        } catch (error) {
          toast.success('Failed to save pizza.');
        }
      },
      isIngredientSelected(ingredient) {
        return this.selectedIngredients.some(
          (selected) => selected.id === ingredient.id
        );
      },
      toggleIngredientSelection(ingredient) {
        const index = this.selectedIngredients.findIndex(
          (selected) => selected.id === ingredient.id
        );

        if (index !== -1) {
          this.selectedIngredients.splice(index, 1);
        } else if (this.selectedIngredients.length < 8) {
          this.selectedIngredients.push(ingredient);
        }
      },
      handlePizzaImageChange(event) {
        this.pizzaData.image = null;
        const file = event.target.files[0];
        if (file) {
          this.pizzaData.image = file;
        }
      },
    },
  };
  </script>
  
  <style scoped>
  .modal {
    background-color: rgba(0, 0, 0, 0.5);
  }
  .edit-pizza-img {
    width: 20%;
  }
  </style>
  