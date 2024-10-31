<template>
    <div class="flex justify-between items-center rounded-md border-2 border-green-600 p-2 cursor-move select-none">
        <span class="text-base md:text-lg font-bold text-white">{{ courseLesson.name }}</span>

        <div class="flex gap-2">
            <button @click="handleEdit" class="w-5 h-5 md:w-9 md:h-9">
                <EditIcon class="w-full h-full fill-yellow-400" />
            </button>

            <button @click="handleDelete" class="w-5 h-5 md:w-9 md:h-9">
                <TrashIcon class="w-full h-full fill-red-600" />
            </button>
        </div>
    </div>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';
import { CourseLessonModel } from '@/models/CourseLessonModel';
import TrashIcon from '@/icons/TrashIcon.vue';
import EditIcon from '@/icons/EditIcon.vue';

interface CourseLessonProps {
    courseLesson: CourseLessonModel
}

const props = defineProps<CourseLessonProps>();

function handleEdit() {
    console.log(props.courseLesson);
}

function handleDelete() {
    console.log(props.courseLesson);
}


</script>