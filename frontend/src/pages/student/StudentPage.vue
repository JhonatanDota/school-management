<template>
  <ContainerPage>
    <TitlePage title="Alunos" />
    <DataTable :columns="columns" :rows="rows"></DataTable>
  </ContainerPage>
</template>

<script setup lang="ts">
import ContainerPage from "@/pages/ContainerPage.vue";
import TitlePage from "@/pages/TitlePage.vue";
import DataTable from "@/components/datatable/DataTable.vue"

const columns = [
  'First Name', 'Last Name', 'Age'
];

const rows = [
  { name: "Jhonatan", lastName: 'Azevedo', age: 12 },
  { name: "Jhonatan", lastName: 'Azevedo', age: 12 },
  { name: "Jhonatan", lastName: 'Azevedo', age: 12 },
];


</script>
