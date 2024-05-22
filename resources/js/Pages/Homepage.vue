<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted, reactive } from 'vue';
import axios from '../axiosConfig';

const menuBtn = ref();
const navLinks = ref();

const whiteNinja = ref(null);
const blackNinja = ref(null);
const redNinja = ref(null);
const previousResults = ref(null);
const topBanner = ref(null);
const bottomBanner = ref(null);
const buttons = ref(null);
const usersCount = ref(null);
const predictionsCount = ref(null);

onMounted(() => {
  menuBtn.value.addEventListener('click', () => {
    navLinks.value.classList.toggle('mobile-menu');
  });

  let accordionHeaders = document.querySelectorAll("#accordion .item .header");
  accordionHeaders.forEach(header => {
    header.addEventListener('click', event => {
      // accordionHeaders.forEach(header => {
      //   header.closest(".item").classList.remove("accordion-active");
      // });
      event.currentTarget.closest(".item").classList.toggle('accordion-active');
    });
  });

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

  const slides = document.querySelectorAll('#center .images .slide');
  const sliderButtons = document.querySelectorAll('#slider-buttons a');
  let counter = 0;

  setInterval(() => {
    document.querySelector("#center .img1").style.marginLeft = (counter * -20) + '%';
    sliderButtons[counter].classList.add("active-slide");

    const siblings = getSiblings(sliderButtons[counter]);
    siblings.forEach(sibling => sibling.classList.remove("active-slide"));
    counter++;

    if (counter > slides.length - 1) {
      counter = 0;
    }
  }, 3000);

});

const getSiblings = element => {
  const parent = element.parentNode;

  // Filter out the original element from the list of all children
  const siblings = Array.from(parent.children).filter(child => child !== element);

  return siblings;
}

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

const getBanner = (bannersList, position) => bannersList.filter(banner => banner.position === position)[0];

let isOpen = ref(false);
const toggleMenu = () => isOpen.value = !isOpen.value;

const getNinjas = async () => {
  try {
    let response;

    response = await axios.get('users-count');
    usersCount.value = response.data;
    
    response = await axios.get('predictions-count');
    predictionsCount.value = response.data;

    response = await axios.get('banners');
    topBanner.value = getBanner(response.data, 'top');
    bottomBanner.value = getBanner(response.data, 'bottom');

    response = await axios.get('white-ninjas');
    whiteNinja.value = response.data;

    response = await axios.get('black-ninjas');
    blackNinja.value = response.data;

    response = await axios.get('red-ninjas');
    redNinja.value = response.data;

    response = await axios.get('previous-results');
    previousResults.value = response.data;

    response = await axios.get('buttons');
    const buttonsArray = response.data;
    buttonsArray.sort((a, b) => a.priority - b.priority);
    buttons.value = buttonsArray;

  } catch (error) {
    console.error('There was an error fetching the data: ', error);
  }
}

getNinjas();

const sliderImages = ['/images/bg_1.jpg', '/images/bg_2.jpg'];

  const slideImage = event => {
    const targetElement = event.target;
    const btnNumber = event.target.classList.value.split(' ')[0].split('btn')[1];
    const marginValue = ((btnNumber - 1) * -20);

    const siblings = getSiblings(targetElement);
    targetElement.classList.add("active-slide");
    siblings.forEach(sibling => sibling.classList.remove("active-slide"));
    document.querySelector("#center .img1").style.marginLeft = `${marginValue}%`;
  };

</script>

