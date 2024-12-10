import { defineStore } from 'pinia';
import axios from 'axios';

export const useIngredientsStore = defineStore('ingredients', {
  state: () => ({
    ingredients: [],
  }),
  actions: {
    async fetchIngredients() {
      try {
        const response = await axios.get('http://localhost:8000/api/ingredients');
        this.ingredients = response.data;
      } catch (error) {
        console.error('Error fetching ingredients:', error);
      }
    },
    async addIngredient(newIngredient) {
      try {
        const response = await axios.post('http://localhost:8000/api/ingredients', newIngredient);
        this.ingredients.push(response.data);
      } catch (error) {
        console.error('Error adding ingredient:', error);
      }
    },
    async deleteIngredient(id) {
      try {
        await axios.delete(`http://localhost:8000/api/ingredients/${id}`);
        this.ingredients = this.ingredients.filter((ingredient) => ingredient.id !== id);
      } catch (error) {
        console.error('Error deleting ingredient:', error);
      }
    },
  },
});
