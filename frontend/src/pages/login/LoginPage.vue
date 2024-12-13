<template>
  <form @submit.prevent="onSubmit"
    class="relative w-[90%] md:w-auto mx-auto mt-16 md:mt-20 flex flex-col gap-6 md:gap-10 p-6 md:p-10 bg-[#222D32] rounded-md">
    <UserIcon class="absolute -top-8 md:-top-10 left-1/2 -translate-x-1/2 h-16 md:h-20 w-16 md:w-20 fill-slate-500" />
    <div
      class="mt-8 md:mt-10 flex justify-start items-center gap-3 md:gap-5 p-3 md:p-5 bg-[#7745a5a8] border-l-2 transition-colors duration-500"
      :class="[email ? 'border-green-700' : 'border-red-700']">
      <UserRoundedIcon fill="white" class="w-6 md:w-8 h-5 md:h-7" />
      <input v-model="email"
        class="w-[80%] text-base md:text-lg text-white font-normal focus:outline-none rounded-sm bg-transparent placeholder-white/70"
        type="text" placeholder="e-mail" />
    </div>

    <div
      class="flex justify-start items-center gap-3 md:gap-5 p-3 md:p-5 bg-[#7745a5a8] border-l-2 transition-colors duration-500"
      :class="[password ? 'border-green-700' : 'border-red-700']">
      <LockIcon fill="white" class="w-6 md:w-8 h-6 md:h-8" />
      <input v-model="password"
        class="w-[80%] text-base md:text-lg text-white font-normal focus:outline-none rounded-sm bg-transparent placeholder-white/70"
        :type="showPassword ? 'text' : 'password'" placeholder="password" />
      <button type="button" @click="handleShowPassword">
        <ClosedEyeIcon v-if="showPassword" fill="white" class="w-6 md:w-8 h-6 md:h-8" />
        <OpenedEyeIcon v-else fill="white" class="w-6 md:w-8 h-6 md:h-8" />
      </button>
    </div>

    <div class="flex items-center text-sm md:text-base select-none">
      <div class="flex gap-2">
        <input id="checkbox-remember" class="" type="checkbox" />
        <label for="checkbox-remember" class="text-gray-300 font-semibold cursor-pointer">Lembrar usuário ?</label>
      </div>
    </div>

    <button type="submit" class="w-full text-sm md:text-base p-2 md:p-3 uppercase font-bold bg-gray-200">
      Login
    </button>
  </form>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { useRouter } from "vue-router";
import LoginValidation from "@/validations/login";
import { auth } from "@/requests/authRequests";
import { AxiosResponse } from "axios";
import { AuthModel } from "@/models/AuthSuccessModel";
import { storeLoginData } from "@/functions/auth";
import UserIcon from "@/icons/UserIcon.vue";
import UserRoundedIcon from "@/icons/UserRoundedIcon.vue";
import LockIcon from "@/icons/LockIcon.vue";
import OpenedEyeIcon from "@/icons/OpenedEyeIcon.vue";
import ClosedEyeIcon from "@/icons/ClosedEyeIcon.vue";

const router = useRouter();
const showPassword = ref(false);

const email = ref("schimmel.beulah@example.net");
const password = ref("test1234");

async function onSubmit(): Promise<void> {
  const emailValue: string = email.value;
  const passwordValue: string = password.value;

  try {
    new LoginValidation(emailValue, passwordValue);
    const authResponse: AxiosResponse<AuthModel> = await auth(
      emailValue,
      passwordValue
    );

    handleAuth(authResponse.data);
  } catch {
    //
  }
}

function handleAuth(authData: AuthModel): void {
  storeLoginData(authData);
  router.push("/home");
}

function handleShowPassword(): void {
  showPassword.value = !showPassword.value;
}
</script>
