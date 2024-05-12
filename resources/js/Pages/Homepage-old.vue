<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

// console.log({ canLogin });

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="Homepage" />
    <!-- <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50"> -->
    <div class="h-screen w-full">

        <!-- <div class="selection:bg-[#FF2D20] selection:text-white"> -->
        <div class="h-screen w-full">
            <!-- <nav class="navbar navbar-expand-lg bg-body-tertiary fixed w-full" data-bs-theme="dark">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">Navbar</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                        <Link class="nav-link active" aria-current="page" :href="route('login')">Home</Link>
                        </li>
                        <li class="nav-item">
                        <Link class="nav-link" :href="route('register')">Link</Link>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                        </li>
                    </ul>
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                    </div>
                </div>
            </nav> -->
            <div id="main-bg" class="h-full w-full">
                <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                    <div class="flex lg:justify-center lg:col-start-2">

                    </div>
                    <nav v-if="canLogin" class="flex flex-1 justify-center">
                        <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]">
                        Dashboard
                        </Link>

                        <template v-else>
                            <Link :href="route('login')"
                                class="rounded-md mx-1 bg-[#009578] text-white px-5 py-[5px] transition duration-400 hover:bg-white hover:text-[#009578] focus:outline-none focus-visible:ring-[#FF2D20]">
                            LOG IN
                            </Link>

                            <Link v-if="canRegister" :href="route('register')"
                                class="rounded-md mx-1 px-5 py-[5px] text-[#009578] transition transition-duration-400 hover:text-white hover:bg-[#009578] focus:outline-none focus-visible:ring-[#FF2D20]">
                            SIGN UP
                            </Link>
                        </template>
                    </nav>
                    
                </header>
                <article class="text-white text-[3rem] md:text-[4rem] ml-5 md:ml-10 lg:ml-20 mt-3 font-extrabold">
                    <h1 class="leading-[50px] md:leading-[70px] my-0 py-0">Welcome to</h1>
                    <h1 class="leading-[50px] md:leading-[70px] my-0 py-0">3Ninjas Odds</h1>
                    <h1 class="leading-[50px] md:leading-[70px] my-0 py-0">Hub!</h1>
                </article>
                <article class="text-white mx-5 md:mx-0 md:ml-10 lg:ml-20 mt-2 font-normal w-21">
                    <h1 class="leading-[1.3] text-[20px]">Get your High and Low Risk slips from The No. 1 Sports Prediction Guru.</h1>
                </article>
            </div>
            <main class="mt-6">

            </main>

            <footer class="py-16 text-center text-sm text-black dark:text-white/70">

            </footer>
        </div>
    </div>
</template>

<style scoped>
#main-bg {
    background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url(/images/bg.jpg) no-repeat scroll center center /cover;
}
</style>