<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputErrorOpaque from '@/Components/InputErrorOpaque.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SubmitButton from '@/Components/SubmitButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout id="main-bg" class="fade-in px-[7px]">
        <Head title="Reset Password" />

        <form @submit.prevent="submit">
            <div>
                <InputLabel class="text-white" for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputErrorOpaque class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel class="text-white" for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <InputErrorOpaque class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel class="text-white" for="password_confirmation" value="Confirm Password" />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputErrorOpaque class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <SubmitButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Reset Password
                </SubmitButton>
            </div>
        </form>
    </GuestLayout>
</template>

<style scoped>
#main-bg {
    background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url(/images/bg_register.jpg) no-repeat scroll center center /cover;
}

.fade-in {
    animation: fadeIn 0.2s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}
</style>
