<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import axios from '../../axiosConfig';

const displayMessage = (message, type) => toast(message, { autoClose: 1000, type});

const users = ref(null);
const usersCount = ref(null);

const loadInitialData = async () => {
  try {
    let response;

    response = await axios.get('users');
    users.value = response.data;

    response = await axios.get('users-count');
    usersCount.value = response.data;

  } catch (error) {
    displayMessage(error.response.statusText, 'error');
  }
}

loadInitialData();

const { url } = usePage();
const stateUrl = ref(null);
stateUrl.value = url;

</script>

<template>
    <section class="mainSection">
        <main class="prediction-main">

            <div>
                <h1 class="heading text-center">Available Users</h1>
                <table class="predictions">
                    <thead>
                        <tr class="text-left text-[13px] md:text-[16px]">
                            <th>#</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Type</th>
                            <th>Date Registered</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(user, index) in users" :key="user.id" class="text-left text-[13px] md:text-[16px]">
                            <td>{{ index + 1 }}</td>
                            <td>{{ user.name }}</td>
                            <td>{{ user.phone }}</td>
                            <td>Premium</td>
                            <td>{{ user.created_at.split("T")[0] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </section>
</template>