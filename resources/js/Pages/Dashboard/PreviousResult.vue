<script setup>
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import axios from '../../axiosConfig';
import InputError from '@/Components/InputError.vue';

const displayMessage = (message, type) => toast(message, { autoClose: 1000, type});

const previousResults = ref(null);
const leagues = ref(null);
const tips = ref(null);

const loadInitialData = async () => {
  try {
    let response;
    response = await axios.get('previous-results');
    previousResults.value = response.data;

    response = await axios.get('leagues');
    leagues.value = response.data;

    response = await axios.get('tips');
    tips.value = response.data;

  } catch (error) {
    displayMessage(error.response.statusText, 'error');
  }
}

loadInitialData();

const form = useForm({
    league_id: '',
    fixtures: '',
    tip_id: '',
    results: ''
});

const { url } = usePage();
const stateUrl = ref(null);
stateUrl.value = url;
const editDataId = ref(null);
const errors = ref(null);

const submitPrediction = async () => {
    if (stateUrl.value.includes("previous-results")) {
        try {
            if (stateUrl.value.includes('edit=true') && editDataId) {
                const response = await axios.put(`previous-results/${editDataId.value}`, form);
                if (response.status === 201) {
                    displayMessage(response.data.message, 'success');
                    const result = await axios.get('previous-results');
                    previousResults.value = result.data;
                }
            } else {
                const response = await axios.post('previous-results', form);
                if (response.status === 201) {
                    displayMessage(response.data.message, 'success');
                    const result = await axios.get('previous-results');
                    previousResults.value = result.data;
                    form.reset();
                }
            }
        } catch (error) {
            errors.value = error.response.data.errors;
            displayMessage(error.response.data.message, 'error');
        }
    }
};

