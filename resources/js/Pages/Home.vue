<script setup>
defineProps({
  user_id: String
})
</script>

<template>
  <div>
    <h1>Hello there it works: {{ user_id }}</h1>
  </div>
</template>