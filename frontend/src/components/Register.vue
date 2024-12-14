<template>
    <div class="register-container">
      <h2 class="text-center mb-4">Register</h2>
      <div class="row justify-content-center">
        <div class="col-12 col-md-6 col-lg-4">
          <form @submit.prevent="register" class="bg-light p-4 rounded shadow-sm">
            <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input
                type="text"
                id="name"
                v-model="name"
                class="form-control"
                placeholder="Enter your name"
                required
              />
            </div>
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
            <div class="mb-3">
              <label for="password_confirmation" class="form-label">Confirm Password</label>
              <input
                type="password"
                id="password_confirmation"
                v-model="password_confirmation"
                class="form-control"
                placeholder="Confirm your password"
                required
              />
            </div>
            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-primary">Register</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import { useToast } from 'vue-toastification'; 
  export default {
    data() {
      return {
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      };
    },
    methods: {
      register() {
        const toast = useToast();
        axios
          .post('http://localhost:8000/api/register', {
            name: this.name,
            email: this.email,
            password: this.password,
            password_confirmation: this.password_confirmation
          })
          .then((response) => {
            localStorage.setItem('token', response.data.token); 
            this.$router.push('/management'); 
          })
          .catch((error) => {
            toast.error('Registration failed:');
          });
      }
    }
  };
  </script>
  
  <style scoped>
  .register-container {
    max-width: 600px;
    margin: 0 auto;
  }
  </style>
  