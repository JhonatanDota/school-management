<template>
    <div class="flex flex-col gap-1">
        <p class="text-base md:text-xl font-semibold text-green-600">Criado em</p>
        <p class="text-white ml-2">{{ teacher.createdAt }}</p>
    </div>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';
import { TeacherModel } from '@/models/TeacherModel';

interface AdditionalInfoTeacherProps {
    teacher: TeacherModel
}

defineProps<AdditionalInfoTeacherProps>()
</script>