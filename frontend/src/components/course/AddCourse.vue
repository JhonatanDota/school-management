<template>
  <form class="flex flex-col gap-3 md:gap-6" @submit.prevent="onSubmit">
    <InputContainer>
      <InputLabel text="Nome" track="name" />
      <InputText id="name" v-model="courseData.name" />
    </InputContainer>

    <InputContainer>
      <InputLabel text="Descrição" track="description" />
      <InputText id="description" v-model="courseData.description" />
    </InputContainer>

    <SubmitButton text="Adicionar" />
  </form>
</template>

<script setup lang="ts">
import { reactive, defineProps } from "vue";
import { CourseAddModel, CourseModel } from "@/models/CourseModel";
import { addCourse } from "@/requests/courseRequests";
import AddCourseValidation from "@/validations/course/addCourse";


import InputContainer from "@/components/common/form/inputs/InputContainer.vue";
import InputLabel from "@/components/common/form/inputs/InputLabel.vue";
import InputText from "@/components/common/form/inputs/InputText.vue";
import SubmitButton from "@/components/common/form/SubmitButton.vue";
import { toast } from "@/utils/functions/toast";

interface addCourseProps {
  onAdd: (course: CourseModel) => void;
}

const props = defineProps<addCourseProps>();

const initialState: CourseAddModel = {
  name: "",
  description: ""
};

const courseData: CourseAddModel = reactive(initialState);

function resetForm(): void {
  Object.assign(courseData, initialState);
}

async function onSubmit(): Promise<void> {
  try {
    new AddCourseValidation(courseData);

    const response = await addCourse(courseData);
    successfullyAdd(response.data);
  } catch (error) {
    //
  }
}

function successfullyAdd(course: CourseModel) {
  props.onAdd(course);
  toast("Curso adicionado!");
  resetForm();
}
</script>