<template>
  <div class="container">
    <div class="nav nav-tabs" id="myTab" role="tablist">
      <a
        class="nav-link"
        id="pizzas-tab"
        data-bs-toggle="tab"
        href="#pizzas"
        role="tab"
        aria-controls="pizzas"
        aria-selected="true"
        @click="setTab('pizzas')"
      >
        Pizzas
      </a>
      <a
        class="nav-link"
        id="ingredients-tab"
        data-bs-toggle="tab"
        href="#ingredients"
        role="tab"
        aria-controls="ingredients"
        aria-selected="false"
        @click="setTab('ingredients')"
      >
        Ingredients
      </a>
    </div>

    <div class="tab-content mt-4">
      <div v-if="activeTab === 'pizzas'">
        <Pizzas />
      </div>
      <div v-if="activeTab === 'ingredients'">
        <Ingredients />
      </div>
    </div>
  </div>
</template>

<script>
import Pizzas from './Pizzas.vue';
import Ingredients from './Ingredients.vue';

export default {
  components: {
    Pizzas,
    Ingredients,
  },
  data() {
    return {
      activeTab: 'pizzas',
    };
  },
  methods: {
    setTab(tab) {
      this.activeTab = tab;
    },
  },
};
</script>

<style scoped>
</style>
