<script setup>
import { ref, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';

const menuBtn = ref();
const navLinks = ref();
const isOpen = ref(false);

onMounted(() => {
  menuBtn.value.addEventListener('click', () => {
    navLinks.value.classList.toggle('mobile-menu');
    isOpen.value = !isOpen.value;
  });
});

</script>

<template>
    <nav class="navbar fixed top-0 left-0 w-full flex justify-between align-center 
        bg-[black] h-[70px] sm:h-[100px] lg:h-fit text-white p-0 m-0 z-50">
        
        <div class="flex items-center justify-between lg:p-[20px] bg-[#000]">
          <Link href="/" class="logo fixed lg:static top-[20px] sm:top-[30px] left-[20px] sm:left-[30px] text-[20px] sm:text-[30px] lg:text-[25px] text-[#fff]"
          :class="{ 'active': $page.url==='/' }"
          >3Ninjas</Link>
          <div id="menuButton" ref="menuBtn" class="flex items-center fixed lg:static 
            top-[10px] sm:top-[20px] right-[30px] sm:right-[40px] w-[30px] sm:w-[40px] lg:hidden w-[30px] sm:w-[40px] cursor-pointer">
            <span class="material-icons-sharp text-[2.5rem] sm:text-[3.5rem]" 
              v-if="isOpen===false">menu</span>
            <span class="material-icons-sharp text-[2.5rem] sm:text-[3.5rem]" 
              v-if="isOpen===true">close</span>
          </div>
        </div>

        <ul ref="navLinks" class="nav-links list-none flex flex-col lg:flex-row w-screen lg:w-auto 
          justify-center lg:justify-between lg:items-center h-[70vh] lg:h-auto bg-[rgba(0,0,0,0.93)] lg:bg-transparent mt-[-900px] lg:mt-0 
          transition-all duration-500 ease">
          <article class="flex flex-col lg:flex-row items-center lg:justify-between">
            <li v-if="$page.props.auth.user && $page.props.auth.user.name!==''" 
              class="my-[10px] sm:my-[20px] py-[5px] px-[20px] rounded-[5px] bg-[#fc036b] mx-auto lg:my-0 lg:mx-[30px] 
              font-bold text-[12px] sm:text-[15px] cursor-default">
              Welcome, {{ $page.props.auth.user.name.split(" ")[0] }}
            </li>
            <!-- <li class="my-[10px] sm:my-[20px] mx-auto lg:my-0 lg:mx-[30px] active text-[30px] lg:text-[20px]"
              v-if="$page.props.auth && $page.props.auth.user.is_admin"
            >
              <Link href="/">VIP</Link>
            </li> -->
            <li class="my-[10px] sm:my-[20px] mx-auto lg:my-0 lg:mx-[30px] text-[20px] sm:text-[30px] lg:text-[20px]">
              <Link class="text-[#fff]" :class="{ 'active': $page.url.includes('/about') }" href="/about">About Us</Link>
            </li>
            <li class="my-[10px] sm:my-[20px] mx-auto lg:my-0 lg:mx-[30px] text-[20px] sm:text-[30px] lg:text-[20px]">
              <Link class="text-[#fff]" :class="{ 'active': $page.url.includes('/contact') }" :href="route('contact')">Contact Us</Link>
            </li>
            <li class="my-[10px] sm:my-[20px] mx-auto lg:my-0 lg:mx-[30px] text-[20px] sm:text-[30px] lg:text-[20px]"
              v-if="$page.props.auth && $page.props.auth?.user?.is_admin"
            >
              <Link class="text-[#fff]" href="/dashboard">Dashboard</Link>
            </li>
          </article>
          <article class="flex flex-col lg:flex-row">
            <li v-if="$page.props.auth.user && $page.props.auth.user.name!==''" class="my-[10px] sm:my-[20px] mx-auto lg:my-0 lg:mx-[30px] text-[20px] sm:text-[30px] lg:text-[20px]">
              <Link class="text-[#fff]" :href="route('logout')" method="post" as="button">Logout</Link>
            </li>
            <li v-if="!$page.props.auth.user" class="my-[10px] sm:my-[20px] mx-auto lg:my-0 lg:mx-[30px] text-[20px] sm:text-[30px] lg:text-[20px]">
              <Link class="text-[#fff]" :class="{ 'active': $page.url.includes('/login') }" :href="route('login')">Login</Link>
            </li>
            <li v-if="!$page.props.auth.user" class="my-[10px] sm:my-[20px] mx-auto lg:my-0 lg:mx-[30px] text-[20px] sm:text-[30px] lg:text-[20px]">
              <Link class="text-[#fff]" :class="{ 'active': $page.url.includes('/register') }" :href="route('register')">Sign Up</Link>
            </li>
          </article>
        </ul>
      </nav>
</template>

<style scoped>
nav ul article a.active,
nav div a.active {
    color: #fc036b;
}

.mobile-menu {
  margin-top: 0;
  border-bottom-right-radius: 30%;
}
</style>