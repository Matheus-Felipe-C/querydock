<!-- Layouts/AppLayout.vue -->
<script setup lang="ts">
import { SidebarProvider, SidebarInset } from '@/components/ui/sidebar'
import InputGroup from '../ui/input-group/InputGroup.vue';
import AppSidebar from '@/components/AppSidebar.vue'
import { Moon, Bell, SearchIcon } from 'lucide-vue-next';
import InputGroupInput from '../ui/input-group/InputGroupInput.vue';
import InputGroupAddon from '../ui/input-group/InputGroupAddon.vue';
</script>

<template>
  <SidebarProvider>
    <AppSidebar />
    <SidebarInset class="min-w-0">
      <header class="border-b px-6 py-3 flex items-center justify-between">
        <InputGroup class="w-full max-w-sm">
          <InputGroupInput placeholder="Search resources..." />
          <InputGroupAddon >
            <SearchIcon />
          </InputGroupAddon>
        </InputGroup>
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