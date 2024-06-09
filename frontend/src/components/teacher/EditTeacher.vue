<template>
    <form class="flex flex-col gap-3 md:gap-6 pt-2 md:pt-5" @submit.prevent="onSubmit">
        <InputContainer>
            <InputLabel text="Nome" track="name" />
            <InputText id="name" v-model="teacherData.name" />
        </InputContainer>

        <InputContainer>
            <InputLabel text="Email" track="email" />
            <InputText id="email" v-model="teacherData.email" />
        </InputContainer>

        <div class="flex items-center gap-3 md:gap-3">
            <InputLabel text="Ativo" track="isActive" />
            <InputToggle id="isActive" v-model="teacherData.isActive" />
        </div>

        <slot></slot>

        <button type="submit"
            class="text-sm md:text-lg self-end p-3 md:p-4 bg-green-600 text-white font-bold rounded-md mt-2">
            Adicionar
        </button>
    </form>
</template>

<script setup lang="ts">
import { reactive, defineProps, watch } from 'vue';
import { TeacherModel } from '@/models/TeacherModel';
import InputContainer from '../common/inputs/InputContainer.vue';
import InputLabel from '@/components/common/inputs/InputLabel.vue';
import InputText from '@/components/common/inputs/InputText.vue';
import InputToggle from '@/components/common/inputs/InputToggle.vue';

interface EditTeacherProps {
    teacher: TeacherModel;
}

const props = defineProps<EditTeacherProps>();

const initialState = (): TeacherModel => ({ ...props.teacher });
const teacherData: TeacherModel = reactive(initialState());

async function onSubmit() {
    console.log(teacherData.id)
}

watch(() => props.teacher, (newTeacher: TeacherModel) => {
    Object.assign(teacherData, newTeacher);
});

</script>
