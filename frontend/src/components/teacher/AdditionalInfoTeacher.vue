<template>
    <div class="flex flex-col gap-3 md:flex-row md:justify-between">
        <AditionalInfoContainer>
            <AdditionalInfoTitle text="Criado em" />
            <AdditionalInfoValue :text="dateFormat(teacher.createdAt)" />
        </AditionalInfoContainer>

        <AditionalInfoContainer>
            <AdditionalInfoTitle text="Última atualização em" />
            <AdditionalInfoValue :text="dateFormat(teacher.updatedAt)" />
        </AditionalInfoContainer>
    </div>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';
import { TeacherModel } from '@/models/TeacherModel';
import AditionalInfoContainer from '@/components/common/aditionalInfo/AditionalInfoContainer.vue'
import AdditionalInfoTitle from '../common/aditionalInfo/AdditionalInfoTitle.vue';
import AdditionalInfoValue from '../common/aditionalInfo/AdditionalInfoValue.vue';
import { dateFormat } from '@/utils/functions/date';

interface AdditionalInfoTeacherProps {
    teacher: TeacherModel
}

defineProps<AdditionalInfoTeacherProps>()
</script>