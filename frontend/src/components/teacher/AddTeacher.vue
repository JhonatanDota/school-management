<template>
  <form class="flex flex-col gap-3 md:gap-6 pt-2 md:pt-5" @submit.prevent="onSubmit">
    <div class="flex flex-col gap-1 md:gap-3">
      <InputLabel text="Nome" track="name" />
      <InputText id="name" v-model="teacherData.name" />
    </div>

    <div class="flex flex-col gap-1 md:gap-3">
      <InputLabel text="Email" track="email" />
      <InputText id="email" v-model="teacherData.email" />
    </div>

    <button type="submit"
      class="text-sm md:text-lg self-end p-3 md:p-4 bg-green-600 text-white font-bold rounded-md mt-2">
      Adicionar
    </button>
  </form>
</template>

<script setup lang="ts">
import { reactive, defineProps } from "vue";
import { TeacherAddModel, TeacherModel } from "@/models/TeacherModel";
import { addTeacher } from "@/requests/teacherRequests";
import AddTeacherValidation from "@/validations/teacher/addTeacher";
import InputLabel from "@/components/common/inputs/InputLabel.vue";
import InputText from "@/components/common/inputs/InputText.vue";
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

const resetForm = () => {
  Object.assign(teacherData, initialState());
};

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
