<script setup>
import { ref, onMounted, reactive } from 'vue';

onMounted(() => {
    const options = {
    root: null,
    rootMargin: '0px',
    threshold: 0.5
  };

  let observer = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        let valueDisplays = document.querySelectorAll(".num");
        let interval = 5000;
        
        valueDisplays.forEach(valueDisplay => {
          let startValue = 0;
          let endValue = parseInt(valueDisplay.getAttribute("data-val"));

          if (endValue === 0) return;
          
          let duration = Math.floor(interval / endValue);
          let counter = setInterval(() => {
            startValue +=1;
            valueDisplay.textContent = startValue;
            if (startValue === endValue) {
              clearInterval(counter);
            }
          }, duration);
        });
          observer.unobserve(entry.target);
      }
    });
  }, options);

  const target = document.querySelector('#analytics');
  observer.observe(target);
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
    <section id="analytics" class="w-full h-fit px-1 my-8">
        <div class="wrapper w-full flex flex-wrap items-center justify-center gap-[10px]">
          <div class="container w-[170px] sm:w-[185px] lg:w-[190px] w-[185px] lg:h-[190px]
            flex flex-col justify-around items-center py-[1em] px-0 text-[16px] rounded-[0.5em]
              bg-[#21242b] border-b-[10px] border-solid border-[#fc036b]">
            <i class="fas fa-glasses text-[#fc036b] text-[2.5em]"></i>
            <span class="num text-[#fff] grid place-items-center font-semibold text-[3em]" :data-val="predictionsCount">0</span>
            <span class="text text-[#e0e0e0] py-[0.7em] px-0 font-normal leading-[0]">Predictions</span>
          </div>
          <div class="container w-[170px] sm:w-[185px] lg:w-[190px] w-[185px] lg:h-[190px]
            flex flex-col justify-around items-center py-[1em] px-0 text-[16px] rounded-[0.5em]
              bg-[#21242b] border-b-[10px] border-solid border-[#fc036b]">
            <i class="fas fa-users text-[#fc036b] text-[2.5em]"></i>
            <span class="num text-[#fff] grid place-items-center font-semibold text-[3em]" :data-val="usersCount">0</span>
            <span class="text text-[#e0e0e0] py-[0.7em] px-0 font-normal leading-[0]">Subscribed Users</span>
          </div>
          <div class="container w-[170px] sm:w-[185px] lg:w-[190px] w-[185px] lg:h-[190px]
            flex flex-col justify-around items-center py-[1em] px-0 text-[16px] rounded-[0.5em]
              bg-[#21242b] border-b-[10px] border-solid border-[#fc036b]">
            <i class="fas fa-users-cog text-[#fc036b] text-[2.5em]"></i>
            <span class="num text-[#fff] grid place-items-center font-semibold text-[3em]" :data-val="usersCount">0</span>
            <span class="text text-[#e0e0e0] py-[0.7em] px-0 font-normal leading-[0]">Premium Users</span>
          </div>
          <div class="container w-[170px] sm:w-[185px] lg:w-[190px] w-[185px] lg:h-[190px]
            flex flex-col justify-around items-center py-[1em] px-0 text-[16px] rounded-[0.5em]
              bg-[#21242b] border-b-[10px] border-solid border-[#fc036b]">
            <i class="fas fa-star text-[#fc036b] text-[2.5em]"></i>
            <span class="num text-[#fff] grid place-items-center font-semibold text-[3em]" :data-val="usersCount">0</span>
            <span class="text text-[#e0e0e0] py-[0.7em] px-0 font-normal leading-[0]">Five Stars</span>
          </div>
        </div>
    </section>
</template>

<style>

</style>