<template>
  <div>
    <h1>Create Category</h1>
    <form @submit.prevent="submit">
      <div>
        <label for="name">Name</label>
        <input v-model="form.name" type="text" id="name" required />
        <span v-if="form.errors.name">{{ form.errors.name }}</span>
      </div>

      <div>
        <label for="description">Description</label>
        <textarea v-model="form.description" id="description"></textarea>
        <span v-if="form.errors.description">{{ form.errors.description }}</span>
      </div>

      <div>
        <label for="parent_id">Parent Category</label>
        <select v-model="form.parent_id" id="parent_id">
          <option :value="null">None</option>
          <option v-for="category in categories" :key="category.id" :value="category.id">
            {{ category.name }}
          </option>
        </select>
        <span v-if="form.errors.parent_id">{{ form.errors.parent_id }}</span>
      </div>

      <button type="submit">Save</button>
    </form>
  </div>
</template>

<script setup>
import { defineProps } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
  categories: Array, // Receive categories as a prop from the controller
});

const form = useForm({
  name: '',
  description: '',
  parent_id: null, // Add parent_id to the form data
});

const submit = () => {
  form.post('/categories');
};
</script>
