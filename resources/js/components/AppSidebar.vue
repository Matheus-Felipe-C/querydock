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
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { route } from 'ziggy-js';

const page = usePage();

const course = computed(() => page.props.course as {id: number | string }| undefined);

const navItems = computed(() => {
    const courseId = course.value?.id;

    return [
        { 
            label: 'Dashboard', 
            icon: LayoutDashboard, 
            name: 'welcome' 
        },
        { 
            label: 'Quizzes', 
            icon: BookOpen, 
            name: 'courses.quizzes.index',
            params: {
                course: courseId,
            }
        },
        {
            label: 'Question Bank',
            icon: Database,
            name: 'courses.questions.index',
            params: {
                course: courseId,
            }
        },
    ];
});

const isActive = (name: string) => route().current(name);

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
                                    :is-active="isActive(item.name)"
                                    as-child
                                >
                                    <Link :href="route(item.name, item.params)" class="flex items-center gap-2">
                                        <component :is="item.icon" class="w-4 h-4" />
                                        <span>{{ item.label }}</span>
                                    </Link>
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