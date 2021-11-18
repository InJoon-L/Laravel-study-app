<template>
    <app-layout title="Dashboard">
        <template #header>
            <div class="flex flex-row items-start">
                <div class="flex-shrink-0 mr-3 px-40"
                    v-if="$page.props.jetstream.managesProfilePhotos">
                    <img :src="$page.props.user.profile_photo_url"
                        :alt="$page.props.user.name" class="rounded-full h-40 w-40 object-cover" />
                </div>
                <div class="flex-col justify-items-start">
                    <div class="flex flex-row justify-between">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            {{ user.name }}
                        </h2>
                        <!-- <Link :href="route('post.create')"> -->
                            <jet-secondary-button class="mb-4" @click="createNewPost=true">Add New Post</jet-secondary-button>
                            <jet-secondary-button class="mb-4" @click="editProfile=true">Edit Profile</jet-secondary-button>
                        <!-- </Link> -->
                    </div>
                    <div class="mb-4 flex flex-row">
                        <div class="mr-10">게시물 <span class="font-black">{{ posts.length }}</span> </div>
                        <div class="mr-10">팔로워 80</div>
                        <div class="mr-10">팔로우 72</div>
                    </div>
                    <div class="mb-4">{{ user.username }}</div>
                    <div class="mb-4">{{ user.profile ? user.profile.title : 'No Title'}}</div>
                    <div class="mb-4">{{ user.profile ? user.profile.description : 'No Description'}}</div>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <post-list :posts="posts" />
                </div>
            </div>
        </div>

        <jet-dialog-modal :show="createNewPost" @close="createNewPost = false">
            <template #title>
                Create New Post
            </template>

            <template #content>
                <form @submit.prevent="submit">
                    <div>
                        <jet-label for="caption" value="caption" />
                        <jet-input id="caption" type="text" class="block w-full mt-1"
                            v-model="form.caption" required autofocus autocomplete="caption" />
                        <jet-input-error :message="form.errors.caption" class="mt-2" />
                    </div>
                    <div>
                        <jet-label for="image" value="image" />
                        <input type="file" class="hidden"
                            ref="image"
                            @change="updateImagePreview" />
                        <div class="mt-2" v-show="imagePreview">
                            <span class="block w-20 h-20 bg-center bg-no-repeat bg-cover rounded-full"
                                :style="'background-image: url(\'' + imagePreview + '\');'">
                            </span>
                        </div>

                        <jet-secondary-button class="mt-2 mr-2" type="button" @click.prevent="selectNewImage">
                            Select A New Image
                        </jet-secondary-button>

                        <jet-input-error :message="form.errors.image" class="mt-2" />
                        <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                            {{ form.progress.percentage }}%
                        </progress>
                    </div>
                </form>
            </template>

            <template #footer>
                <jet-secondary-button @click.prevent="submit">
                    Create
                </jet-secondary-button>
            </template>
        </jet-dialog-modal>

        <jet-dialog-modal :show="editProfile" @close="editProfile = false">
            <template #title>
                Update Profile
            </template>

            <template #content>
                <form @submit.prevent="updateProfile">
                    <div class="mb-2">
                        <jet-label for="title" value="title" />
                        <jet-input id="title" type="text" class="block w-full mt-1"
                            v-model="updateProfileForm.title" required autofocus autocomplete="title" />
                        <jet-input-error :message="updateProfileForm.errors.title" class="mt-2" />
                    </div>

                    <div class="mb-2">
                        <jet-label for="description" value="description" />
                        <textarea id="description" cols="40" rows="10" class="form-textarea"
                            v-model="updateProfileForm.description"
                            required autofocus autocomplete="description"></textarea>
                        <jet-input-error :message="updateProfileForm.errors.description" class="mt-2" />
                    </div>
                </form>
            </template>

            <template #footer>
                <jet-secondary-button @click.prevent="updateProfile">
                    Update Profile
                </jet-secondary-button>
            </template>
        </jet-dialog-modal>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import PostList from '@/Pages/Instagram/PostList.vue'
    import JetDialogModal from '@/Jetstream/ConfirmationModal.vue'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetInputError from '@/Jetstream/InputError.vue'
    import JetLabel from '@/Jetstream/Label.vue'

    export default defineComponent({
        props:[
            'user',
            'posts'
        ],
        components: {
            AppLayout,
            PostList,
            JetDialogModal,
            JetSecondaryButton,
            JetInput,
            JetInputError,
            JetLabel
        },
        data() {
            return {
                form: this.$inertia.form({
                    _method: 'POST',
                    caption: '',
                    image: '',
                }),
                createNewPost: false,
                imagePreview: null,
                editProfile: false,

                updateProfileForm: this.$inertia.form({
                    _method: 'PATCH',
                    title: '',
                    description: '',
                })
            }
        },

        methods: {
            submit() {
                if (this.$refs.image) {
                    this.form.image = this.$refs.image.files[0]
                }
                this.form.post(route('post.store'), {
                    errorBag: 'createNewPost',
                    preserveScroll: true,
                    onSuccess: () => {this.createNewPost = false; this.clearFields(); },
                });
            },
            clearFields() {
                this.form.caption = '';
                this.form.image = '';
            },
            updateImagePreview() {
                const photo = this.$refs.image.files[0];

                if (!photo) return ;

                const reader = new FileReader();

                reader.onload = (e) => {
                    this.imagePreview = e.target.result;
                };

                reader.readAsDataURL(photo);
            },

            selectNewImage() {
                this.$refs.image.click();
            },
            clearUpdateProfileFields() {
                this.updateProfileForm.description = '';
                this.updateProfileForm.title = '';
                this.editProfile = false;
            },
            updateProfile() {
                this.updateProfileForm.post(route('profile.update'), {
                    errorBag: 'updateProfile',
                    preserveScroll: true,
                    onSuccess: () => {
                        this.clearUpdateProfileFields();
                    }
                })
            }
        }
    })
</script>
