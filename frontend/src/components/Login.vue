<template>
    <div class="login-container">
      <h2 class="text-center mb-4">Login</h2>
      <div class="row justify-content-center">
        <div class="col-12 col-md-6 col-lg-4">
          <form @submit.prevent="login" class="bg-light p-4 rounded shadow-sm">
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input
                type="email"
                id="email"
                v-model="email"
                class="form-control"
                placeholder="Enter your email"
                required
              />
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input
                type="password"
                id="password"
                v-model="password"
                class="form-control"
                placeholder="Enter your password"
                required
              />
            </div>
            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-primary">Login</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </template>
  
  <script>
import axios from 'axios';

  export default {
    data() {
      return {
        email: '',
        password: ''
      };
    },
    methods: {
      async login() {
        await axios
          .post('http://localhost:8000/api/login', {
            email: this.email,
            password: this.password
          })
          .then((response) => {
            localStorage.setItem('token', response.data.token);
            this.$router.push('/management'); 
          })
          .catch((error) => {
            console.error('Login failed:', error);
          });
      }
    }
  };
  </script>
  
  <style scoped>
  .login-container {
    max-width: 600px;
    margin: 0 auto;
  }
  </style>
  