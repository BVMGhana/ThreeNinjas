<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import SubmitButton from '@/Components/SubmitButton.vue';
import NavBar from '@/Components/NavBar.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    errors: Object
});

const form = useForm({
    // email: '',
    phone: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <!-- <GuestLayout> -->
        <Head title="Log in" />

        <NavBar />

        <div v-if="status" class="py-2 mt-[70px] lg:mt-[77.5px] font-medium text-sm text-center text-[#00b041]">
            {{ status }}
        </div>
        <div id="main-bg" class="fade-in">
            <div class="text-white h-screen flex flex-col justify-center items-center gap-4">
                <div class="bg-slate-800 border border-slate-400 rounded-[12px] p-8 shadow-lg backdrop-filter 
                    backdrop-blur-sm bg-opacity-30 relative from-bottom">
                    <h1 class="text-4xl font-bold text-center mb-6">Login</h1>
                    <form @submit.prevent="submit">
                        <div v-if="errors.login" class="block my-7 text-[12px] text-[red] text-center">
                            {{ errors.login }}
                        </div>
                        <div class="relative my-4">
                            <input type="text" 
                                class="block w-72 py-2.3 px-0 text-sm bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:text-white peer" 
                                placeholder="" v-model="form.phone">
                            <label for="" 
                                class="absolute text-sm duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Your Phone Number</label>
                            <InputError :message="form.errors.phone" />
                            </div>
                        <div class="relative my-8">
                            <input type="password" v-model="form.password"
                            class="block w-72 py-2.3 px-0 text-sm bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:text-white peer" 
                            placeholder="">
                            <label for="" class="absolute text-sm duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Your Password</label>
                            <InputError :message="form.errors.password" />
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="flex gap-2 items-center">
                                <input type="checkbox" id="remember-me" :checked="form.remember">
                                <label for="remember-me">Remember Me</label>
                            </div>
                            <!-- <Link href="" class="text-blue-500">Forgot Password?</Link> -->
                            <Link :href="route('password.request')" class="text-blue-500">Forgot Password?</Link>
                        </div>
                        <SubmitButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Login
                        </SubmitButton>
                        <div class="text-center">
                            <span class="m-4">New Here? <Link class="text-blue-500" :href="route('register')">Create an account</Link></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <!-- </GuestLayout> -->
</template>

<style scoped>
#main-bg {
    background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url(/images/bg_login.jpg) no-repeat scroll center center /cover;
}

.from-bottom {
  animation: fromBottom 0.3s ease-in-out;
}

@keyframes fromBottom {
  from { opacity: 0; transform: translateY(60px); }
  to { opacity: 1; transform: translateY(0);}
}

.fade-in {
    animation: fadeIn 0.2s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}
</style>