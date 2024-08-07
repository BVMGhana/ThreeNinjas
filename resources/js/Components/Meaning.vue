<script setup>
import { ref, onMounted, reactive } from 'vue';

onMounted(() => {

});

defineProps({
    usersCount: {
        type: Number,
        required: true
    },
    predictionsCount: {
        type: Number,
        required: true
    }
});

</script>

<template>
    <section id="analytics" class="w-full h-fit px-1 mt-[4rem] mb-[10rem] flex flex-col items-center">
        <div class="my-6 lg:text-[28px] font-bold">
            <h2>What it means to register on 3Ninjas</h2>
        </div>
        <div class="w-full flex flex-col lg:flex-row flex-wrap items-start justify-between gap-[60px] lg:gap-[20px]">
          <article class="w-full lg:w-[23%] flex flex-col items-center gap-5">
            <div class="container w-[135px] sm:w-[155px] lg:w-[150px] h-[135px] sm:h-[155px] lg:h-[150px]
            flex flex-col justify-around items-center py-[1em] px-0 text-[16px] rounded-[50%]
              bg-[#21242b]">
            <i class="far fa-registered text-cyan-200 text-[2.5em]"></i>
          </div>
          <div class="w-[90%] lg:w-[95%]">
            <p class="font-normal text-[13px] md:text-[15px]">
                <span class="font-semibold text-[#fc036b]">Registering on 3Ninjas provides you with a wealth of resources and advantages designed to enhance your betting experience. </span> With daily expert tips, personalized recommendations, and exclusive VIP content, you’ll be equipped with the knowledge and tools needed to make smarter bets. 
            </p>
          </div>
          </article>
           <article class="w-full lg:w-[23%] flex flex-col items-center gap-5">
            <div class="container w-[135px] sm:w-[155px] lg:w-[150px] h-[135px] sm:h-[155px] lg:h-[150px]
            flex flex-col justify-around items-center py-[1em] px-0 text-[16px] rounded-[50%]
              bg-[#21242b]">
              <i class="fas fa-sms text-cyan-200 text-[2.5em]"></i>
          </div>
          <div class="w-[90%] lg:w-[95%]">
            <p class="font-normal text-[13px] md:text-[15px]">
                <span class="font-semibold text-[#fc036b]">Get daily tips and odds delivered to you via SMS or Email: </span> Stay ahead of the game with expert insights sent directly to your phone or inbox. Our tips are curated by seasoned professionals to help you make informed decisions.
            </p>
          </div>
          </article>
           <article class="w-full lg:w-[23%] flex flex-col items-center gap-5">
            <div class="container w-[135px] sm:w-[155px] lg:w-[150px] h-[135px] sm:h-[155px] lg:h-[150px]
            flex flex-col justify-around items-center py-[1em] px-0 text-[16px] rounded-[50%]
              bg-[#21242b]">
              <i class="fas fa-money-bill-wave text-cyan-200 text-[2.5em]"></i>
          </div>
          <div class="w-[90%] lg:w-[95%]">
            <p class="font-normal text-[13px] md:text-[15px]">
                <span class="font-semibold text-[#fc036b]">Get free VIP slips from White and Black Ninjas: </span> Gain access to exclusive VIP slips from our top analysts, White and Black Ninjas, known for their accuracy and winning strategies.
            </p>
          </div>
          </article>
           <article class="w-full lg:w-[23%] flex flex-col items-center gap-5">
            <div class="container w-[135px] sm:w-[155px] lg:w-[150px] h-[135px] sm:h-[155px] lg:h-[150px]
            flex flex-col justify-around items-center py-[1em] px-0 text-[16px] rounded-[50%]
              bg-[#21242b]">
              <i class="fas fa-universal-access text-cyan-200 text-[2.5em]"></i>
          </div>
          <div class="w-[90%] lg:w-[95%]">
            <p class="font-normal text-[13px] md:text-[15px]">
                <span class="font-semibold text-[#fc036b]">Early Access to Special Offers and Promotions: </span> Be the first to know about special deals, promotions, and contests that can maximize your betting potential and enhance your overall experience.
            </p>
          </div>
          </article>
        </div>
    </section>
</template>

<style>

</style>