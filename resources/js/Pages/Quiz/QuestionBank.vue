<script setup lang="ts">
import AppLayout from '@/components/layout/AppLayout.vue';
import Button from '@/components/ui/button/Button.vue';
import InputGroup from '@/components/ui/input-group/InputGroup.vue';
import InputGroupAddon from '@/components/ui/input-group/InputGroupAddon.vue';
import InputGroupInput from '@/components/ui/input-group/InputGroupInput.vue';
import NativeSelect from '@/components/ui/native-select/NativeSelect.vue';
import NativeSelectOption from '@/components/ui/native-select/NativeSelectOption.vue';
import QuestionBankCard from '@/components/ui/quiz/QuestionBankCard.vue';
import { Plus, SearchIcon, X } from 'lucide-vue-next';

defineOptions({
    layout: AppLayout,
})
</script>

<template>
    <div class="w-full mx-auto flex flex-col gap-6 py-6">
        <!-- Heading section-->
        <section class="flex items-start justify-between">
            <div>
                <h1 class="text-3xl font-bold">Question Bank</h1>
                <p class="text-sm text-muted-foreground">
                    Manage and organize your SQL assessment repository.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <Button variant="default">
                    <Plus />
                    Create New Question
                </Button>
            </div>
        </section>
        <!--Search and filtering section -->
        <section class="w-full h-13 border-2 flex items-center justify-between">
            <InputGroup class="w-full max-w-sm py-4 ml-4">
                <InputGroupInput placeholder="Search for title or keyword..." />
                <InputGroupAddon>
                    <SearchIcon />
                </InputGroupAddon>
            </InputGroup>
            <div class="flex justify-around gap-2">
                <NativeSelect>
                    <NativeSelectOption value="">Difficulty</NativeSelectOption>
                    <NativeSelectOption value="easy">Easy</NativeSelectOption>
                    <NativeSelectOption value="medium">Medium</NativeSelectOption>
                    <NativeSelectOption value="hard">Hard</NativeSelectOption>
                </NativeSelect>
                <NativeSelect>
                    <NativeSelectOption value="">Topic</NativeSelectOption>
                    <NativeSelectOption value="join">Join</NativeSelectOption>
                    <NativeSelectOption value="group-by">Group By</NativeSelectOption>
                </NativeSelect>
                <!-- Could possibly change for a day picker -->
                <NativeSelect>
                    <NativeSelectOption value="">Date Created</NativeSelectOption>
                    <NativeSelectOption value="Some date">Some date</NativeSelectOption>
                </NativeSelect>
                <Button variant="ghost" class="text-muted-foreground"><X />Clear</Button>
            </div>
        </section> 
        <!-- Question cards section -->
         <section class="grid grid-cols-2 gap-4">
            <QuestionBankCard></QuestionBankCard>
         </section>
    </div>
</template>