<!-- Layouts/AppLayout.vue -->
<script setup lang="ts">
import { SidebarProvider, SidebarInset } from '@/components/ui/sidebar'
import AppSidebar from '@/components/AppSidebar.vue'
</script>

<template>
  <SidebarProvider>
    <AppSidebar />
    <SidebarInset class="min-w-0">
      <header class="border-b px-6 py-3 flex items-center justify-between">
        <Input placeholder="Search resources..." class="w-72" />
        <div class="flex items-center gap-3">
          <Button variant="ghost" size="icon"><Moon class="w-4 h-4" /></Button>
          <Button variant="ghost" size="icon"><Bell class="w-4 h-4" /></Button>
        </div>
      </header>
      <main class="p-6">
        <slot />
      </main>
    </SidebarInset>
  </SidebarProvider>
</template>