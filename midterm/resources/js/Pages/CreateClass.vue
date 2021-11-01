<template>
    <app-layout title="교과목 등록">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                교과목 등록
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <div class="mb-4">
                                <label class="text-xl text-gray-600">교과목명 <span class="text-red-500">*</span></label>
                                <input type="text" class="border-2 border-gray-300 p-2 w-full" v-model="form.name">
                                <div v-if="errors.name"><span class="text-red-500">{{ errors.name }}</span></div>
                            </div>

                            <div class="mb-4">
                                <label class="text-xl text-gray-600">학점</label>
                                <input type="text" class="border-2 border-gray-300 p-2 w-full" v-model="form.credit">
                                <div v-if="errors.credit"><span class="text-red-500">{{ errors.credit }}</span></div>
                            </div>

                            <div class="mb-8">
                                <label class="text-xl text-gray-600">교과목 설명 <span class="text-red-500">*</span></label>
                                <ckeditor :editor="editor" v-model="form.description" :config="editorConfig"></ckeditor>
                                <div v-if="errors.description"><span class="text-red-500">{{ errors.description }}</span></div>
                            </div>

                            <div class="flex p-1">
                                <button role="submit" class="p-3 bg-blue-500 text-white hover:bg-blue-400" required>Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import { defineComponent } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';

export default defineComponent({
    props: {
        errors: Object
    },
    components: {
        AppLayout,
    },
    data() {
        return {
            editor: ClassicEditor,
            form: {
                name: null,
                credit: 3,
                description: '교과목 설명',
            }
        }
    },
    methods: {
        submit() {
            alert(this.form.description);
            this.$inertia.post('/classes/store', this.form)
        }
    }
});
</script>

<style>

</style>
