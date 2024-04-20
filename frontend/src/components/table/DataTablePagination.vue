<template>
  <div class="flex flex-col items-center">
    <div class="flex gap-3">
      <button
        @click="!currentIsFirst && changePage(pagination.current_page - 1)"
        :disabled="currentIsFirst"
      >
        <FilledLeftArrow />
      </button>

      <select
        class="p-3 bg-green-500 rounded-md font-bold focus:outline-none"
        v-model="currentPage"
        @change="pageSelectionChange($event)"
      >
        <option
          v-for="pageNumber in pagination.last_page"
          :key="pageNumber"
          :value="pageNumber"
        >
          {{ pageNumber }}
        </option>
      </select>

      <button
        @click="!currentIsLast && changePage(pagination.current_page + 1)"
        :disabled="currentIsLast"
      >
        <FilledRightArrow />
      </button>
    </div>
    <p>Total: {{ pagination.total }}</p>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, defineProps, defineEmits } from "vue";
import PaginationModel from "@/models/PaginationModel";
import FilledLeftArrow from "@/icons/FilledLeftArrow.vue";
import FilledRightArrow from "@/icons/FilledRightArrow.vue";

const emit = defineEmits(["changePage"]);

interface DataTablePaginationProps {
  pagination: PaginationModel;
}

const props = defineProps<DataTablePaginationProps>();

const currentPage = ref(props.pagination.current_page);
const currentIsFirst = computed(() => props.pagination.current_page === 1);
const currentIsLast = computed(
  () => props.pagination.current_page === props.pagination.last_page
);

function pageSelectionChange(event: Event): void {
  const value: string = (event.target as HTMLInputElement).value;
  const page: number = Number(value);

  changePage(isNaN(page) ? 1 : page);
}

function changePage(page: number): void {
  currentPage.value = page;
  emit("changePage", page);
}
</script>