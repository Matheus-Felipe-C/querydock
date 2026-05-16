<script setup lang="ts">
import type { User } from '../types'

defineProps<{
    user?: User | null
}>()
</script>

<template>
  <div v-if="user">
    <p>Name: {{ user.name }}</p>
    <p v-if="user.email">Email: {{ user.email }}</p>
  </div>
  <div v-else>
    <p>No user found in session</p>
  </div>
</template>
