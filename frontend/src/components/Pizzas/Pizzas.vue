<template>
  <div>
    <div v-if="loading" class="loader-container">
      <div class="loader"></div>
    </div>
    <div v-else>
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
                <button class="btn btn-info me-2" @click="showPizzaDetails(pizza)">View Details</button>
                <button class="btn btn-warning me-2" @click="showEditPizzaModal(pizza)">Edit</button>
                <button class="btn btn-danger" @click="confirmDeletePizza(pizza.id)">Delete</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div v-else>
        <p>No pizzas available. Please create one.</p>
      </div>
  
      <PizzaModal 
        v-if="showCreatePizzaModalFlag" 
        :pizza="currentPizza"
        @close="showCreatePizzaModal" 
      />

      <PizzaDetails
        v-if="showPizzaDetailsFlag"
        :pizza="currentPizza"
        @close="closePizzaDetailsModal"
      />
    </div>
    </div>
  </template>
  
  <script>
  import { usePizzasStore } from '@/stores/usePizzasStore';
  import PizzaModal from './PizzaModal.vue';
  import PizzaDetails from './PizzaDetails.vue';
  
  export default {
    components: {
      PizzaModal,
      PizzaDetails
    },
    data() {
      return {
        pizzas: [],
        showCreatePizzaModalFlag: false,
        showPizzaDetailsFlag: false,
        loading: false,
        currentPizza: null,
      };
    },
    methods: {
      async createRandomPizza() {
        const store = usePizzasStore();
        const randomPizza = await store.generateRandomPizza();
        this.pizzas.push(randomPizza);
      },
      showPizzaDetails(pizza) {
        this.currentPizza = pizza;
        this.showPizzaDetailsFlag = true;
      },
      showCreatePizzaModal() {
        this.showCreatePizzaModalFlag = !this.showCreatePizzaModalFlag;
      },
      showEditPizzaModal(pizza) {
      this.currentPizza = pizza;
      this.showCreatePizzaModalFlag = true;
    },
    closePizzaDetailsModal() {
      this.showPizzaDetailsFlag = false;
      this.currentPizza = null;
    },
    async confirmDeletePizza(pizzaId) {
      const confirmDelete = confirm('Are you sure you want to delete this pizza?');
      if (confirmDelete) {
        try {
          const store = usePizzasStore();
          await store.deletePizza(pizzaId);
          this.pizzas = this.pizzas.filter((pizza) => pizza.id !== pizzaId);
          alert('Pizza deleted successfully!');
        } catch (error) {
          console.error('Failed to delete pizza:', error);
          alert('Failed to delete pizza.');
        }
      }
    },
    },
    async mounted() {
      this.loading = true;
      const store = usePizzasStore();
      this.pizzas = await store.fetchPizzas();
      try {
        await store.fetchPizzas();
        this.pizzas = store.pizzas;
      } catch (error) {
        console.error('Failed to fetch pizzas:', error);
      } finally {
        this.loading = false;
      }
    },
  };
  </script>
  
  <style scoped>
  </style>
  