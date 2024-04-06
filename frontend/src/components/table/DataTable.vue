<template>
  <div class="overflow-x-scroll">
    <table
      class="table-auto w-full overflow-hidden rounded-lg bg-[#222D32] font-bold text-white"
    >
      <thead class="text-base">
        <th class="p-4" v-for="(th, index) in thList" :key="index">
          {{ th.text }}
        </th>
      </thead>

      <tbody>
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
  </div>
</template>

<script setup lang="ts">
import { ThModel } from "@/models/DataTableModel";
import { defineProps } from "vue";

interface DataTableProps {
  thList: ThModel[];
  tdKeys: string[];
  data: Record<string, any>[];
}

defineProps<DataTableProps>();
</script>
