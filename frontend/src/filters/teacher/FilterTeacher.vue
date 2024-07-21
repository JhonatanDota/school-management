<template>
    <InputLabel track="teacher-name-filter" text="Nome" />
    <InputText id="teacher-name-filter" v-model="name" />
</template>

<script setup lang="ts">
import { ref, watch, defineProps, defineEmits } from "vue";
import ParamsTeacher from "./ParamsTeacher";
import InputText from "@/components/common/form/inputs/InputText.vue";
import InputLabel from "@/components/common/form/inputs/InputLabel.vue";

const emit = defineEmits(["setParams"]);

interface FilterTeacherProps {
    params: ParamsTeacher;
}

const props = defineProps<FilterTeacherProps>();

const name = ref(props.params.name ?? "");

watch(name, (value) => {
    emit("setParams", { name: value, page: 1 });
});

</script>