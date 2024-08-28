<template>
  <form class="flex flex-col gap-3 md:gap-6" @submit.prevent="onSubmit">
    <InputContainer>
      <InputLabel text="Nome" track="name" />
      <InputText id="name" v-model="teacherData.name" />
    </InputContainer>

    <InputContainer>
      <InputLabel text="Email" track="email" />
      <InputText id="email" v-model="teacherData.email" />
    </InputContainer>

    <SubmitButton text="Adicionar" />
  </form>
</template>

<script setup lang="ts">
import { reactive, defineProps } from "vue";
import { TeacherAddModel, TeacherModel } from "@/models/TeacherModel";
import { addTeacher } from "@/requests/teacherRequests";
import AddTeacherValidation from "@/validations/teacher/addTeacher";
import InputContainer from "@/components/common/form/inputs/InputContainer.vue";
import InputLabel from "@/components/common/form/inputs/InputLabel.vue";
import InputText from "@/components/common/form/inputs/InputText.vue";
import SubmitButton from "@/components/common/form/SubmitButton.vue";
import { AxiosResponse } from "axios";
import { toast } from "@/utils/functions/toast";

interface addTeacherProps {
  onAdd: (teacher: TeacherModel) => void;
}

const props = defineProps<addTeacherProps>();

const initialState = (): TeacherAddModel => ({
  name: "",
  email: ""
});

const teacherData: TeacherAddModel = reactive(initialState());

function resetForm(): void {
  Object.assign(teacherData, initialState());
}

async function onSubmit(): Promise<void> {
  try {
    new AddTeacherValidation(teacherData);

    const response: AxiosResponse<TeacherModel> = await addTeacher(teacherData);
    successfullyAdd(response.data);
  } catch (error) {
    //
  }
}

function successfullyAdd(teacher: TeacherModel) {
  props.onAdd(teacher);
  toast("Professor cadastrado!");
  resetForm();
}
</script>
