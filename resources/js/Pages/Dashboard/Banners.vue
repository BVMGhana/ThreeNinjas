<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import axios from '../../axiosConfig';

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

const bannerForm = useForm({
    name: '',
    position: '',
    file: '',
    url: ''
});

const { url } = usePage();
const stateUrl = ref(null);
stateUrl.value = url;
const editDataId = ref(null);

const fileInput = ref(null);
const submitData = async () => {
    if (stateUrl.value.includes("banners")) {
        const form = bannerForm.data();
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
                    bannerForm.reset();
                } else {
                    displayMessage(response.data.message, 'warning');
                }
            }
        } catch (error) {
            displayMessage(error.response.statusText, 'error');
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
        bannerForm.name = data.name;
        bannerForm.position = data.position;
        bannerForm.url = data.url;
        bannerForm.file = data.filename;
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
            bannerForm.reset();
        }
    }
};

const setBannerName = event => {
    if (event.target.value === 'top') {
        bannerForm.name = 'Top Banner';
    } else if (event.target.value === 'bottom') {
        bannerForm.name = 'Bottom Banner';
    }
};

const attachFile = event => {
    bannerForm.file = event.target.files[0];
}
</script>

<template>
    <section class="mainSection">
        <main class="prediction-main">
            
            <div class="add-record">
                <h1 v-if="!stateUrl.includes('edit=true')" class="heading text-center text-[13px] md:text-[16px]">Add Banner</h1>
                <h1 v-if="stateUrl.includes('edit=true')" class="heading text-center text-[13px] md:text-[16px]">Update Banner</h1>
                <form action="" @submit.prevent="submitData">
                    <label class="heading-2" for="name">Name</label>
                    <input type="text" id="name" v-model="bannerForm.name" name="name" placeholder="Name" disabled>
                    <InputError :message="bannerForm.errors.name" />

                    <label class="heading-2" for="position">Position</label>
                    <select id="position" name="position" @change="setBannerName" v-model="bannerForm.position">
                        <option value="">Select Position</option>
                        <option value="top">Top</option>
                        <option value="bottom">Bottom</option>
                    </select>
                    <InputError :message="bannerForm.errors.position" />

                    <label class="heading-2 block" for="banner">Banner</label>
                    <input type="file" ref="fileInput" id="banner" @change="attachFile" name="banner" placeholder="Banner">
                    <InputError :message="bannerForm.errors.file" />

                    <label class="heading-2 block" for="url">Link</label>
                    <input type="text" id="url" v-model="bannerForm.url" name="url" placeholder="Link">
                    <InputError :message="bannerForm.errors.url" />

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
                            <th>Image</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in banners" :key="item.id" class="text-left text-[13px] md:text-[16px]">
                            <td>{{ index + 1 }}</td>
                            <td>{{ item.name }}</td>
                            <td>{{ item.position }}</td>
                            <td>{{ item.filename }}</td>
                            <!-- <td><span class="material-icons-sharp text-[14px] text-[green]" @click="editData(item.id)">edit</span></td> -->
                            <td><span class="material-icons-sharp text-[14px] text-[red]" @click="deletePrediction(item.id)">delete</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </section>
</template>