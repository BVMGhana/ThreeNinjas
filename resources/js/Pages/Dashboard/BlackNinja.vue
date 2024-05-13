<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import axios from '../../axiosConfig';

const displayMessage = (message, type) => toast(message, { autoClose: 1000, type});

const blackNinjas = ref(null);

const loadInitialData = async () => {
  try {
    const response = await axios.get('black-ninjas');
    blackNinjas.value = response.data;

  } catch (error) {
    displayMessage(error.response.statusText, 'error');
  }
}

loadInitialData();

const form = useForm({
    league_id: '',
    fixtures: '',
    tip_id: '',
    results: 0
});

const { url } = usePage();
const stateUrl = ref(null);
stateUrl.value = url;
const editDataId = ref(null);

const submitPrediction = async () => {
    if (stateUrl.value.includes("black-ninja")) {
        try {
            if (stateUrl.value.includes('edit=true') && editDataId) {
                const response = await axios.put(`black-ninjas/${editDataId.value}`, form.data());
                if (response.status === 201) {
                    displayMessage(response.data.message, 'success');
                    const result = await axios.get('black-ninjas');
                    blackNinjas.value = result.data;
                }
            } else {
                const response = await axios.post('black-ninjas', form.data());
                if (response.status === 201) {
                    displayMessage(response.data.message, 'success');
                    const result = await axios.get('black-ninjas');
                    blackNinjas.value = result.data;
                    form.reset();
                }
            }
        } catch (error) {
            displayMessage(error.response.statusText, 'error');
        }
    }
};

const deletePrediction = async id => {
    if (stateUrl.value.includes("black-ninja")) {
        const response = await axios.delete(`black-ninjas/${id}`);
        if (response.data.success) {
            displayMessage(response.data.message, 'success');
            const result = await axios.get('black-ninjas');
            blackNinjas.value = result.data;
        } else {
            displayMessage(response.data.message, 'error');
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
    if (stateUrl.value.includes('black-ninja')) {
        const response = await axios.get(`black-ninjas/${id}`);
        data = response.data;
    }

    if (stateUrl.value.includes('white-ninja') || stateUrl.value.includes('red-ninja') || 
    stateUrl.value.includes('black-ninja')) {
        form.league_id = data.league_id;
        form.fixtures = data.fixtures;
        form.tip_id = data.tip_id;
        form.results = data.results === true ? 1 : 0;
    }
};

const addNewRecord = () => {
    if (stateUrl.value.includes('edit=true')) {
        let newUrl = stateUrl.value;
        newUrl = newUrl.replace("?edit=true", '');
        stateUrl.value = newUrl;
        window.history.pushState({ path: newUrl }, '', newUrl);
        editDataId.value = null;

        if (stateUrl.value.includes('white-ninja') || stateUrl.value.includes('red-ninja') || 
        stateUrl.value.includes('black-ninja')) {
            form.reset();
        }
    }
};

</script>

<template>
    <section class="mainSection">
        <main class="prediction-main">
            
            <div class="add-record">
                <h1 v-if="!stateUrl.includes('edit=true')" class="heading text-center text-[13px] md:text-[16px]">Add Prediction</h1>
                <h1 v-if="stateUrl.includes('edit=true')" class="heading text-center text-[13px] md:text-[16px]">Update Prediction</h1>
                <form action="" @submit.prevent="submitPrediction">
                    <label class="heading-2" for="league">League</label>
                    <select id="league" name="league" v-model="form.league_id">
                        <option value="">Select League</option>
                        <option v-for="league in leagues" :key="league.id" :value="league.id">{{league.title}}</option>
                    </select>

                    <label class="heading-2" for="fixtures">Fixtures</label>
                    <input type="text" id="fixtures" v-model="form.fixtures" name="fixtures" placeholder="Fixtures">

                    <select id="league" name="tips" v-model="form.tip_id">
                        <option value="">Select Tip</option>
                        <option v-for="tip in tips" :key="tip.id" :value="tip.id">{{tip.title}}</option>
                    </select>

                    <!-- <label class="heading-2" for="result">Results</label>
                    <select id="result" name="country" v-model="form.results">
                        <option value="">Select Result</option>
                        <option value="1">Success</option>
                        <option value="0">Failure</option>
                    </select> -->
                
                    <div class="form-buttons">
                        <button v-if="!stateUrl.includes('edit=true')" type="reset">Clear</button>
                        <button v-if="stateUrl.includes('edit=true')" type="button" @click="addNewRecord">Add New</button>

                        <button v-if="!stateUrl.includes('edit=true')" type="submit">Submit</button>
                        <button v-if="stateUrl.includes('edit=true')" type="submit">Update</button>
                    </div>
                </form>
            </div>

            <div>
                <h1 class="heading text-center">Black Ninja Predictions</h1>
                <table class="predictions">
                    <thead>
                        <tr class="text-left text-[13px] md:text-[16px]">
                            <th>#</th>
                            <th>League</th>
                            <th>Fixtures</th>
                            <th>Tips</th>
                            <!-- <th>Results</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in blackNinjas" :key="item.id" class="text-left text-[13px] md:text-[16px]">
                            <td>{{ index + 1 }}</td>
                            <td>{{ item?.league?.title }}</td>
                            <td>{{ item.fixtures }}</td>
                            <td>{{ item.tip.title }}</td>
                            <!-- <td class="py-3 px-2">
                                <i v-if="item.results===true" class="far fa-check-square" style="color: green;"></i>
                                <i v-if="item.results===false" class="fas fa-times" style="color: red;"></i>
                            </td> -->
                            <td><span class="material-icons-sharp text-[14px] text-[green]" @click="editData(item.id)">edit</span></td>
                            <td><span class="material-icons-sharp text-[14px] text-[red]" @click="deletePrediction(item.id)">delete</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </section>
</template>