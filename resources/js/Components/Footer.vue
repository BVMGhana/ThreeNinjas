<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
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
            <p class="w-fit my-[20px] mx-0 border-b border-[#ccc] text-[#fff]">info@3ninjaodds.com</p>
            <!-- <h4 class="text-[#fff]">0241039238</h4> -->
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
</template>

<style scoped>
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
</style>