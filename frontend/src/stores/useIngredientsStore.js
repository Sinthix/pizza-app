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
    async createIngredient(ingredient) {
      try {
        const response = await axios.post('http://localhost:8000/api/ingredients', ingredient, {
          headers: {
          'Content-Type': 'multipart/form-data',
          }
        })
        this.ingredients.push(response.data);
      } catch (error) {
        console.error('Error adding pizza:', error);
      }
    },
    async updateIngredient(id, ingredient) {
      try {
        const response = await axios.put(`http://localhost:8000/api/ingredients/${id}`, ingredient);
        const index = this.ingredients.findIndex(i => i.id === id);
        if (index !== -1) this.ingredients[index] = response.data;
      } catch (error) {
        console.error('Error updating ingredient:', error);
      }
    },
    async deleteIngredient(id) {
      try {
        await axios.delete(`http://localhost:8000/api/ingredients/${id}`);
        this.ingredients = this.ingredients.filter(i => i.id !== id);
      } catch (error) {
        console.error('Error deleting ingredient:', error);
      }
    },
  },
});
