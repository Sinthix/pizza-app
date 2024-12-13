<template>
    <div class="modal fade show" tabindex="-1" style="display: block;">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Ingredient Details</h5>
            <button type="button" class="btn-close" @click="$emit('close')" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <h3>{{ ingredient.name }}</h3>
              <img
                :src="ingredient.image"
                alt="Pizza image"
                class="img-fluid mb-3"
                style="max-height: 300px; object-fit: cover"
              />
            </div>
            <div class="mb-3">
              <h4>Selling Price</h4>
              <p>{{ ingredient.cost_price }}€</p>
            </div>
            <div class="mb-3">
              <h4>Randomization Price</h4>
              <p>{{ ingredient.randomisation_percentage }}€</p>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="$emit('close')">Close</button>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      ingredient: {
        type: Object,
        required: true,
      },
    },
  };
  </script>
  
  <style scoped>
  .modal {
    background-color: rgba(0, 0, 0, 0.5);
  }
  </style>
  