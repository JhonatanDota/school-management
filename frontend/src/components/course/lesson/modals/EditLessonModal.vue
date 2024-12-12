<template>
    <BaseModal title="Editar Lição" v-model="isVisible">
        <form class="flex flex-col gap-2" @submit.prevent="onSubmit">
            <div class="flex flex-col gap-2">
                <InputLabel text="Nome" track="lesson-name" />
                <InputText id="lesson-name" v-model="editableCourseLesson.name" />
            </div>
            <SubmitButton class="float-right" text="Salvar" />
        </form>
    </BaseModal>
</template>

<script setup lang="ts">
import { ref, defineProps, defineEmits, watch } from 'vue';
import { CourseLessonModel, CourseLessonUpdateModel } from '@/models/CourseLessonModel';
import { updateCourseLesson } from '@/requests/courseLessonRequests';
import { toast } from '@/utils/functions/toast';
import BaseModal from '@/components/common/modal/BaseModal.vue';
import InputLabel from '@/components/common/form/inputs/InputLabel.vue';
import InputText from '@/components/common/form/inputs/InputText.vue';
import SubmitButton from '@/components/common/form/SubmitButton.vue';

interface EditLessonModalProps {
    modelValue: boolean;
    courseLesson: CourseLessonModel;
}

const props = defineProps<EditLessonModalProps>();
const emit = defineEmits<{
    (event: 'update:modelValue', value: boolean): void;
    (event: 'updateCourseLesson', value: CourseLessonModel): void;
}>();

const editableCourseLesson = ref<CourseLessonModel>({ ...props.courseLesson });
const isVisible = ref(props.modelValue);

watch(() => props.modelValue, (newValue) => {
    isVisible.value = newValue;
});

watch(isVisible, (newValue) => {
    emit('update:modelValue', newValue);
});

watch(() => props.courseLesson, (newValue) => {
    editableCourseLesson.value = { ...newValue };
});

async function onSubmit(): Promise<void> {
    try {
        const parsedCourseLessonData = editCourseLessonDataParser(editableCourseLesson.value);
        const updateCourseLessonResponse = await updateCourseLesson(editableCourseLesson.value.id, parsedCourseLessonData);

        emit('updateCourseLesson', updateCourseLessonResponse.data);
        toast("Lição editada!");
    } catch {
        //
    }
}

function editCourseLessonDataParser(courseLesson: CourseLessonModel): CourseLessonUpdateModel {
    return {
        name: courseLesson.name
    };
}
</script>