<template>
    <Head title="Homepage" />
    <!-- <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50"> -->
    <div class="h-screen w-screen overflow-x-hidden bg-[#EEF5FF] scroll-smooth fade-in">

      <!-- Navbar Section -->
      <nav class="navbar fixed top-0 left-0 w-full flex justify-between align-center 
        bg-[black] h-[100px] lg:h-fit text-white p-0 m-0 z-50">
        
        <div class="flex items-center justify-between lg:p-[20px] bg-[#000]">
          <Link href="/" class="logo fixed lg:static top-[30px] left-[30px] text-[30px] lg:text-[25px] text-[#fff]">3Ninjas</Link>
          <div id="menuButton" @click="toggleMenu" ref="menuBtn" class="flex items-center fixed lg:static 
            top-[20px] right-[40px] w-[40px] lg:hidden w-[40px] cursor-pointer">
            <span class="material-icons-sharp text-[3.5rem]" 
              v-if="isOpen===false">menu</span>
            <span class="material-icons-sharp text-[3.5rem]" 
              v-if="isOpen===true">close</span>
          </div>
        </div>

        <ul ref="navLinks" class="nav-links list-none flex flex-col lg:flex-row w-screen lg:w-auto 
          justify-center lg:justify-between lg:items-center h-[70vh] lg:h-auto bg-[rgba(0,0,0,0.93)] lg:bg-transparent mt-[-900px] lg:mt-0 
          transition-all duration-500 ease">
          <article class="flex flex-col lg:flex-row items-center lg:justify-between">
            <li v-if="$page.props.auth.user && $page.props.auth.user.name!==''" 
              class="my-[20px] py-[5px] px-[20px] rounded-[5px] bg-[#fc036b] mx-auto lg:my-0 lg:mx-[30px] 
              font-bold text-[15px] cursor-default">
              Welcome, {{ $page.props.auth.user.name.split(" ")[0] }}
            </li>
            <!-- <li class="my-[20px] mx-auto lg:my-0 lg:mx-[30px] active text-[30px] lg:text-[20px]"
              v-if="$page.props.auth && $page.props.auth.user.is_admin"
            >
              <Link href="/">VIP</Link>
            </li> -->
            <li class="my-[20px] mx-auto lg:my-0 lg:mx-[30px] text-[30px] lg:text-[20px]">
              <Link class="text-[#fff]" href="#about">About Us</Link>
            </li>
            <li class="my-[20px] mx-auto lg:my-0 lg:mx-[30px] text-[30px] lg:text-[20px]">
              <Link class="text-[#fff]" href="#contact">Contact Us</Link>
            </li>
            <li class="my-[20px] mx-auto lg:my-0 lg:mx-[30px] text-[30px] lg:text-[20px]"
              v-if="$page.props.auth && $page.props.auth?.user?.is_admin"
            >
              <Link class="text-[#fff]" href="/dashboard">Dashboard</Link>
            </li>
          </article>
          <article class="flex flex-col lg:flex-row">
            <li v-if="$page.props.auth.user && $page.props.auth.user.name!==''" class="my-[20px] mx-auto lg:my-0 lg:mx-[30px] text-[30px] lg:text-[20px]">
              <Link class="text-[#fff]" :href="route('logout')" method="post" as="button">Logout</Link>
            </li>
            <li v-if="!$page.props.auth.user" class="my-[20px] mx-auto lg:my-0 lg:mx-[30px] text-[30px] lg:text-[20px]">
              <Link class="text-[#fff]" :href="route('login')">Login</Link>
            </li>
            <li v-if="!$page.props.auth.user" class="my-[20px] mx-auto lg:my-0 lg:mx-[30px] text-[30px] lg:text-[20px]">
              <Link class="text-[#fff]" :href="route('register')">Sign Up</Link>
            </li>
          </article>
        </ul>
      </nav>

      <!-- Header Section -->
      <!-- <header class="w-[100%] h-screen bg-center bg-cover text-white flex items-center justify-center 
      md:rounded-br-[15%] rounded-br-[10px]">
        <div class="header-content mb-[150px] text-whitesmoke text-center">
          <h1 class="text-[7vmin] mt-[120px] md:mt-[70px]">Welcome to 3Ninjas Hub</h1>
          <div class="line w-[150px] h-[4px] bg-[#fc036b] my-[10px] mx-auto rounded-[5px]"></div>
          <h2 class="text-[4vmin] mt-[50px] mb-[50px]">Get insights for betting.</h2>
          <Link href="/" class="no-underline bg-[#fc036b] rounded-[30px] text-[#FFF] py-[8px] px-[15px]">Learn more</Link>
        </div>
      </header> -->

      <div id="center">
        <div class="images">
          <!-- <div class="slide img1"> -->
          <div v-for="(image, index) in sliderImages" :key="index" :class="`slide ${index=== 0 ? 'img1' : ''}`">
            <div class="bg-image" :style="{ backgroundImage: 'linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url(' + image + ')', backgroundRepeat: 'no-repeat', backgroundPosition: 'center center', backgroundSize: 'cover' }">
              <div class="header-content mb-[150px] text-whitesmoke text-center">
                <h1 class="text-[7vmin] mt-[120px] md:mt-[70px]">Welcome to 3Ninjas Hub</h1>
                <div class="line w-[150px] h-[4px] bg-[#fc036b] my-[10px] mx-auto rounded-[5px]"></div>
                <h2 class="text-[4vmin] mt-[50px] mb-[50px]">Get insights for betting.</h2>
                <Link href="/" class="no-underline bg-[#fc036b] rounded-[30px] text-[#FFF] py-[8px] px-[15px]">Learn more</Link>
              </div>
            </div>
          </div>
        </div>

        <div id="slider-buttons">
          <a href="#" v-for="(btn, index) in sliderImages" :key="index" @click="slideImage($event)" :class="`btn${index+1}`"></a>
        </div>
      </div>

      <!-- Top Banner Section -->
      <section v-if="topBanner?.id" class="w-full my-10 lg:my-15 flex justify-center">
        <a :href="topBanner?.url" target="_blank" class="w-[570px] lg:w-[970px] h-auto lg:h-[250px]">
          <img :src="`/banners/${topBanner?.filename}`" alt="top-banner" class="max-w-full max-h-full">
        </a>
      </section>

      <!-- Title Section -->
      <!-- <section class="w-full lg:w-[60%] flex flex-col items-center px-2"> -->
      <section class="w-full lg:w-full flex flex-col items-center px-2">
        <h2 class="text-black my-3 font-extrabold text-center text-[18px] lg:text-[32px]">FREE PREDICTIONS (LIMITED)</h2>
        <p class="bg-custom-gray my p-3 font-extrabold text-center text-[12px] lg:text-[16px] text-gray-300">NB: These free Predictions are limited. Log In or Sign Up to enjoy more Free slips with higher returns</p>
      </section>

      <!-- Ninjas Section -->
      <!-- <section id="accordion" class="w-screen flex justify-start px-1 my-10 h-auto text-white"> -->
        <!-- <div class="w-full lg:w-[60%] rounded-lg overflow-hidden bg-slate-800 flex flex-col gap-[3px] lg:mx-5"> -->
      <section id="accordion" class="w-screen flex justify-center px-1 my-10 h-auto text-white">
        <div class="w-full lg:w-[80%] rounded-lg overflow-hidden bg-slate-800 flex flex-col gap-[3px] lg:mx-5">
          <div class="item accordion-active">
            <div class="header p-6 bg-slate-900 font-bold flex justify-between item-center cursor-pointer">
              <div>
                <div>PREVIOUS RESULTS</div>
                <div>Prediction Results</div>
              </div>
              <div>
                <i class="fas fa-chevron-up active-icon"></i>
                <i class="fas fa-chevron-down inactive-icon"></i>
              </div>
            </div>
            <div class="content bg-slate-800 w-full transition-all duration-500">
              <div class="mb-2">
                <table class="shadow-2xl border md:border-2 w-full">
                  <thead class="text-black">
                    <tr class="text-left">
                      <th class="py-3 px-2 bg-cyan-200">#</th>
                      <th class="py-3 px-2 bg-cyan-200">League</th>
                      <th class="py-3 px-2 bg-cyan-200">Fixtures</th>
                      <th class="py-3 px-2 bg-cyan-200">Tips</th>
                      <th class="py-3 px-2 bg-cyan-200">Results</th>
                    </tr>
                  </thead>
                  <tbody class="text-gray-300">
                    <tr v-for="(item, index) in previousResults" :key="item.id" class="text-left text-[13px] md:text-[16px]">
                      <td class="py-3 px-2">{{ index + 1 }}</td>
                      <td class="py-3 px-2">{{ item.league.title }}</td>
                      <td class="py-3 px-2">{{item.fixtures}}</td>
                      <td class="py-3 px-2">{{ item.tip.title }}</td>
                      <td class="py-3 px-2">
                        <i v-if="item.results===true" class="far fa-check-square" style="color: green;"></i>
                        <i v-if="item.results===false" class="fas fa-times" style="color: red;"></i>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div class="p-4 w-full flex flex-col items-center gap-10">
                  <div class="flex flex-col lg:flex-row gap-4 flex-wrap justify-center">
                    <a v-for="button in buttons" :key="button.id" :href="button.url" :style="{ backgroundColor: button.background, color: button.foreground }" 
                      :class="`no-underline uppercase rounded-[30px] text-[13px] font-bold py-[3px] px-[45px]`"
                      target="_blank">
                      {{ button.title }}
                    </a>
                  </div>
                  <Link v-if="!$page.props.auth.user" 
                    class="no-underline bg-cyan-200 text-[black] rounded-[5px] text-[13px] font-bold text-whitesmoke 
                    py-[10px] px-[45px]" target="_blank"  href="/login">
                    LOGIN FOR EXTRA VIP FREE SLIPS
                  </Link>
                </div>
              </div>
            </div>
          </div>
          <div class="item accordion-active">
            <div class="header p-6 bg-slate-900 font-bold flex justify-between item-center cursor-pointer">
              <div>
                <div>RED NINJA</div>
                <div>High Risk, Big Reward</div>
              </div>
              <div>
                <i class="fas fa-chevron-up active-icon"></i>
                <i class="fas fa-chevron-down inactive-icon"></i>
              </div>
            </div>
            <div class="content bg-slate-800 w-full transition-all duration-500">
              <div class="mb-2">
                <table class="shadow-2xl border md:border-2 w-full">
                  <thead class="text-black">
                    <tr class="text-left">
                      <th class="py-3 px-2 bg-cyan-200">#</th>
                      <th class="py-3 px-2 bg-cyan-200">League</th>
                      <th class="py-3 px-2 bg-cyan-200">Fixtures</th>
                      <th class="py-3 px-2 bg-cyan-200">Tips</th>
                      <th class="py-3 px-2 bg-cyan-200">Results</th>
                    </tr>
                  </thead>
                  <tbody class="text-gray-300">
                    <tr v-for="(item, index) in redNinja" :key="item.id" class="text-left text-[13px] md:text-[16px]">
                      <td class="py-3 px-2">{{ index + 1 }}</td>
                      <td class="py-3 px-2">{{ item.league.title }}</td>
                      <td class="py-3 px-2">{{item.fixtures}}</td>
                      <td class="py-3 px-2">{{ item.tip.title }}</td>
                      <td class="py-3 px-2">
                        N/A
                        <!-- <i v-if="item.results===true" class="far fa-check-square" style="color: green;"></i>
                        <i v-if="item.results===false" class="fas fa-times" style="color: red;"></i> -->
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div class="p-4 w-full flex flex-col items-center gap-10">
                  <div class="flex flex-col lg:flex-row gap-4 flex-wrap justify-center">
                    <a v-for="button in buttons" :key="button.id" :href="button.url" :style="{ backgroundColor: button.background, color: button.foreground }" 
                      :class="`no-underline uppercase rounded-[30px] text-[13px] font-bold py-[3px] px-[45px]`"
                      target="_blank">
                      {{ button.title }}
                    </a>
                  </div>
                  <Link v-if="!$page.props.auth.user" 
                    class="no-underline bg-cyan-200 text-[black] rounded-[5px] text-[13px] font-bold text-whitesmoke 
                    py-[10px] px-[45px]" target="_blank"  href="/login">
                    LOGIN FOR EXTRA VIP FREE SLIPS
                  </Link>
                </div>
              </div>
            </div>
          </div>
          <div class="item" v-if="$page.props.auth.user && $page.props.auth.user.id">
            <div class="header p-6 bg-slate-900 font-bold flex justify-between item-center cursor-pointer">
              <div>
                <div>BLACK NINJA</div>
                <div>Fair Bet</div>
              </div>
              <div>
                <i class="fas fa-chevron-up active-icon"></i>
                <i class="fas fa-chevron-down inactive-icon"></i>
              </div>
            </div>
            <div class="content bg-slate-800 w-full transition-all duration-500">
              <div class="mb-2">
                <table class="shadow-2xl border md:border-2 w-full">
                  <thead class="text-black">
                    <tr class="text-left">
                      <th class="py-3 px-2 bg-cyan-200">#</th>
                      <th class="py-3 px-2 bg-cyan-200">League</th>
                      <th class="py-3 px-2 bg-cyan-200">Fixtures</th>
                      <th class="py-3 px-2 bg-cyan-200">Tips</th>
                      <th class="py-3 px-2 bg-cyan-200">Results</th>
                    </tr>
                  </thead>
                  <tbody class="text-gray-300">
                    <tr v-for="(item, index) in blackNinja" :key="item.id" class="text-left text-[13px] md:text-[16px]">
                      <td class="py-3 px-2">{{ index + 1 }}</td>
                      <td class="py-3 px-2">{{ item.league.title }}</td>
                      <td class="py-3 px-2">{{ item.fixtures }}</td>
                      <td class="py-3 px-2">{{ item.tip.title }}</td>
                      <td class="py-3 px-2">
                        N/A
                        <!-- <i v-if="item.results===true" class="far fa-check-square" style="color: green;"></i>
                        <i v-if="item.results===false" class="fas fa-times" style="color: red;"></i> -->
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div class="p-4 w-full flex flex-col items-center gap-10">
                  <div class="flex flex-col lg:flex-row gap-4 flex-wrap justify-center">
                    <a v-for="button in buttons" :key="button.id" :href="button.url" :style="{ backgroundColor: button.background, color: button.foreground }" 
                      :class="`no-underline uppercase rounded-[30px] text-[13px] font-bold py-[3px] px-[45px]`"
                      target="_blank">
                      {{ button.title }}
                    </a>
                  </div>
                  <Link v-if="!$page.props.auth.user" 
                    class="no-underline bg-cyan-200 text-[black] rounded-[5px] text-[13px] font-bold text-whitesmoke 
                    py-[10px] px-[45px]" target="_blank"  href="/login">
                    LOGIN FOR EXTRA VIP FREE SLIPS
                  </Link>
                </div>
              </div>
            </div>
          </div>
          <div class="item" v-if="$page.props.auth.user && $page.props.auth.user.id">
            <div class="header p-6 bg-slate-900 font-bold flex justify-between item-center cursor-pointer">
              <div>
                <div>WHITE NINJA</div>
                <div>Assured Bet</div>
              </div>
              <div>
                <i class="fas fa-chevron-up active-icon"></i>
                <i class="fas fa-chevron-down inactive-icon"></i>
              </div>
            </div>
            <div class="content bg-slate-800 w-full transition-all duration-500">
              <div class="mb-2">
                <table class="shadow-2xl border md:border-2 w-full">
                  <thead class="text-black">
                    <tr class="text-left">
                      <th class="py-3 px-2 bg-cyan-200">#</th>
                      <th class="py-3 px-2 bg-cyan-200">League</th>
                      <th class="py-3 px-2 bg-cyan-200">Fixtures</th>
                      <th class="py-3 px-2 bg-cyan-200">Tips</th>
                      <th class="py-3 px-2 bg-cyan-200">Results</th>
                    </tr>
                  </thead>
                  <tbody class="text-gray-300">
                    <tr v-for="(item, index) in whiteNinja" :key="item.id" class="text-left text-[13px] md:text-[16px]">
                      <td class="py-3 px-2">{{ index + 1 }}</td>
                      <td class="py-3 px-2">{{item.league.title}}</td>
                      <td class="py-3 px-2">{{item.fixtures}}</td>
                      <td class="py-3 px-2">{{ item.tip.title }}</td>
                      <td class="py-3 px-2">
                        N/A
                        <!-- <i v-if="item.results===true" class="far fa-check-square" style="color: green;"></i>
                        <i v-if="item.results===false" class="fas fa-times" style="color: red;"></i> -->
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div class="p-4 w-full flex flex-col items-center gap-10">
                  <div class="flex flex-col lg:flex-row gap-4 flex-wrap justify-center">
                    <a v-for="button in buttons" :key="button.id" :href="button.url" :style="{ backgroundColor: button.background, color: button.foreground }" 
                      :class="`no-underline uppercase rounded-[30px] text-[13px] font-bold py-[3px] px-[45px]`"
                      target="_blank">
                      {{ button.title }}
                    </a>
                  </div>
                  <Link v-if="!$page.props.auth.user" 
                    class="no-underline bg-cyan-200 text-[black] rounded-[5px] text-[13px] font-bold text-whitesmoke py-[10px] 
                    px-[45px]" target="_blank"  href="/login">
                    LOGIN FOR EXTRA VIP FREE SLIPS
                  </Link>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Analytics Section -->
      <section id="analytics" class="w-full h-fit px-1 my-8">
        <div class="wrapper w-full flex flex-wrap items-center justify-center gap-[10px]">
          <div class="container w-[185px] lg:w-[190px] w-[185px] lg:h-[190px]
            flex flex-col justify-around items-center py-[1em] px-0 text-[16px] rounded-[0.5em]
              bg-[#21242b] border-b-[10px] border-solid border-[#fc036b]">
            <i class="fas fa-users-cog text-[#fc036b] text-[2.5em]"></i>
            <span class="num text-[#fff] grid place-items-center font-semibold text-[3em]" :data-val="usersCount">0</span>
            <span class="text text-[#e0e0e0] py-[0.7em] px-0 font-normal leading-[0]">Subscribed Clients</span>
          </div>
          <div class="container w-[185px] lg:w-[190px] w-[185px] lg:h-[190px]
            flex flex-col justify-around items-center py-[1em] px-0 text-[16px] rounded-[0.5em]
              bg-[#21242b] border-b-[10px] border-solid border-[#fc036b]">
            <i class="fas fa-glasses text-[#fc036b] text-[2.5em]"></i>
            <span class="num text-[#fff] grid place-items-center font-semibold text-[3em]" :data-val="predictionsCount">0</span>
            <span class="text text-[#e0e0e0] py-[0.7em] px-0 font-normal leading-[0]">Predictions</span>
          </div>
          <div class="container w-[185px] lg:w-[190px] w-[185px] lg:h-[190px]
            flex flex-col justify-around items-center py-[1em] px-0 text-[16px] rounded-[0.5em]
              bg-[#21242b] border-b-[10px] border-solid border-[#fc036b]">
            <i class="fas fa-users text-[#fc036b] text-[2.5em]"></i>
            <span class="num text-[#fff] grid place-items-center font-semibold text-[3em]" :data-val="usersCount">0</span>
            <span class="text text-[#e0e0e0] py-[0.7em] px-0 font-normal leading-[0]">Satisfied Clients</span>
          </div>
          <div class="container w-[185px] lg:w-[190px] w-[185px] lg:h-[190px]
            flex flex-col justify-around items-center py-[1em] px-0 text-[16px] rounded-[0.5em]
              bg-[#21242b] border-b-[10px] border-solid border-[#fc036b]">
            <i class="fas fa-star text-[#fc036b] text-[2.5em]"></i>
            <span class="num text-[#fff] grid place-items-center font-semibold text-[3em]" :data-val="usersCount">0</span>
            <span class="text text-[#e0e0e0] py-[0.7em] px-0 font-normal leading-[0]">Five Stars</span>
          </div>
        </div>
      </section>
      <p class="text-[black]">{{ usersCount }}</p>

      <!-- Bottom Banner Section -->
      <section v-if="bottomBanner?.id" class="w-full my-10 lg:my-15 flex justify-center">
        <a :href="bottomBanner?.url" target="_blank" class="w-[570px] lg:w-[970px] h-auto lg:h-[250px]">
          <img :src="`/banners/${bottomBanner?.filename}`" alt="top-banner" class="max-w-full max-h-full">
        </a>
      </section>
      
      <!-- Footer Section -->
      <footer class="w-screen bottom-[unset] md:bottom-0 bg-gradient-to-r-from-black-to-brown text-white 
        pt-[100px] px-0 pb-[30px] rounded-tl-[125px] text-[13px] leading-[20px]">
        <div class="w-[85%] m-auto flex flex-wrap items-start justify-between">
          <div id="about" class="basis-[100%] md:basis-[25%] mb-[20px] p-[10px]">
            <!-- <img src="/images/logo.jpg" alt="logo" class="w-[80px] mb-[30px]"> -->
            <h1 class="text-[24px] mb-[20px] md:mb-[40px] text-[#fff]">3 Ninjas Co.</h1>
            <p class="text-[#fff]">Subscribe to 3 Ninjas to get exclusive insights for betting. You can choose the VIP package for special offers.</p>
          </div>
          <div id="contact" class="basis-[100%] md:basis-[15%] mb-[20px] p-[10px]">
            <h3 class="w-fit mb-[20px] md:mb-[40px] relative">
              Address <div class="w-full h-[5px] bg-[#767676] rounded-[3px] absolute left-0 overflow-hidden">
                <span class="w-[15px] h-[100%] bg-white rounded-[3px] absolute top-0 left-[10px] moving"></span></div>
            </h3>
            <p class="text-[#fff]">3 Ninjas Co.</p>
            <p class="text-[#fff]">Suite No. 2007</p>
            <p class="text-[#fff]">Osu-Oxford Street</p>
            <p class="text-[#fff]">Accra- Ghana </p>
            <p class="w-fit my-[20px] mx-0 border-b border-[#ccc] text-[#fff]">threeninjas@gmail.com</p>
            <h4 class="text-[#fff]">0241039238</h4>
          </div>
          <div class="basis-[100%] md:basis-[15%] mb-[20px] p-[10px]">
            <h3 class="w-fit mb-[20px] md:mb-[40px] relative">
              Links <div class="w-full h-[5px] bg-[#767676] rounded-[3px] absolute left-0 overflow-hidden">
                <span class="w-[15px] h-[100%] bg-white rounded-[3px] absolute top-0 left-[10px] moving"></span></div>
            </h3>
            <ul>
              <li class="list-none mb-[12px]"><Link href="/" class="no-underline text-[#fff]">Home</Link></li>
              <li class="list-none mb-[12px]"><Link href="#about" class="no-underline text-[#fff]">About Us</Link></li>
              <li class="list-none mb-[12px]"><Link href="#contact" class="no-underline text-[#fff]">Contact Us</Link></li>
            </ul>
          </div>
          <div class="basis-[100%] md:basis-[25%] mb-[20px] p-[10px]">
            <h3 class="w-fit mb-[20px] md:mb-[40px] relative">
              Newsletter <div class="w-full h-[5px] bg-[#767676] rounded-[3px] absolute left-0 overflow-hidden">
                <span class="w-[15px] h-[100%] bg-white rounded-[3px] absolute top-0 left-[10px] moving"></span></div>
            </h3>
            <form action="" @submit.prevent="" class="pb-[15px] flex items-center justify-between border-b border-[#ccc] mb-[50px]">
              <i class="far fa-envelope text-[18px] mr-[10px]"></i>
              <input type="email" placeholder="Enter your email" class="w-full bg-transparent text-[#ccc] border-0 outline-none mx-2" required>
              <button type="submit" class="bg-transparent border-0 outline-none cursor-pointer"><i class="fas fa-arrow-right"></i></button>
            </form>
            <div>
              <Link href="" class="w-[20px] h-[20px] rounded-[5px] text-center p-[5px] text-[20px] text-[blue] bg-white mx-[8px] cursor-pointer"><i class="fab fa-facebook"></i></Link>
              <Link href="" class="w-[20px] h-[20px] rounded-[5px] text-center p-[5px] text-[20px] text-black bg-white mx-[8px] cursor-pointer"><i class="fa-brands fa-x-twitter"></i></Link>
              <Link href="" class="w-[20px] h-[20px] rounded-[5px] text-center p-[5px] text-[20px] text-[green] bg-white mx-[8px] cursor-pointer"><i class="fab fa-whatsapp"></i></Link>
              <Link href="" class="w-[20px] h-[20px] rounded-[5px] text-center p-[5px] text-[20px] text-[pink] bg-white mx-[8px] cursor-pointer"><i class="fab fa-pinterest"></i></Link>
            </div>
          </div>
        </div>
        <hr class="w-[90%] border-0 border-b-2 border-solid border-[#ccc] my-[20px] mx-auto">
        <p class="text-center text-[#fff]">3 Ninjas Co. &copy; 2024 - All Rights Reserved</p>
      </footer>
    </div>
</template>

<style scoped>

#center {
  height: 100%;
  width: 100%;
  margin-top: 77px;
  position: relative;
  box-shadow: 0px 5px 8px rgba(0,0,0,.3);
  overflow: hidden;
}

#center .images {
  height: 100%;
  width: 500%;
  display: flex;
}

#center .images .slide {
  width: 20%;
  transition: 1s;
}

#center .images div.bg-image {
  height: 100%;
  width: 100%;
  color: whitesmoke;
  display: flex;
  align-items: center;
  justify-content: center;
}

