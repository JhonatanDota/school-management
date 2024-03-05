<template>
  <div class="relative mx-auto mt-16 flex flex-col gap-6 p-6 bg-[#222D32] rounded-md">
    <UserIcon class="absolute -top-8 left-1/2 -translate-x-1/2 h-16 w-16 fill-slate-500"/>
    <div class="mt-8 flex justify-between items-center gap-3 p-3 bg-[#7745a5a8]">
      <UserRoundedIcon fill="white" class="w-6 h-5" />
      <input
        class="text-base text-white font-normal focus:outline-none rounded-sm bg-transparent placeholder-white/70"
        type="text"
        placeholder="e-mail"
      />
    </div>

    <div class="flex justify-between items-center gap-3 p-3 bg-[#7745a5a8]">
      <LockIcon fill="white" class="w-6 h-6" />
      <input
        class="text-base text-white font-normal focus:outline-none rounded-sm bg-transparent placeholder-white/70"
        type="text"
        placeholder="password"
      />
    </div>

    <div class="flex items-center justify-between text-sm">
      <div class="flex gap-2">
        <input id="checkbox-remember" class="" type="checkbox" />
        <label for="checkbox-remember" class="text-gray-300"
          >Lembrar usuário ?</label
        >
      </div>
      <button class="font-semibold text-[#3df85cb2]">Registrar</button>
    </div>

    <button class="w-full text-sm p-2 uppercase font-bold bg-gray-200">
      Login
    </button>
  </div>
</template>

<script setup lang="ts">
import UserIcon from "@/icons/UserIcon.vue";
import UserRoundedIcon from "@/icons/UserRoundedIcon.vue";
import LockIcon from "@/icons/LockIcon.vue";
</script>
