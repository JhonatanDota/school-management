<template>
  <div
    class="relative mx-auto mt-16 md:mt-20 flex flex-col gap-6 md:gap-10 p-6 md:p-10 bg-[#222D32] rounded-md"
  >
    <UserIcon
      class="absolute -top-8 md:-top-10 left-1/2 -translate-x-1/2 h-16 md:h-20 w-16 md:w-20 fill-slate-500"
    />
    <div
      class="mt-8 md:mt-10 flex justify-start items-center gap-3 md:gap-5 p-3 md:p-5 bg-[#7745a5a8]"
    >
      <UserRoundedIcon fill="white" class="w-6 md:w-8 h-5 md:h-7" />
      <input
        class="text-base md:text-lg text-white font-normal focus:outline-none rounded-sm bg-transparent placeholder-white/70"
        type="text"
        placeholder="e-mail"
      />
    </div>

    <div
      class="flex justify-start items-center gap-3 md:gap-5 p-3 md:p-5 bg-[#7745a5a8]"
    >
      <LockIcon fill="white" class="w-6 md:w-8 h-6 md:h-8" />
      <input
        class="text-base md:text-lg text-white font-normal focus:outline-none rounded-sm bg-transparent placeholder-white/70"
        type="password"
        placeholder="password"
      />
      <LockIcon fill="white" class="w-6 md:w-8 h-6 md:h-8" />
    </div>

    <div class="flex items-center justify-between text-sm md:text-base">
      <div class="flex gap-2">
        <input id="checkbox-remember" class="" type="checkbox" />
        <label for="checkbox-remember" class="text-gray-300 cursor-pointer"
          >Lembrar usuário ?</label
        >
      </div>
      <button class="font-semibold text-[#3df85cb2]">Registrar</button>
    </div>

    <button
      class="w-full text-sm md:text-base p-2 md:p-3 uppercase font-bold bg-gray-200"
    >
      Login
    </button>
  </div>
</template>

<script setup lang="ts">
import UserIcon from "@/icons/UserIcon.vue";
import UserRoundedIcon from "@/icons/UserRoundedIcon.vue";
import LockIcon from "@/icons/LockIcon.vue";
</script>