const deletePrediction = async id => {
    if (stateUrl.value.includes("previous-results")) {
        const response = await axios.delete(`previous-results/${id}`);
        if (response.data.success) {
            displayMessage(response.data.message, 'success');
            const result = await axios.get('previous-results');
            previousResults.value = result.data;
            addNewRecord();
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
    if (stateUrl.value.includes('previous-results')) {
        const response = await axios.get(`previous-results/${id}`);
        data = response.data;
    }

    if (stateUrl.value.includes('previous-results')) {
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

        if (stateUrl.value.includes('previous-results')) {
            form.reset();
        }
    }
};

</script>

<template>
    <Head title="Previous Results" />

    <section class="mainSection">
        <main class="prediction-main">
            <div class="right">
                <div class="top">
                    <button id="menu-btn" class="hidden">
                        <span class="material-icons-sharp">menu</span>
                    </button>
                    <div class="theme-toggler">
                        <span class="material-icons-sharp active">light_mode</span>
                        <span class="material-icons-sharp">dark_mode</span>
                    </div>
                </div>
            </div>
            <div class="add-record">
                <h1 v-if="!stateUrl.includes('edit=true')" class="heading text-center text-[13px] md:text-[16px]">Add Prediction Result</h1>
                <h1 v-if="stateUrl.includes('edit=true')" class="heading text-center text-[13px] md:text-[16px]">Update Prediction Result</h1>
                <form action="" @submit.prevent="submitPrediction">
                    <label class="heading-2" for="league">League</label>
                    <select id="league" name="league" v-model="form.league_id">
                        <option value="">Select League</option>
                        <option v-for="league in leagues" :key="league.id" :value="league.id">{{league.title}}</option>
                    </select>
                    <InputError v-if="errors && errors.league_id" class="text-center" :message="errors.league_id[0]" />

                    <label class="heading-2" for="fixtures">Fixtures</label>
                    <input type="text" id="fixtures" v-model="form.fixtures" name="fixtures" placeholder="Fixtures">
                    <InputError v-if="errors && errors.fixtures" class="text-center" :message="errors.fixtures[0]" />

                    <label class="heading-2" for="tips">Tip</label>
                    <select id="tips" name="tips" v-model="form.tip_id">
                        <option value="">Select Tip</option>
                        <option v-for="tip in tips" :key="tip.id" :value="tip.id">{{tip.title}}</option>
                    </select>
                    <InputError v-if="errors && errors.tip_id" class="text-center" :message="errors.tip_id[0]" />

                    <label class="heading-2" for="result">Results</label>
                    <select id="result" name="country" v-model="form.results">
                        <option value="">Select Result</option>
                        <option value="1">Success</option>
                        <option value="0">Failure</option>
                    </select>
                    <InputError v-if="errors && errors.results" class="text-center" :message="errors.results[0]" />
                
                    <div class="form-buttons">
                        <button v-if="!stateUrl.includes('edit=true')" type="reset">Clear</button>
                        <button v-if="stateUrl.includes('edit=true')" type="button" @click="addNewRecord">Add New</button>

                        <button v-if="!stateUrl.includes('edit=true')" type="submit">Submit</button>
                        <button v-if="stateUrl.includes('edit=true')" type="submit">Update</button>
                    </div>
                </form>
            </div>

            <div>
                <h1 class="heading text-center">Previous Results</h1>
                <table class="predictions">
                    <thead>
                        <tr class="text-left text-[13px] md:text-[16px]">
                            <th>#</th>
                            <th>League</th>
                            <th>Fixtures</th>
                            <th>Tips</th>
                            <th>Results</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in previousResults" :key="item.id" class="text-left text-[13px] md:text-[16px]">
                            <td>{{ index + 1 }}</td>
                            <td>{{ item?.league?.title }}</td>
                            <td>{{ item.fixtures }}</td>
                            <td>{{ item.tip.title }}</td>
                            <td class="py-3 px-2 text-center">
                                <i v-if="item.results===true" class="far fa-check-square" style="color: green;"></i>
                                <i v-if="item.results===false" class="fas fa-times" style="color: red;"></i>
                            </td>
                            <td><span class="material-icons-sharp text-[14px] text-[green]" @click="editData(item.id)">edit</span></td>
                            <td><span class="material-icons-sharp text-[14px] text-[red]" @click="deletePrediction(item.id)">delete</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </section>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

.fade-in {
  animation: fadeIn 0.6s ease-in-out;
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

input[type=text],
select {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

.form-buttons {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.form-buttons button {
    width: 100%;
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.form-buttons button[type=reset],
button[type=button] {
    background-color: salmon;
    width: 20%;
}

.form-buttons button[type=submit] {
    background-color: green;
    width: 70%;
}

input[type=submit]:hover {
    background-color: #45a049;
}

div.add-record {
    width: 70%;
    margin: auto;
    background: var(--color-white);
    border-radius: var(--card-border-radius);
    padding: 20px;
    margin-top: 40px;
    margin-bottom: 50px;
}

@media screen and (max-width: 768px) {
    div.add-record {
        width: 100%;
        /* margin: auto; */
        margin: 50px auto 60px;
    }
}

.heading-2 {
    color: var(--color-dark-variant);
}

div.add-record:hover {
    box-shadow: none;
}


.mainSection main table {
    background: var(--color-white);
    width: 100%;
    border-radius: var(--card-border-radius);
    /* padding: var(--card-padding); */
    /* why*/
    text-align: center;
    box-shadow: var(--box-shadow);
    transition: all 300ms ease;
}

.mainSection main table:hover {
    box-shadow: none;
}

.mainSection main table tbody td span {
    cursor: pointer;
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

.profile-photo {
    width: 2.8rem;
    height: 2.8rem;
    border-radius: 50%;
    overflow: hidden;
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

#mainSection {
    display: grid;
    grid-template-columns: auto 23rem;
    gap: 1.8rem;
    width: 100%;
}

.mainSection {
    display: grid;
    grid-template-columns: auto;
    gap: 1.8rem;
    width: 100%;
}

/* main */

main.prediction-main {
    width: 100%;
    margin-top: 10px;
}

main {
    margin-top: 1.4rem;
}

main table thead th {
    padding: var(--card-padding) var(--padding-small);
    color: var(--color-dark);
}

main table tbody td {
    height: 2.8rem;
    border-bottom: 1px solid var(--color-light);
    color: var(--color-dark-variant);
    padding: var(--padding-small);
    /* Why*/
}

main table tbody tr:last-child td {
    border: none;
}

main.prediction-main table tbody tr td:first-child,
main.prediction-main table thead tr th:first-child {
    padding-left: var(--padding-1)
}

@media screen and (max-width: 768px) {
    main table thead th {
        padding: var(--card-padding) var(--padding-semi-small);
    }

    main table tbody td {
        padding: var(--padding-small) var(--padding-semi-small);
        /* Why*/
    }
}

/* End of main */

.right {
    margin-top: 1.4rem;
}

.right .top {
    display: flex;
    justify-content: end;
    gap: 2rem;
}

.right .top button {
    display: none;
}

.right .theme-toggler {
    background: var(--color-light);
    display: flex;
    justify-content: space-between;
    align-items: center;
    height: 1.6rem;
    width: 4.2rem;
    cursor: pointer;
    border-radius: var(--border-radius-1);
}

.right .theme-toggler span {
    font-size: 1.2rem;
    width: 50%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--color-dark);
}

.right .theme-toggler span.active {
    background: var(--color-primary);
    color: var(--color-white);
    border-radius: var(--border-radius-1);
}

/* End of right top */

@media screen and (max-width: 1200px) {
    .container {
        grid-template-columns: 7rem auto 23rem;
    }

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

    main .insights {
        grid-template-columns: 1fr;
        gap: 0;
    }

    main .recent-subscriptions {
        width: 94%;
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        margin: 2rem 0 0 8.8rem;
    }

    main .recent-subscriptions table {
        width: 83vw;
    }

    main table#dashboard-table thead tr th:last-child,
    main table#dashboard-table thead tr th:first-child,
    main table#dashboard-table tbody tr td:last-child,
    main table#dashboard-table tbody tr td:first-child {
        display: none;
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

    main {
        width: 100%;
        margin-top: 8rem;
        padding: 0 1rem;
    }

    main.prediction-main {
        width: 100%;
        margin-top: 30px;
    }

    main .recent-subscriptions {
        position: relative;
        margin: 3rem 0 0 0;
        width: 100%;
    }

    main .recent-subscriptions table {
        width: 100%;
        margin: 0;
    }

    .right {
        width: 94%;
        margin: 0 auto 4rem;
        position: fixed;
        top: 0;
        left: 0;
        height: 3.5rem;
        z-index: 2;
        box-shadow: 0 1rem 1rem var(--color-light);
        background: var(--color-white);
    }

    main.prediction-main .right {
        width: 100%;
        margin: 0 auto 2rem;
        padding: 0;
    }

    .right .top {
        position: fixed;
        top: 0;
        left: 0;
        align-items: center;
        padding: 0 0.8rem;
        background: var(--color-white);
        width: 100%;
        margin: 0;
        z-index: 2;
        box-shadow: 0 1rem 1rem var(--color-light);
    }

    main.prediction-main .right .top {
        margin: 30px;
        padding: 0;
        /* box-shadow: 0 1rem 1rem var(--color-light); */
    }

    .right .top .theme-toggler {
        width: 4.4rem;
        position: absolute;
        left: 66%;
    }

    .right .profile .info {
        display: none;
    }

    .right .top button {
        display: inline-block;
        background: transparent;
        cursor: pointer;
        color: var(--color-dark);
        position: absolute;
        left: 1rem;
    }

    .right .top button span {
        font-size: 2rem;
    }
}

/* main .recent-subscriptions table {
    padding: 1.8rem;
} */</style>