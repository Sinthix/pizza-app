import { defineStore } from 'pinia';
import axios from 'axios';

export const usePizzasStore = defineStore('pizzas', {
  state: () => ({
    pizzas: [],
  }),
  actions: {
    async fetchPizzas() {
      try {
        const response = await axios.get('http://localhost:8000/api/pizzas');
        this.pizzas = response.data;
      } catch (error) {
        console.error('Error fetching pizzas:', error);
      }
    },
    async addPizza(newPizza) {
      try {
        const response = await axios.post('http://localhost:8000/api/pizzas', newPizza, {
          
        })
        this.pizzas.push(response.data);
      } catch (error) {
        console.error('Error adding pizza:', error);
      }
    },
    async updatePizza(newPizza) {
      try {
        const response = await axios.put('http://localhost:8000/api/pizzas/' + newPizza.id, newPizza);
        if(typeof newPizza.image === 'object'){
          try {
            await this.updatePizzaImage(newPizza.id, newPizza.image)
          } catch (error) {
            console.error(error);
            throw error;
          }
        }
        
        return response.data;
      } catch (error) {
        console.error(error);
        throw error;
      }
    },
    async generateRandomPizza() {
      try {
        const response = await axios.post('http://localhost:8000/api/pizzas/random');
        const newPizza = response.data;
        this.pizzas.push(newPizza);
        return newPizza;
      } catch (error) {
        console.error('Error generating random pizza:', error);
        throw error;
      }
    },
    async updatePizzaImage(pizzaId, imageFile) {
      const formData = new FormData();
      formData.append('image', imageFile);
    
      try {
        const response = await axios.put(`http://localhost:8000/api/pizzas/${pizzaId}/image`, formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        });
        console.log('Pizza image updated:', response.data);
      } catch (error) {
        console.error('Failed to update pizza image:', error);
      }
    },
    async deletePizza(id) {
      try {
        await axios.delete(`http://localhost:8000/api/pizzas/${id}`);
        this.pizzas = this.pizzas.filter((pizza) => pizza.id !== id);
      } catch (error) {
        console.error('Error deleting pizza:', error);
      }
    },
  },
});
