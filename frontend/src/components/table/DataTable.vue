<template>
  <div class="overflow-x-scroll">
    <table
      class="table-auto w-full overflow-hidden rounded-lg bg-[#222D32] font-bold text-white"
    >
      <thead class="text-xs">
        <th class="p-4" v-for="(th, index) in thList" :key="index">
          {{ th.text }}
        </th>
      </thead>

      <tbody v-if="!loadingData">
        <tr
          v-for="item in data"
          :key="item.id"
          class="text-sm text-center odd:bg-gray-600"
        >
          <template v-for="(value, key) in item">
            <td v-if="tdKeys.includes(key)" :key="key" class="p-3">
              {{ value }}
            </td>
          </template>
        </tr>
      </tbody>
    </table>
    <div class="flex justify-center my-5">
      <LoadIcon
        v-if="loadingData"
        class="animate-pulse w-10 h-10"
        fill="#632C96"
      />
      <p
        v-if="!loadingData && !data.length"
        class="text-sm font-medium tracking-wider"
      >
        Sem dados 😢
      </p>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ThModel } from "@/models/DataTableModel";
import { defineProps, withDefaults } from "vue";
import LoadIcon from "@/icons/LoadIcon.vue";

interface DataTableProps {
  thList: ThModel[];
  tdKeys: string[];
  loadingData: boolean;
  data: Record<string, any>[];
}

withDefaults(defineProps<DataTableProps>(), {
  loadingData: true,
});
</script>
