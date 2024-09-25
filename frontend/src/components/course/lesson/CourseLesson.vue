<template>
    <div class="border-2 bg-green-600 p-2">
        <h1>{{ courseLesson.name }}</h1>
    </div>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';
import { CourseLessonModel } from '@/models/CourseLessonModel';

interface CourseLessonProps {
    courseLesson: CourseLessonModel
}

const props = defineProps<CourseLessonProps>();

</script>