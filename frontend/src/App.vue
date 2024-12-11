<template>
  <div id="app">
    <header class="bg-dark text-white py-3">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h1 class="mb-0">Pizza Management</h1>
          <nav>
            <ul class="nav">
              <li class="nav-item">
                <router-link class="nav-link text-white" to="/login">Login</router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link text-white" to="/register">Register</router-link>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </header>

    <div class="container">
      <router-view></router-view>
    </div>

    <footer class="bg-dark text-white py-3">
      <div class="container text-center">
        <p>&copy; 2024 Pizza Management</p>
      </div>
    </footer>
  </div>
</template>

<script>
export default {
  name: 'App'
};
</script>

<style scoped>
</style>
