<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
// import { usePage } from '@inertiajs/inertia-vue3';
import { onMounted, watch, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import axios from '../axiosConfig';
import Dashboard from './Dashboard/Dashboard.vue';
import Buttons from './Dashboard/Buttons.vue';
import Banners from './Dashboard/Banners.vue';
import Tips from './Dashboard/Tips.vue';
import Fixtures from './Dashboard/Fixtures.vue';
import Leagues from './Dashboard/Leagues.vue';
import Users from './Dashboard/Users.vue';
import WhiteNinja from './Dashboard/WhiteNinja.vue';
import BlackNinja from './Dashboard/BlackNinja.vue';
import RedNinja from './Dashboard/RedNinja.vue';
import PreviousResult from './Dashboard/PreviousResult.vue';
// import Betcode from './Dashboard/Betcode.vue';

onMounted(() => {
    const sideMenu = document.querySelector("aside");
    const menuBtn = document.querySelector("#menu-btn");
    const closeBtn = document.querySelector("#close-btn");
    const themeToggler = document.querySelector(".theme-toggler");

    if (document.body.classList.value==="dark-theme-variables") {
        themeToggler.querySelector('span:nth-child(1)').classList.remove('active');
        themeToggler.querySelector('span:nth-child(2)').classList.add('active');
    } else {
        themeToggler.querySelector('span:nth-child(2)').classList.remove('active');
        themeToggler.querySelector('span:nth-child(1)').classList.add('active');
    }

    // show sidebar
    menuBtn?.addEventListener("click", () => {
        sideMenu.style.display = "block";
    });

    // hide sidebar
    closeBtn.addEventListener("click", () => {
        sideMenu.style.display = "none";
    });

    // change theme
    themeToggler?.addEventListener("click", () => {
        document.body.classList.toggle("dark-theme-variables");

        themeToggler.querySelector('span:nth-child(1)').classList.toggle('active');
        themeToggler.querySelector('span:nth-child(2)').classList.toggle('active');
    });
});

const displayMessage = (message, type) => toast(message, { autoClose: 1000, type });

const dashboardUrl = '/dashboard';
const usersUrl = '/dashboard/users';
const whiteNinjaUrl = '/dashboard/white-ninja';
const redNinjaUrl = '/dashboard/red-ninja';
const blackNinjaUrl = '/dashboard/black-ninja';
const previousResultUrl = '/dashboard/previous-result';
const leaguesUrl = '/dashboard/leagues';
const fixturesUrl = '/dashboard/fixtures';
const tipsUrl = '/dashboard/tips';
const bannersUrl = '/dashboard/banners';
const buttonsUrl = '/dashboard/buttons';
// const betcodeUrl = '/dashboard/betcodes';

const { url } = usePage();
const stateUrl = ref(null);
stateUrl.value = url;

</script>

<template>
    <Head title="Dashboard" />

    <section id="mainContainer" class="fade-in">
        <div class="container">
            <aside>
                <div class="top">
                    <div class="logo">
                        <h2>Three <span class="danger">Ninjas</span></h2>
                    </div>
                    <div class="close" id="close-btn">
                        <span class="material-icons-sharp">close</span>
                    </div>
                </div>
                <div class="sidebar">
                    <Link href="/dashboard" :class="{ 'active': $page.url === dashboardUrl }">
                        <span class="material-icons-sharp">grid_view</span>
                        <h3>Dashboard</h3>
                    </Link>
                    <Link href="/dashboard/users" :class="{ 'active': $page.url.includes(usersUrl) }">
                        <span class="material-icons-sharp">account_circle</span>
                        <h3>Users</h3>
                    </Link>
                    <Link href="/dashboard/white-ninja" :class="{ 'active': $page.url.includes(whiteNinjaUrl) }">
                        <span class="material-icons-sharp">person_outline</span>
                        <h3>White Ninja</h3>
                    </Link>
                    <Link href="/dashboard/red-ninja" :class="{ 'active': $page.url.includes(redNinjaUrl) }">
                        <span class="material-icons-sharp">grid_view</span>
                        <h3>Red Ninja</h3>
                    </Link>
                    <Link href="/dashboard/black-ninja" :class="{ 'active': $page.url.includes(blackNinjaUrl) }">
                        <span class="material-icons-sharp">person_add</span>
                        <h3>Black Ninja</h3>
                    </Link>
                    <Link href="/dashboard/previous-results" :class="{ 'active': $page.url.includes(previousResultUrl) }">
                        <span class="material-icons-sharp">preview</span>
                        <h3>Previous Results</h3>
                    </Link>
                    <Link href="/dashboard/leagues" :class="{ 'active': $page.url.includes(leaguesUrl) }">
                        <span class="material-icons-sharp">insights</span>
                        <h3>Leagues</h3>
                    </Link>
                    <!-- <Link href="/dashboard/fixtures">
                        <span class="material-icons-sharp">settings</span>
                        <h3>Fixtures</h3>
                    </Link> -->
                    <Link href="/dashboard/tips" :class="{ 'active': $page.url.includes(tipsUrl) }">
                        <span class="material-icons-sharp">analytics</span>
                        <h3>Tips</h3>
                    </Link>
                    <Link href="/dashboard/banners" :class="{ 'active': $page.url.includes(bannersUrl) }">
                        <span class="material-icons-sharp">stay_current_landscape</span>
                        <h3>Banners</h3>
                    </Link>
                    <Link href="/dashboard/buttons" :class="{ 'active': $page.url.includes(buttonsUrl) }">
                        <span class="material-icons-sharp">smart_button</span>
                        <h3>Buttons</h3>
                    </Link>
                    <!-- <Link href="/dashboard/betcodes" :class="{ 'active': $page.url.includes(betcodeUrl) }">
                        <span class="material-icons-sharp">password</span>
                        <h3>Bet Code</h3>
                    </Link> -->
                    <Link href="/">
                        <span class="material-icons-sharp">home</span>
                        <h3>Homepage</h3>
                    </Link>
                    <Link :href="route('logout')" method="post">
                        <span class="material-icons-sharp">logout</span>
                        <h3>Logout</h3>
                    </Link>
                </div>
            </aside>
            <!-- End of aside -->

            <article>
                <Dashboard v-if="$page.url === dashboardUrl">

                </Dashboard>

                <Users v-if="$page.url.startsWith(usersUrl)">

                </Users>

                <WhiteNinja v-if="$page.url.startsWith(whiteNinjaUrl)">

                </WhiteNinja>

                <RedNinja v-if="$page.url.startsWith(redNinjaUrl)">

                </RedNinja>

                <BlackNinja v-if="$page.url.startsWith(blackNinjaUrl)">

                </BlackNinja>

                <PreviousResult v-if="$page.url.startsWith(previousResultUrl)">

                </PreviousResult>

                <Leagues v-if="$page.url.startsWith(leaguesUrl)">

                </Leagues>

                <Fixtures v-if="$page.url.startsWith(fixturesUrl)">

                </Fixtures>
                <Tips v-if="$page.url.startsWith(tipsUrl)">

                </Tips>
                <Banners v-if="$page.url.startsWith(bannersUrl)">

                </Banners>
                <Buttons v-if="$page.url.startsWith(buttonsUrl)">

                </Buttons>
                <!-- <Betcode v-if="$page.url.startsWith(betcodeUrl)">

                </Betcode> -->
            </article>
        </div>
    </section>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

/* * {
    margin: 0;
    padding: 0;
    outline: 0;
    appearance: none;
    border: 0;
    text-decoration: none;
    list-style: none;
    box-sizing: border-box;
} */

.fade-in {
  animation: fadeIn 0.6s ease-in-out;
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

.heading-2 {
    color: var(--color-dark-variant);
}

/* w-screen h-screen bg-color-background text-[14px] text-color-dark select-none overflow-x-hidden */
#mainContainer {
    width: 100vw;
    height: 100vh;
    font-family: poppins, sans-serif;
    font-size: 0.88rem;
    background: var(--color-background);
    user-select: none;
    overflow-x: hidden;
}


.container {
    display: grid;
    width: 100%;
    margin: 0 auto;
    gap: 1.8rem;
    grid-template-columns: 14rem auto;
}

a {
    color: var(--color-dark);
}

img {
    display: block;
    width: 100%
}

h1 {
    font-weight: 800;
    font-size: 1.8rem;
}

h2 {
    font-size: 1.4rem;
}

h3 {
    font-size: 0.87rem;
}

h4 {
    font-size: 0.8rem;
}

h5 {
    font-size: 0.77rem;
}

small {
    font-size: 0.75rem;
}

.text-muted {
    color: var(--color-info-dark);
}

p {
    color: var(--color-dark-variant);
}

b {
    color: var(--color-dark);
}

.primary {
    color: var(--color-primary);
}

.danger {
    color: var(--color-danger);
}

.success {
    color: var(--color-success);
}

.warning {
    color: var(--color-warning);
}

.heading {
    color: var(--color-dark);
}

aside {
    height: 100vh;
}

aside .top {
    background: white;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 1.4rem;
}

aside .logo {
    display: flex;
    gap: 0.8rem;
}

aside .logo img {
    width: 2rem;
    height: 2rem;
}

aside .close {
    display: none;
}

/* Sidebar */
aside .sidebar {
    display: flex;
    flex-direction: column;
    height: 86vh;
    position: relative;
    top: 3rem;
}

aside h3 {
    font-weight: 500;
}

aside .sidebar a {
    display: flex;
    color: var(--color-info-dark);
    margin-left: 2rem;
    gap: 1rem;
    align-items: center;
    position: relative;
    height: 3.7rem;
    transition: all 300ms ease;
}

aside .sidebar a span {
    font-size: 1.6rem;
    transition: all 300ms ease;
}

aside .sidebar a:last-child {
    margin-top: 1rem;
    /* position: absolute; */
    /* bottom: 0; */
    width: 100%;
}

aside .sidebar a.active {
    background: var(--color-light);
    color: var(--color-primary);
    margin-left: 0;
}

aside .sidebar a.active:before {
    content: "";
    width: 6px;
    height: 100%;
    background: var(--color-primary);
}

aside .sidebar a.active span {
    color: var(--color-primary);
    margin-left: calc(1rem - 3px);
}

aside .sidebar a:hover {
    color: var(--color-primary);
}

aside .sidebar a:hover span {
    margin-left: 1rem;
}

aside .sidebar .message-count {
    background: var(--color-danger);
    color: var(--color-white);
    padding: 2px 10px;
    font-size: 11px;
    border-radius: var(--border-radius-1);
}

/* main */

@media screen and (max-width: 1200px) {
    /* .container {
        grid-template-columns: 7rem auto 23rem;
    } */

    aside .sidebar h3 {
        display: none;
    }

    aside .sidebar a {
        width: 5.6rem;
    }

    aside .sidebar a:last-child {
        position: relative;
        margin-top: 1.8rem;
    }
}

@media screen and (max-width: 768px) {
    .container {
        width: 100%;
        grid-template-columns: 1fr;
    }

    aside {
        position: fixed;
        left: -100%;
        background: var(--color-white);
        width: 18rem;
        z-index: 3;
        box-shadow: 1rem 3rem 4rem var(--color-light);
        height: 100vh;
        padding-right: var(--card-padding);
        display: none;
        animation: showMenu 400ms ease forwards;
    }

    @keyframes showMenu {
        to {
            left: 0;
        }
    }

    aside .logo {
        margin-left: 1rem;
    }

    aside .logo h2 {
        display: inline;
    }

    aside .sidebar h3 {
        display: inline;
    }

    aside .sidebar a {
        width: 100%;
        height: 3.4rem;
    }

    aside .sidebar a:last-child {
        position: absolute;
        bottom: 5rem;
    }

    aside .close {
        display: inline-block;
        cursor: pointer;
    }
}
</style>