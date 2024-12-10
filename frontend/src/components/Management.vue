<template>
    <div class="container mt-5">
      <h2>Management Dashboard</h2>
  
      <div v-if="!token" class="alert alert-warning" role="alert">
        You are not logged in. Please <router-link to="/login">login</router-link> to access the management area.
      </div>
  
      <div v-else>
        <p>Welcome to the management dashboard!</p>
        <button class="btn btn-danger" @click="logout">Logout</button>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        token: localStorage.getItem('token')
      };
    },
    methods: {
      logout() {
        localStorage.removeItem('token');
        this.token = null;
        this.$router.push('/login');
      }
    }
  };
  </script>
  
  <style scoped>
  </style>
  