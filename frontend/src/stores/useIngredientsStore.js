import { defineStore } from 'pinia';
import axios from 'axios';


import { useToast } from 'vue-toastification'; 

export const useIngredientsStore = defineStore('ingredients', {
  state: () => ({
    ingredients: [],
  }),
  actions: {
    async fetchIngredients() {
      const toast = useToast();
      try {
        const response = await axios.get('http://localhost:8000/api/ingredients');
        this.ingredients = response.data;
      } catch (error) {
        toast.error('Error fetching ingredients:', error);
      }
    },
    async createIngredient(ingredient) {
      const toast = useToast();
      try {
        const response = await axios.post('http://localhost:8000/api/ingredients', ingredient, {
          headers: {
          'Content-Type': 'multipart/form-data',
          }
        })
        this.ingredients.push(response.data);
      } catch (error) {
        toast.error('Error adding ingredient:', error);
      }
    },
    async updateIngredient(ingredient) {
      const toast = useToast();
      try {
        const response = await axios.put(`http://localhost:8000/api/ingredients/${ingredient.id}`, ingredient);
        if(typeof ingredient.image === 'object'){
          try {
            await this.updateIngredientImage(ingredient.id, ingredient.image)
          } catch (error) {
            toast.error(error);
            throw error;
          }
        }
        
        const index = this.ingredients.findIndex(i => i.id === ingredient.id);
        if (index !== -1) this.ingredients[index] = response.data;
      } catch (error) {
        toast.error('Error updating ingredient:', error);
      }
    },
    async updateIngredientImage(ingredientId, imageFile) {
      const toast = useToast();
      const formData = new FormData();
      formData.append('image', imageFile);
    
      try {
        const response = await axios.put(`http://localhost:8000/api/ingredients/${ingredientId}/image`, formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        });
      } catch (error) {
        toast.error(error);
      }
    },
    async deleteIngredient(id) {
      const toast = useToast();
      try {
        await axios.delete(`http://localhost:8000/api/ingredients/${id}`);
        this.ingredients = this.ingredients.filter(i => i.id !== id);
      } catch (error) {
        toast.error(error);
      }
    },
  },
});
