<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import axios from '../../axiosConfig';

const displayMessage = (message, type) => toast(message, { autoClose: 1000, type});

const leagues = ref(null);

const loadInitialData = async () => {
  try {
    const response = await axios.get('leagues');
    leagues.value = response.data;

  } catch (error) {
    displayMessage(error.response.statusText, 'error');
  }
}

loadInitialData();

const otherForm = useForm({
    title: ''
});

const { url } = usePage();
const stateUrl = ref(null);
stateUrl.value = url;
const editDataId = ref(null);

const submitData = async () => {
    if (stateUrl.value.includes("leagues")) {
        try {
            if (stateUrl.value.includes('edit=true') && editDataId) {
                const response = await axios.put(`leagues/${editDataId.value}`, otherForm.data());
                if (response.status === 201) {
                    displayMessage(response.data.message, 'success');
                    const result = await axios.get('leagues');
                    leagues.value = result.data;
                }
            } else {
                const response = await axios.post('leagues', otherForm.data());
                if (response.status === 201) {
                    displayMessage(response.data.message, 'success');
                    const result = await axios.get('leagues');
                    leagues.value = result.data;
                    otherForm.reset();
                }
            }
        } catch (error) {
            displayMessage(error.response.statusText, 'error');
        }
    }
};

const deletePrediction = async id => {
    if (stateUrl.value.includes("leagues")) {
        try {
            const response = await axios.delete(`leagues/${id}`);
            if (response.data.success) {
                displayMessage(response.data.message, 'success');
                const result = await axios.get('leagues');
                leagues.value = result.data;
            }
        } catch (error) {
            displayMessage(error.response.statusText, 'error');
        }
    }
};
    
const editData = async id => {
    if (!stateUrl.value.includes('edit=true')) {
        const newUrl = `${url}?edit=true`;
        stateUrl.value = newUrl;
        window.history.pushState({ path: newUrl }, '', newUrl);
    }
    editDataId.value = id;

    let data;
    if (stateUrl.value.includes('leagues')) {
        const response = await axios.get(`leagues/${id}`);
        data = response.data;
    }
    
    if (stateUrl.value.includes('leagues') || stateUrl.value.includes('fixtures') || stateUrl.value.includes('tips')) {
        otherForm.title = data.title;
    }
};

const addNewRecord = () => {
    if (stateUrl.value.includes('leagues') || stateUrl.value.includes('fixtures') || stateUrl.value.includes('tips')) {
        otherForm.reset();
    }
};

</script>

<template>
    <section class="mainSection">
        <main class="prediction-main">
            
            <div class="add-record">
                <h1 v-if="!stateUrl.includes('edit=true')" class="heading text-center text-[13px] md:text-[16px]">Add League</h1>
                <h1 v-if="stateUrl.includes('edit=true')" class="heading text-center text-[13px] md:text-[16px]">Update League</h1>
                <form action="" @submit.prevent="submitData">
                    <label class="heading-2" for="league">League</label>
                    <input type="text" id="league" v-model="otherForm.title" name="league" placeholder="League">
                
                    <div class="form-buttons">
                        <button v-if="!stateUrl.includes('edit=true')" type="reset">Clear</button>
                        <button v-if="stateUrl.includes('edit=true')" type="button" @click="addNewRecord">Add New</button>

                        <button v-if="!stateUrl.includes('edit=true')" type="submit">Submit</button>
                        <button v-if="stateUrl.includes('edit=true')" type="submit">Update</button>
                    </div>
                </form>
            </div>

            <div>
                <h1 class="heading text-center">Available Leagues</h1>
                <table class="predictions">
                    <thead>
                        <tr class="text-left text-[13px] md:text-[16px]">
                            <th>#</th>
                            <th>League Title</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in leagues" :key="item.id" class="text-left text-[13px] md:text-[16px]">
                            <td>{{ index + 1 }}</td>
                            <td>{{ item.title }}</td>
                            <td><span class="material-icons-sharp text-[14px] text-[green]" @click="editData(item.id)">edit</span></td>
                            <td><span class="material-icons-sharp text-[14px] text-[red]" @click="deletePrediction(item.id)">delete</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </section>
</template>