a.active-slide {
  transition: .5s;
  transform: scale(0.999);
  background: white;
  animation: animate .4s;
}

#slider-buttons {
  position: absolute;
  bottom: 20px;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
}

#slider-buttons a {
  height: 8px;
  width: 30px;
  border: 2px solid white;
  margin: 0 5px;
  border-radius: 10px;
}

@keyframes animate {
  100% {
    transform: scale(0.8);
  }
}

#slider {
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
}

header {
  background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url(/images/bg.jpg) no-repeat scroll center center /cover; 
}

.fade-in {
  animation: fadeIn 0.2s ease-in-out;
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

.active {
  color: #fc036b;
  text-decoration: underline;
  font-weight: bold;
  text-underline-offset: 10px;
}

.mobile-menu {
  margin-top: 0;
  border-bottom-right-radius: 30%;
}

@keyframes moving {
  0% {
    left: -20px;
  }
  100% {
    left: 100%;
  }
}

.moving {
  animation: moving 2s linear infinite;
}

.item .active-icon {
  display: none;
  /* @apply hidden; */
}

.item.accordion-active .inactive-icon {
  display: none;
}

.item.accordion-active .active-icon {
  display: block;
  /* @apply: visible; */
}

.item:not(.accordion-active) .content {
  @apply h-0 overflow-hidden py-0;
}

.item .content {
  @apply p-2 h-full
}

</style>