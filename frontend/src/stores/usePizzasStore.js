import { defineStore } from 'pinia';
import axios from 'axios';

import { useToast } from 'vue-toastification'; 

export const usePizzasStore = defineStore('pizzas', {
  state: () => ({
    pizzas: [],
  }),
  actions: {
    async fetchPizzas() {
      const toast = useToast();
      try {
        const response = await axios.get('http://localhost:8000/api/pizzas');
        this.pizzas = response.data;
      } catch (error) {
        toast.error('Error fetching pizzas:', error);
      }
    },
    async addPizza(newPizza) {
      const toast = useToast();
      try {
        const response = await axios.post('http://localhost:8000/api/pizzas', newPizza, {
          headers: {
            'content-type': 'multipart/form-data'
          }
        })
        this.pizzas.push(response.data);
      } catch (error) {
        toast.error('Error creating pizza:');
      }
    },
    async updatePizza(newPizza) {
      const toast = useToast();
      try {
        const response = await axios.put('http://localhost:8000/api/pizzas/' + newPizza.id, newPizza);
        if(typeof newPizza.image === 'object'){
          try {
            await this.updatePizzaImage(newPizza.id, newPizza.image)
          } catch (error) {
            toast.error(error);
          }
        }
        
        return response.data;
      } catch (error) {
        toast.error(error);
        throw error;
      }
    },
    async generateRandomPizza() {
      const toast = useToast();
      try {
        const response = await axios.post('http://localhost:8000/api/pizzas/random');
        const newPizza = response.data;
        this.pizzas.push(newPizza);
        return newPizza;
      } catch (error) {
        toast.error('Error generating random pizza:', error);
      }
    },
    async updatePizzaImage(pizzaId, imageFile) {
      const toast = useToast();
      const formData = new FormData();
      formData.append('image', imageFile);
    
      try {
        const response = await axios.put(`http://localhost:8000/api/pizzas/${pizzaId}/image`, formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        });
        toast.success('Pizza image updated');
      } catch (error) {
        toast.error('Failed to update pizza image:', error);
      }
    },
    async deletePizza(id) {
      const toast = useToast();
      try {
        await axios.delete(`http://localhost:8000/api/pizzas/${id}`);
        this.pizzas = this.pizzas.filter((pizza) => pizza.id !== id);
      } catch (error) {
        toast.error('Error deleting pizza:', error);
      }
    },
  },
});
