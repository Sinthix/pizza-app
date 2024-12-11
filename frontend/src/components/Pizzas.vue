<template>
  <div>
    <div class="d-flex justify-content-between mb-3">
        <h2>Pizzas</h2>
        <div>
          <button class="btn btn-primary" @click="createRandomPizza">Generate Random Pizza</button>
          <button class="btn btn-success" @click="showCreatePizzaModal">Create Pizza</button>
        </div>
      </div>
      <div v-if="pizzas && pizzas.length > 0">
        <div class="row">
          <div class="col-md-4" v-for="pizza in pizzas" :key="pizza.id">
            <div class="card mb-4">
              <img
                :src="pizza.image"
                :alt="pizza.name"
                class="card-img-top"
                style="height: 200px; object-fit: cover"
              />
              <div class="card-body">
                <h5 class="card-title">{{ pizza.name }}</h5>
                <p class="card-text">Price: ${{ pizza.selling_price }}</p>
                <button class="btn btn-info" @click="viewPizzaDetails(pizza.id)">View Details</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div v-else>
        <p>No pizzas available. Please create one.</p>
      </div>
  
      <PizzaModal v-if="showCreatePizzaModalFlag" @close="showCreatePizzaModal" />
    </div>
  </template>
  
  <script>
  import { usePizzasStore } from '@/stores/usePizzasStore';
  import PizzaModal from './PizzaModal.vue';
  
  export default {
    components: {
      PizzaModal,
    },
    data() {
      return {
        pizzas: [],
        showCreatePizzaModalFlag: false,
      };
    },
    methods: {
      async createRandomPizza() {
        const store = usePizzasStore();
        const randomPizza = await store.generateRandomPizza();
        this.pizzas.push(randomPizza);
      },
      async viewPizzaDetails(pizzaId) {
        const pizza = this.pizzas.find((p) => p.id === pizzaId);
        alert(JSON.stringify(pizza));
      },
      showCreatePizzaModal() {
        this.showCreatePizzaModalFlag = !this.showCreatePizzaModalFlag;
      },
    },
    async mounted() {
      const store = usePizzasStore();
      this.pizzas = await store.fetchPizzas();
      try {
        await store.fetchPizzas();
        this.pizzas = store.pizzas;
      } catch (error) {
        console.error('Failed to fetch pizzas:', error);
      }
    },
  };
  </script>
  
  <style scoped>
  </style>
  