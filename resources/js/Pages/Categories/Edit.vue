<template>
  <div>
    <h1>Edit Category</h1>
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
      <button type="submit">Update</button>
    </form>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { defineProps } from 'vue';

const props = defineProps({
  category: Object,
});

const form = useForm({
  name: props.category.name,
  description: props.category.description,
});

const submit = () => {
  form.put(`/categories/${props.category.id}`);
};
</script>
