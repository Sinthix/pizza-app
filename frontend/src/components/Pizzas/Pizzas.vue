<template>
  <div>
    <div v-if="loading" class="loader-container">
      <div class="loader"></div>
    </div>
    <div v-else>
    <div class="d-flex justify-content-between mb-3">
        <h2>Pizzas</h2>
        <div>
          <button class="btn btn-outline-dark" @click="createRandomPizza">Generate Random Pizza</button>
          <button class="btn btn-outline-dark" @click="showCreatePizzaModal">Create Pizza</button>
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
                <button class="btn btn-outline-info me-2" @click="showPizzaDetails(pizza)">View Details</button>
                <button class="btn btn-outline-secondary me-2" @click="showEditPizzaModal(pizza)">Edit</button>
                <button class="btn btn-outline-danger" @click="confirmDeletePizza(pizza.id)">Delete</button>
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
  import { useToast } from 'vue-toastification';
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
      showPizzaDetails(pizza) {
        this.currentPizza = pizza;
        this.showPizzaDetailsFlag = true;
      },
      showCreatePizzaModal() {
        this.currentPizza = null;
        
        this.showCreatePizzaModalFlag = !this.showCreatePizzaModalFlag;
        if(!this.showCreatePizzaModalFlag) {
          this.getPizzas();
        }
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
        const toast = useToast();
        const confirmDelete = confirm('Are you sure you want to delete this pizza?');
        if (confirmDelete) {
          try {
            const store = usePizzasStore();
            await store.deletePizza(pizzaId);
            this.pizzas = this.pizzas.filter((pizza) => pizza.id !== pizzaId);
            toast.success('Pizza deleted successfully!');
          } catch (error) {
            toast.error('Failed to delete pizza.');
          }
        }
      },
      async getPizzas() {
        const toast = useToast();
        this.loading = true;
        const store = usePizzasStore();
        this.pizzas = await store.fetchPizzas();
        try {
          await store.fetchPizzas();
          this.pizzas = store.pizzas;
          toast.success('Pizzas loaded successfully!');
        } catch (error) {
          toast.error('Failed to fetch pizzas.');
        } finally {
          this.loading = false;
        }
      },
        async createRandomPizza() {
          const toast = useToast();
          try {
            const store = usePizzasStore();
            const randomPizza = await store.generateRandomPizza();
            await this.getPizzas();
            toast.success(`Random pizza created: ${randomPizza.name}`);
          } catch (error) {
            toast.error('Failed to create random pizza.');
          }
        }
      },
    async mounted() {
      await this.getPizzas();
    },
  };
  </script>
  
  <style scoped>
  </style>
  