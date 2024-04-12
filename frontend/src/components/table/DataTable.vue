<template>
  <div
    v-if="!loadingData"
    class="overflow-x-scroll"
    v-motion
    :initial="{ opacity: 0, x: -100 }"
    :enter="{ opacity: 1, x: 0 }"
    :delay="300"
  >
    <table
      class="table-auto w-full overflow-hidden rounded-lg bg-[#222D32] font-bold text-white"
    >
      <thead>
        <th
          class="text-base md:text-lg p-4 md:p-5"
          v-for="(th, index) in thList"
          :key="index"
        >
          {{ th.text }}
        </th>
      </thead>

      <tbody>
        <tr
          v-for="item in data"
          :key="item.id"
          class="text-sm md:text-base text-center odd:bg-gray-600"
        >
          <template v-for="(value, key) in item">
            <td v-if="tdKeys.includes(key)" :key="key" class="p-3 md:p-6">
              {{ value }}
            </td>
          </template>
        </tr>
      </tbody>
    </table>
    <div class="flex justify-center my-5 md:my-10">
      <LoadIcon
        v-if="loadingData"
        class="animate-pulse w-10 h-10"
        fill="#632C96"
      />
      <p
        v-if="!loadingData && !data.length"
        class="text-sm md:text-xl font-medium tracking-wider uppercase"
      >
        Sem dados 😢
      </p>
    </div>
  </div>
</template>

<script setup lang="ts">
import { defineProps, withDefaults } from "vue";
import { ThModel } from "@/models/DataTableModel";
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
