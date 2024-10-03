<template>
    <div
        class="flex justify-between items-center rounded-l-md border-l-8 border-l-white bg-green-600 p-3 cursor-pointer">
        <span class="text-base md:text-lg font-medium">{{ courseLesson.name }}</span>
        <button class="w-7 h-7 md:w-9 md:h-9">
            <XIcon class="w-full h-full" fill="white" />
        </button>
    </div>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';
import { CourseLessonModel } from '@/models/CourseLessonModel';
import XIcon from '@/icons/XIcon.vue';

interface CourseLessonProps {
    courseLesson: CourseLessonModel
}

const props = defineProps<CourseLessonProps>();

</script>