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
          headers: {
          'Content-Type': 'multipart/form-data',
          }
        })
        this.pizzas.push(response.data);
      } catch (error) {
        console.error('Error adding pizza:', error);
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
