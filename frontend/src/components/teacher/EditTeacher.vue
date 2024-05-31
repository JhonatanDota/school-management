<template>
    <form class="flex flex-col gap-3 md:gap-6 pt-2 md:pt-5">
        <div class="flex flex-col gap-1 md:gap-3">
            <InputLabel text="Nome" track="name" />
            <InputText id="name" v-model="teacherData.name" />
        </div>

        <div class="flex flex-col gap-1 md:gap-3">
            <InputLabel text="Email" track="email" />
            <InputText id="email" v-model="teacherData.email" />
        </div>
    </form>
</template>

<script setup lang="ts">
import { ref, defineProps, watch } from 'vue';
import { TeacherModel } from '@/models/TeacherModel';
import InputLabel from '../common/inputs/InputLabel.vue';
import InputText from '../common/inputs/InputText.vue';

interface EditTeacherProps {
    teacher: TeacherModel;
}

const props = defineProps<EditTeacherProps>();

const teacherData = ref<TeacherModel>({ ...props.teacher });

watch(() => props.teacher, (newTeacher: TeacherModel) => {
    teacherData.value = { ...newTeacher };
});

</script>
