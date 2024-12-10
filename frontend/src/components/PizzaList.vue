<template>
    <div>
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Pizzas</h3>
        <div>
          <button class="btn btn-success me-2" @click="showCreatePizzaModal">Add Pizza</button>
          <button class="btn btn-primary" @click="generateRandomPizza">Generate Random Pizza</button>
        </div>
      </div>
      <div v-if="pizzas.length > 0">
        <div class="list-group">
          <a
            v-for="pizza in pizzas"
            :key="pizza.id"
            class="list-group-item list-group-item-action"
            @click="viewPizzaDetails(pizza)"
          >
            {{ pizza.name }} - ${{ pizza.selling_price.toFixed(2) }}
          </a>
        </div>
      </div>
      <div v-else>
        <p>No pizzas available.</p>
      </div>
      <PizzaModal v-if="showPizzaModal" @close="showPizzaModal = false" />
    </div>
  </template>
  
  <script>
  import { usePizzasStore } from '@/stores/usePizzasStore';
  import PizzaModal from './PizzaModal.vue';
  
  export default {
    components: { PizzaModal },
    data() {
      return {
        showPizzaModal: false,
      };
    },
    computed: {
      pizzas() {
        const store = usePizzasStore();
        return store.pizzas;
      },
    },
    methods: {
      showCreatePizzaModal() {
        this.showPizzaModal = true;
      },
      generateRandomPizza() {
        const store = usePizzasStore();
        store.generateRandomPizza();
        alert('Random pizza generated!');
      },
      viewPizzaDetails(pizza) {
        alert(`Name: ${pizza.name}\nSelling Price: $${pizza.selling_price.toFixed(2)}\nIngredients: ${pizza.ingredients.join(', ')}`);
      },
    },
  };
  </script>
  