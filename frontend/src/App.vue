<template>
  <div id="app">
    <header class="fixed-top bg-dark text-white py-3">
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

    <main class="content">
      <div class="container py-4">
        <router-view></router-view>
      </div>
    </main>

    <footer class="fixed-bottom bg-dark text-white py-3">
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
#app {
  padding-top: 75px;
  padding-bottom: 55px;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

main.content {
  flex-grow: 1;
  overflow-y: auto;
}

.fixed-top {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 1030;
}

.fixed-bottom {
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  z-index: 1030;
}

.container {
  max-width: 1280px;
  margin: 0 auto;
}

@media (max-width: 768px) {
  #app {
    padding-top: 60px;
    padding-bottom: 50px;
  }
}
</style>
