<template>
  <table class="overflow-scroll">
    <thead class="bg-gray-100">
      <th class="text-bold text-lg p-3 whitespace-nowrap" v-for="column in columns" :key="column">
        {{ column }}
      </th>
    </thead>
    <tbody class="text-center">
      <tr class="border-y-2 border-gray-100" v-for="row in rows" :key="row">
        <td class="text-base p-3" v-for="key in row" :key="key">
          {{ key }}
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script setup lang="ts">
import { defineProps } from "vue";

interface DataTableProps {
  columns: [];
  rows: [];
}

defineProps<DataTableProps>();
</script>
