<template>
  <form class="flex flex-col gap-3" @submit.prevent="onSubmit">
    <div class="flex flex-col gap-1">
      <label class="text-sm font-semibold text-green-600" for="">Nome</label>
      <input
        class="text-base bg-[#7745a5a8] w-full p-1 text-white focus:outline-none rounded-md"
        type="text"
        v-model="name"
      />
    </div>
    <div class="flex flex-col gap-1">
      <label class="text-sm font-semibold text-green-600" for="">Email</label>
      <input
        class="text-base bg-[#7745a5a8] w-full p-1 text-white focus:outline-none rounded-md"
        type="text"
        v-model="email"
      />
    </div>
    <button
      type="submit"
      class="text-xs self-end p-3 bg-green-600 text-white font-bold rounded-md mt-2"
    >
      Adicionar
    </button>
  </form>
</template>

<script setup lang="ts">
import { ref } from "vue";
import AddTeacherValidation from '@/validations/teacher/addTeacher';

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
