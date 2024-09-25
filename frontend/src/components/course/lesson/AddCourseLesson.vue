<template>
    <button class="" @click="handleFormVisibility">
        <PlusIcon class="w-10 h-10 md:w-14 md:h-14" fill="white" v-if="!showForm" />
        <CancelIcon class="w-10 h-10" fill="white" v-else />
    </button>
    <div class="flex flex-col gap-1" v-if="showForm">
        <InputLabel text="Nome" track="course-lesson-name" />
        <div class="flex flex-col gap-2 md:flex-row md:items-center">
            <InputText id="course-lesson-name" />
            <SubmitButton text="Adicionar" />
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import InputLabel from '@/components/common/form/inputs/InputLabel.vue';
import InputText from '@/components/common/form/inputs/InputText.vue';
import PlusIcon from '@/icons/PlusIcon.vue';
import CancelIcon from '@/icons/CancelIcon.vue';
import SubmitButton from '@/components/common/form/SubmitButton.vue';

const showForm = ref<boolean>(true);

function handleFormVisibility(): void {
    showForm.value = !showForm.value;
}

</script>
