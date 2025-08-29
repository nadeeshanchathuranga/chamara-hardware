<template>
  <AdminLayout>
    <div>
      <h1>Categories</h1>
      <Link href="/categories/create" class="btn btn-primary">Add New Category</Link>

      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Parent Category</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="category in categories.data" :key="category.id">
            <td>{{ category.name }}</td>
            <td>{{ category.description }}</td>
            <td>{{ category.parent ? category.parent.name : "None" }}</td>
            <td>
              <Link :href="`/categories/${category.id}/edit`">Edit</Link>
              <button @click="deleteCategory(category.id)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- Pagination Links -->
      <div class="pagination">
        <Link
          v-for="link in categories.links"
          :key="link.label"
          :href="link.url"
          :class="{'is-active': link.active, 'disabled': !link.url}"
          v-html="link.label"
        ></Link>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import { defineProps } from "vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";

const props = defineProps({
  categories: Object, // Pagination data is now an object
});

const form = useForm({});

const deleteCategory = (id) => {
  if (confirm("Are you sure you want to delete this category?")) {
    form.delete(`/categories/${id}`);
  }
};
</script>

<style>
.pagination {
  margin-top: 1em;
  display: flex;
  gap: 0.5em;
}

.pagination .is-active {
  font-weight: bold;
  text-decoration: underline;
}

.pagination .disabled {
  pointer-events: none;
  color: #ccc;
}
</style>
