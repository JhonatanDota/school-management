<template>
  <div class="flex flex-col items-center gap-2 md:gap-4">
    <div class="flex items-center gap-5">
      <button class="w-6 h-6 md:w-8 md:h-8 disabled:fill-gray-400"
        @click="!currentIsFirst && changePage(pagination.currentPage - 1)" :disabled="currentIsFirst">
        <FilledLeftArrow class="w-full h-full" />
      </button>

      <select
        class="appearance-none px-4 md:px-6 py-2 bg-[#7745a5] text-white text-base md:text-lg rounded-md font-bold focus:outline-none"
        v-model="currentPage" @change="pageSelectionChange($event)">
        <option v-for="pageNumber in pagination.lastPage" :key="pageNumber" :value="pageNumber">
          {{ pageNumber }}
        </option>
      </select>

      <button class="w-6 h-6 md:w-8 md:h-8 disabled:fill-gray-400"
        @click="!currentIsLast && changePage(pagination.currentPage + 1)" :disabled="currentIsLast">
        <FilledRightArrow class="w-full h-full" />
      </button>
    </div>

    <p class="text-base md:text-lg font-medium">
      Total: <span> {{ pagination.total }} </span>
    </p>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, defineProps, defineEmits, watch } from "vue";
import PaginationModel from "@/models/PaginationModel";
import FilledLeftArrow from "@/icons/FilledLeftArrow.vue";
import FilledRightArrow from "@/icons/FilledRightArrow.vue";

const emit = defineEmits(["setParams"]);

interface DataTablePaginationProps {
  pagination: PaginationModel;
}

const props = defineProps<DataTablePaginationProps>();

const currentPage = ref(props.pagination.currentPage);
const currentIsFirst = computed(() => props.pagination.currentPage === 1);
const currentIsLast = computed(
  () => props.pagination.currentPage === props.pagination.lastPage
);

watch(props, function (value) {
  currentPage.value = value.pagination.currentPage;
});

function pageSelectionChange(event: Event): void {
  const value: string = (event.target as HTMLInputElement).value;
  const page: number = Number(value);

  changePage(isNaN(page) ? 1 : page);
}

function changePage(page: number): void {
  currentPage.value = page;
  emit("setParams", { page });
}
</script>
