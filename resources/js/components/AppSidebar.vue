<script setup lang="ts">
import { BookOpen, Database, LayoutDashboard, Plus } from 'lucide-vue-next';
import Sidebar from './ui/sidebar/Sidebar.vue';
import SidebarContent from './ui/sidebar/SidebarContent.vue';
import SidebarGroup from './ui/sidebar/SidebarGroup.vue';
import SidebarGroupContent from './ui/sidebar/SidebarGroupContent.vue';
import SidebarHeader from './ui/sidebar/SidebarHeader.vue';
import SidebarMenu from './ui/sidebar/SidebarMenu.vue';
import SidebarMenuItem from './ui/sidebar/SidebarMenuItem.vue';
import SidebarMenuButton from './ui/sidebar/SidebarMenuButton.vue';
import SidebarFooter from './ui/sidebar/SidebarFooter.vue';
import Button from './ui/button/Button.vue';

const navItems = [
    {label: 'Dashboard', icon: LayoutDashboard, href: '#', active: false},
    {label: 'Quizzes', icon: BookOpen, href: '#', active: true},
    {label: 'Question Bank', icon: Database, href: 'quiz/question-bank', active: false},
]

</script>

<template>
        <Sidebar>
            <!-- Logo -->
             <SidebarHeader class="p-4">
                <h2 class="text-lg font-bold text-primary">Query Dock</h2>
                <p class="text-xs text-muted-foreground">Professor portal</p>
             </SidebarHeader>

             <!-- Nav items -->
              <SidebarContent>
                <SidebarGroup>
                    <SidebarGroupContent>
                        <SidebarMenu>
                            <SidebarMenuItem v-for="item in navItems" :key="item.label">
                                <SidebarMenuButton
                                    :is-active="item.active"
                                    as-child
                                >
                                    <a :href="item.href" class="flex items-center gap-2">
                                        <component :is="item.icon" class="w-4 h-4" />
                                        <span>{{ item.label }}</span>
                                    </a>
                            </SidebarMenuButton>
                            </SidebarMenuItem>
                        </SidebarMenu>
                    </SidebarGroupContent>
                </SidebarGroup>
              </SidebarContent>

              <!-- Create quiz button -->
               <SidebarFooter class="p-4">
                <Button class="w-full">
                    <Plus class="w-4 h-4 mr-2" />
                    Create Quiz
                </Button>
               </SidebarFooter>
        </Sidebar>
</template>