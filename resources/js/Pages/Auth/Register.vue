<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';
import axios from '../../axiosConfig';

const form = useForm({
    name: '',
    // email: '',
    phone: '',
    password: '',
    password_confirmation: '',
});

const displayMessage = (message, type) => toast(message, { autoClose: 1000, type});

// const submit = async () => {
const submit = () => {
    // try {
    //     const response = await axios.post('register', form);
    //     if (response.status == 201) {
    //         displayMessage(response.data.message, 'success');
    //     }
    // } catch (error) {
    //     displayMessage(error.response.statusText, 'error');
    // }
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <!-- <GuestLayout> -->
        <Head title="Register" />

        <div id="main-bg" class="fade-in">
            <div class="text-white h-screen flex flex-col justify-center items-center gap-4">
                <Link href="/" class="text-[32px] text-center text-[#fff]">3 Ninjas Home</Link>
                <div class="bg-slate-800 border border-slate-400 rounded-md p-8 shadow-lg backdrop-filter backdrop-blur-sm bg-opacity-30 relative">
                    <h1 class="text-4xl font-bold text-center mb-6">Register</h1>
                    <form @submit.prevent="submit">
                        <div class="relative my-4">
                            <input type="text" v-model="form.name" class="block w-72 py-2.3 px-0 text-sm bg-transparent 
                                border-0 border-b-2 border-gray-300 appearance-none dark:focus:border-blue-500 
                                focus:outline-none focus:ring-0 focus:text-white peer" placeholder="">
                            <label for="" class="absolute text-sm duration-300 transform 
                                -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 
                                peer-focus:text-blue-600 peer-focus:dark:text-blue-500 
                                peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 
                                peer-focus:scale-75 peer-focus:-translate-y-6">Full Name</label>
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>
                        <div class="relative my-8">
                            <input type="text" v-model="form.phone" class="block w-72 py-2.3 px-0 text-sm bg-transparent border-0 
                                border-b-2 border-gray-300 appearance-none dark:focus:border-blue-500 
                                focus:outline-none focus:ring-0 focus:text-white peer" placeholder="">
                            <label for="" class="absolute text-sm duration-300 transform -translate-y-6 scale-75 
                                top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 
                                peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 
                                peer-placeholder-shown:translate-y-0 peer-focus:scale-75 
                                peer-focus:-translate-y-6">Your Phone Number</label>
                            <InputError class="mt-2" :message="form.errors.phone" />
                        </div>
                        <div class="relative my-8">
                            <input type="password" v-model="form.password" class="block w-72 py-2.3 px-0 text-sm 
                                bg-transparent border-0 border-b-2 border-gray-300 appearance-none 
                                dark:focus:border-blue-500 focus:outline-none focus:ring-0 
                                focus:text-white peer" placeholder="">
                            <label for="" class="absolute text-sm duration-300 transform -translate-y-6 scale-75 top-3 
                                -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 
                                peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 
                                peer-placeholder-shown:translate-y-0 peer-focus:scale-75 
                                peer-focus:-translate-y-6">Your Password</label>
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>
                        
                        <div class="relative my-8">
                            <input type="password" v-model="form.password_confirmation" class="block w-72 py-2.3 px-0 text-sm bg-transparent 
                                border-0 border-b-2 border-gray-300 appearance-none dark:focus:border-blue-500 
                                focus:outline-none focus:ring-0 focus:text-white peer" placeholder="">
                            <label for="" class="absolute text-sm duration-300 transform 
                                -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 
                                peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 
                                peer-placeholder-shown:translate-y-0 peer-focus:scale-75 
                                peer-focus:-translate-y-6">Confirm Password</label>
                            <InputError class="mt-2" :message="form.errors.password_confirmation" />
                        </div>
                        <button class="w-full mb-4 text-[18px] mt-6 rounded-[40px] bg-white text-emerald-800 
                            hover:bg-emerald-600 hover:text-white py-2 transition-colors duration-300"
                            :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                            type="submit">Register</button>
                        <div class="text-center">
                            <span class="m-4">Already registered? <Link class="text-blue-500" :href="route('login')">Log In</Link></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <!-- </GuestLayout> -->
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