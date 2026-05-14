<script setup>
defineProps({
  user: Object,
})
</script>

<template>
  <div v-if="user">
    <p>Name: {{ user.name }}</p>
    <p>Email: {{ user.email }}</p>
  </div>
  <div v-else>
    <p>No user found in session</p>
  </div>
</template>