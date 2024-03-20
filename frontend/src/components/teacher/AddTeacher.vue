<template>
  <form class="flex flex-col gap-3 md:gap-6 md:p-5" @submit.prevent="onSubmit">
    <div class="flex flex-col gap-1 md:gap-3">
      <label class="text-sm md:text-xl font-semibold text-green-600" for=""
        >Nome</label
      >
      <input
        class="text-base md:text-xl font-semibold bg-[#7745a5a8] w-full p-1 md:p-4 text-white focus:outline-none rounded-md"
        type="text"
        v-model="name"
      />
    </div>
    <div class="flex flex-col gap-1 md:gap-3">
      <label class="text-sm md:text-xl font-semibold text-green-600" for=""
        >Email</label
      >
      <input
        class="text-base md:text-xl font-semibold bg-[#7745a5a8] w-full p-1 md:p-4 text-white focus:outline-none rounded-md"
        type="text"
        v-model="email"
      />
    </div>
    <button
      type="submit"
      class="text-xs md:text-lg self-end p-3 md:p-4 bg-green-600 text-white font-bold rounded-md mt-2"
    >
      Adicionar
    </button>
  </form>
</template>

<script setup lang="ts">
import { ref } from "vue";
import AddTeacherValidation from "@/validations/teacher/addTeacher";

const name = ref();
const email = ref();

function onSubmit(): void {
  try {
    new AddTeacherValidation();
  } catch {
    //
  }
}
</script>
