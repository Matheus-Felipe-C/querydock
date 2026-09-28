<script setup lang="ts">
import {
    Breadcrumb,
    BreadcrumbItem,
    BreadcrumbLink,
    BreadcrumbList,
    BreadcrumbPage,
    BreadcrumbSeparator
} from "@/components/ui/breadcrumb";
import {Link} from "@inertiajs/vue3";

export interface BreadcrumbItem {
    label: string,
    href?: string,
}

defineProps<{
    items: BreadcrumbItem[]
}>();
</script>

<template>
    <Breadcrumb>
        <BreadcrumbList>
            <template v-for="(item, index) in items" :key="item.label">
                <BreadcrumbItem>
                    <BreadcrumbLink v-if="item.href" as-child>
                        <Link :href="item.href">{{ item.label }}</Link>
                    </BreadcrumbLink>
                    <BreadcrumbPage v-else>{{ item.label }}</BreadcrumbPage>
                </BreadcrumbItem>
                <BreadcrumbSeparator v-if="index < items.length - 1" />
            </template>
        </BreadcrumbList>
    </Breadcrumb>
</template>

<style scoped>

</style>
