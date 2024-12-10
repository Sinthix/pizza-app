<template>
    <div>
      <h1>{{ $t('welcome') }}</h1>
      <div v-if="ingredients.length">
        <ul>
          <li v-for="ingredient in ingredients" :key="ingredient.id">
            {{ ingredient.name }}
          </li>
        </ul>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        ingredients: []
      };
    },
    mounted() {
      this.fetchIngredients();
    },
    methods: {
      fetchIngredients() {
        axios.get('http://localhost:8000/api/ingredients')
          .then(response => {
            this.ingredients = response.data;
          })
          .catch(error => {
            console.error('Error fetching ingredients:', error);
          });
      }
    }
  };
  </script>
  