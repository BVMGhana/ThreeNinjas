<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import axios from '../../axiosConfig';
import InputError from '@/Components/InputError.vue';

const displayMessage = (message, type) => toast(message, { autoClose: 1000, type});

const banners = ref(null);

const loadInitialData = async () => {
  try {
    const response = await axios.get('banners');
    banners.value = response.data;

  } catch (error) {
    displayMessage(error.response.statusText, 'error');
  }
}

loadInitialData();

const form = useForm({
    name: '',
    position: '',
    file: '',
    url: ''
});

const { url } = usePage();
const stateUrl = ref(null);
stateUrl.value = url;
const editDataId = ref(null);
const errors = ref(null);

const fileInput = ref(null);
const submitData = async () => {
    if (stateUrl.value.includes("banners")) {
        const formData = new FormData();
        formData.append('name', form.name);
        formData.append('position', form.position);
        formData.append('file', form.file);
        formData.append('url', form.url);
        
        try {
            if (stateUrl.value.includes('edit=true') && editDataId) {
                const response = await axios.put(`banners/${editDataId.value}`, formData);
                if (response.status === 201) {
                    displayMessage(response.data.message, 'success');
                    const result = await axios.get('banners');
                    banners.value = result.data;
                }
            } else {
                const response = await axios.post('banners', formData);
                if (response.status === 201) {
                    displayMessage(response.data.message, 'success');
                    const result = await axios.get('banners');
                    banners.value = result.data;
                    fileInput.value.value = '';
                    form.reset();
                } else {
                    displayMessage(response.data.message, 'warning');
                }
            }
        } catch (error) {
            errors.value = error.response.data.errors;
            displayMessage(error.response.data.message, 'error');
        }
    }
};

const deletePrediction = async id => {
    if (stateUrl.value.includes("banners")) {
        try {
            const response = await axios.delete(`banners/${id}`);
            if (response.data.success) {
                displayMessage(response.data.message, 'success');
                const result = await axios.get('banners');
                banners.value = result.data;
                form.reset();
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

    if (stateUrl.value.includes('banners')) {
        const response = await axios.get(`banners/${id}`);
        data = response.data;
    }


    if (stateUrl.value.includes('banner')) {
        form.name = data.name;
        form.position = data.position;
        form.url = data.url;
        form.file = data.filename;
    }
};

const addNewRecord = () => {
    if (stateUrl.value.includes('edit=true')) {
        let newUrl = stateUrl.value;
        newUrl = newUrl.replace("?edit=true", '');
        stateUrl.value = newUrl;
        window.history.pushState({ path: newUrl }, '', newUrl);
        editDataId.value = null;

        if (stateUrl.value.includes('banners')) {
            form.reset();
        }
    }
};

const setBannerName = event => {
    if (event.target.value === 'top') {
        form.name = 'Top Banner';
    } else if (event.target.value === 'bottom') {
        form.name = 'Bottom Banner';
    }
};

const attachFile = event => {
    form.file = event.target.files[0];
}
</script>

<template>
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
                <h1 v-if="!stateUrl.includes('edit=true')" class="heading text-center text-[13px] md:text-[16px]">Add Banner</h1>
                <h1 v-if="stateUrl.includes('edit=true')" class="heading text-center text-[13px] md:text-[16px]">Update Banner</h1>
                <form action="" @submit.prevent="submitData">
                    <label class="heading-2" for="name">Name</label>
                    <input type="text" id="name" v-model="form.name" name="name" placeholder="Name" disabled>
                    <InputError v-if="errors && errors.name" class="text-center" :message="errors.name[0]" />

                    <label class="heading-2" for="position">Position</label>
                    <select id="position" name="position" @change="setBannerName" v-model="form.position">
                        <option value="">Select Position</option>
                        <option value="top">Top</option>
                        <option value="bottom">Bottom</option>
                    </select>
                    <InputError v-if="errors && errors.position" class="text-center" :message="errors.position[0]" />

                    <label class="heading-2 block" for="banner">Banner</label>
                    <input type="file" ref="fileInput" id="banner" @change="attachFile" name="banner" placeholder="Banner">
                    <InputError v-if="errors && errors.file" class="text-center" :message="errors.file[0]" />

                    <label class="heading-2 block" for="url">Link</label>
                    <input type="text" id="url" v-model="form.url" name="url" placeholder="Link">
                    <InputError v-if="errors && errors.url" class="text-center" :message="errors.url[0]" />
                    

                    <div class="form-buttons">
                        <button v-if="!stateUrl.includes('edit=true')" type="reset">Clear</button>
                        <button v-if="stateUrl.includes('edit=true')" type="button" @click="addNewRecord">Add New</button>

                        <button v-if="!stateUrl.includes('edit=true')" type="submit">Submit</button>
                        <button v-if="stateUrl.includes('edit=true')" type="submit">Update</button>
                    </div>
                </form>
            </div>

            <div>
                <h1 class="heading text-center">Available Banners</h1>
                <table class="predictions">
                    <thead>
                        <tr class="text-left text-[13px] md:text-[16px]">
                            <th>#</th>
                            <th>Name</th>
                            <th>Position</th>
                            <th class="hidden lg:inline-block">Image</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in banners" :key="item.id" class="text-left text-[13px] md:text-[16px]">
                            <td>{{ index + 1 }}</td>
                            <td>{{ item.name }}</td>
                            <td>{{ item.position }}</td>
                            <td class="hidden lg:inline-block">{{ item.filename }}</td>
                            <!-- <td><span class="material-icons-sharp text-[14px] text-[green]" @click="editData(item.id)">edit</span></td> -->
                            <td><span class="material-icons-sharp text-[14px] text-[red]" @click="deletePrediction(item.id)">delete</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </section>
</template>