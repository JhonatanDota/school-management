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

        <SubmitButton text="Editar" />
    </form>
</template>

<script setup lang="ts">
import { reactive, defineProps, watch } from 'vue';
import { AxiosResponse } from 'axios';
import { TeacherModel } from '@/models/TeacherModel';
import { editTeacher } from '@/requests/teacherRequests';
import { toast } from '@/utils/functions/toast';
import EditTeacherValidation from '@/validations/teacher/editTeacher';

import InputContainer from '@/components/common/form/inputs/InputContainer.vue';
import InputLabel from '@/components/common/form/inputs/InputLabel.vue';
import InputText from '@/components/common/form/inputs/InputText.vue';
import InputToggle from '@/components/common/form/inputs/InputToggle.vue';
import SubmitButton from '../common/form/SubmitButton.vue';

interface EditTeacherProps {
    teacher: TeacherModel;
    onEdit: (teacher: TeacherModel) => void;
}

const props = defineProps<EditTeacherProps>();

const initialState = (): TeacherModel => ({ ...props.teacher });
const teacherData: TeacherModel = reactive(initialState());

async function onSubmit() {
    try {
        new EditTeacherValidation(teacherData);

        const response: AxiosResponse<TeacherModel> = await editTeacher(teacherData);
        props.onEdit(response.data);
        toast("Professor editado!");
    } catch (error) {
        //
    }
}

watch(() => props.teacher, (newTeacher: TeacherModel) => {
    Object.assign(teacherData, newTeacher);
});

</script>
