<template>
  <div class="overflow-x-scroll" v-motion :initial="{ opacity: 0, x: -100 }" :enter="{ opacity: 1, x: 0 }" :delay="300">
    <table class="table-auto w-full overflow-hidden rounded-lg bg-[#222D32] font-bold text-white">
      <thead>
        <th class="text-base md:text-lg p-4 md:p-5" v-for="(th, index) in thList" :key="index">
          {{ th.text }}
        </th>
      </thead>

      <tbody v-if="!isLoading" v-motion :initial="{ opacity: 0, x: -100 }" :enter="{ opacity: 1, x: 0 }" :delay="100">
        <tr :class="[selectableRow && 'cursor-pointer hover:bg-green-400/70 transition-colors']" v-for="item in data"
          :key="Number(item.id)" @click="selectRowItemId(Number(item.id))"
          class="text-sm md:text-base text-center odd:bg-gray-600">
          <template v-for="(value, key) in item">
            <td v-if="tdKeys.includes(key)" :key="key" class="p-3 md:p-6">
              {{ parseableKeys.hasOwnProperty(key) ? parseableKeys[key](value) : value ?? '-' }}
            </td>
          </template>
        </tr>
      </tbody>
    </table>

    <div class="flex justify-center">
      <LoadIcon v-if="isLoading" class="animate-pulse w-10 h-10 md:w-14 md:h-14 mt-5 md:mt-8" fill="#632C96" />

      <p v-if="!isLoading && !data.length" class="text-sm md:text-xl font-medium tracking-wider uppercase mt-5 md:mt-8">
        Sem dados 😢
      </p>
    </div>
  </div>
</template>

<script setup lang="ts">
import { defineProps, defineEmits, withDefaults } from "vue";
import { ThModel } from "@/models/DataTableModel";
import LoadIcon from "@/icons/LoadIcon.vue";
import { dateFormat } from "@/utils/functions/date";

interface DataTableProps {
  thList: ThModel[];
  tdKeys: string[];
  selectableRow: boolean;
  isLoading: boolean;
  data: Record<string, string | number | boolean | Date>[];
}

const parseableKeys: Record<string, (value: any) => string> =
{
  "createdAt": (date: string) => dateFormat(new Date(date)),
  "updatedAt": (date: string) => dateFormat(new Date(date)),
  "isActive": (condition: boolean) => condition ? "Sim" : "Não",
}


withDefaults(defineProps<DataTableProps>(), {
  isLoading: true,
});

const emit = defineEmits(["select-row-item-id"]);

function selectRowItemId(id: number): void {
  emit("select-row-item-id", id);
}

</script>
