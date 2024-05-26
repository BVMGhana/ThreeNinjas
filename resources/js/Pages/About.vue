<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import NavBar from '@/Components/NavBar.vue';
import Footer from '@/Components/Footer.vue';
import Analytics from '@/Components/Analytics.vue';
import axios from '../axiosConfig';


const usersCount = ref(null);
// const subscribersCount = ref(null);
const predictionsCount = ref(null);

const getData = async () => {
  try {
    let response;
    
    response = await axios.get('users-count');
    usersCount.value = response.data;

    // response = await axios.get('subscriptions-count');
    // subscribersCount.value = response.data;
    
    response = await axios.get('predictions-count');
    predictionsCount.value = response.data;

  } catch (error) {
    console.error('There was an error fetching the data: ', error);
  }
}

getData();

</script>

<template>
    <Head title="About Us" />

    <div class="h-screen w-screen overflow-x-hidden bg-[#EEF5FF] scroll-smooth fade-in">

        <!-- Navbar section -->
        <NavBar />

        <section class="mt-100px lg:mt-[77.5px] w-full">
            <article class="w-full flex flex-col lg:flex-row items-center justify-center mt-[10rem] mb-[7rem] px-2 lg:px-0">
              <div class="w-full lg:w-[41%] h-[600px] text-white bg-[#3c3c3c] flex flex-col justify-center gap-7 p-5">
                <h2 class="text-[#fc036b] text-[42px] text-center">Welcome to 3Ninja Odds Hub!</h2>
                <p class="text-center text-[18px]">
                  Our mission is to offer you the best odds for maximizing your betting experience and winnings. 
                  Whether you're a cautious player or a high-risk taker, our 3 Ninjas have diverse winning options tailored just for you.
                </p>
              </div>
              <div id="bg-section" class="w-full lg:w-[41%] h-[600px]">
                <!-- <img src="/images/about_us.png" alt="about us" width="100%" height="455"> -->
              </div>
            </article>
        </section>

        <!-- Analytics Section -->
        <Analytics :usersCount="usersCount" :predictionsCount="predictionsCount" />

        <section class="w-full block mb-[7rem]"></section>

        <!-- Footer section -->
        <Footer />

    </div>
</template>

<style scoped>
#bg-section {
  background: url('/images/about_us.jpg') center center /cover;
}

.fade-in {
  animation: fadeIn 0.2s ease-in-out;
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}
</style>