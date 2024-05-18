<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { onMounted, watch, ref } from 'vue';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import { ColorPicker } from "vue3-colorpicker";
import "vue3-colorpicker/style.css";
import axios from '../../axiosConfig';
import InputError from '@/Components/InputError.vue';

const displayMessage = (message, type) => toast(message, { autoClose: 1000, type});

const buttons = ref(null);

const loadInitialData = async () => {
  try {
    const response = await axios.get('buttons');
    buttons.value = response.data;

  } catch (error) {
    displayMessage(error.response.statusText, 'error');
  }
}

loadInitialData();

const form = useForm({
    title: '',
    url: '',
    background: '#2097f3',
    foreground: '#0d0d0d',
    priority: ''
});

const { url } = usePage();
const stateUrl = ref(null);
stateUrl.value = url;
const editDataId = ref(null);
const errors = ref(null);

const submitData = async () => {
    if (stateUrl.value.includes("buttons")) {
        
        try {
            if (stateUrl.value.includes('edit=true') && editDataId) {
                const response = await axios.put(`buttons/${editDataId.value}`, form);
                if (response.status === 201) {
                    displayMessage(response.data.message, 'success');
                    const result = await axios.get('buttons');
                    buttons.value = result.data;
                }
            } else {
                const response = await axios.post('buttons', form);
                if (response.status === 201) {
                    displayMessage(response.data.message, 'success');
                    const result = await axios.get('buttons');
                    buttons.value = result.data;
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
    if (stateUrl.value.includes("buttons")) {
        try {
            const response = await axios.delete(`buttons/${id}`);
            if (response.data.success) {
                displayMessage(response.data.message, 'success');
                const result = await axios.get('buttons');
                buttons.value = result.data;
                addNewRecord();
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
    if (stateUrl.value.includes('buttons')) {
        const response = await axios.get(`buttons/${id}`);
        data = response.data;
    }


    if (stateUrl.value.includes('buttons')) {
        form.title = data.title;
        form.url = data.url;
        form.background = data.background;
        form.foreground = data.foreground;
        form.priority = data.priority;
    }
};

const addNewRecord = () => {
    if (stateUrl.value.includes('edit=true')) {
        let newUrl = stateUrl.value;
        newUrl = newUrl.replace("?edit=true", '');
        stateUrl.value = newUrl;
        window.history.pushState({ path: newUrl }, '', newUrl);
        editDataId.value = null;

        if (stateUrl.value.includes('buttons')) {
            form.reset();
        }
    }
};

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
                <h1 v-if="!stateUrl.includes('edit=true')" class="heading text-center text-[13px] md:text-[16px]">Add Button</h1>
                <h1 v-if="stateUrl.includes('edit=true')" class="heading text-center text-[13px] md:text-[16px]">Update Button</h1>
                <form action="" @submit.prevent="submitData">
                    <label class="heading-2 block" for="title">Title</label>
                    <input type="text" id="title" v-model="form.title" name="title" placeholder="Title">
                    <InputError v-if="errors && errors.title" class="text-center" :message="errors.title[0]" />

                    <label class="heading-2 block" for="url">Link</label>
                    <input type="text" id="url" v-model="form.url" name="url" placeholder="Link">
                    <InputError v-if="errors && errors.url" class="text-center" :message="errors.url[0]" />

                    <section class="flex justify-between md:justify-around my-5">
                        <div>
                            <label class="heading-2 block">Background</label>
                            <ColorPicker picker-type="fk" format="hex" theme="black" disable-alpha v-model:pureColor="form.background" />
                        </div>
                        
                        <div>
                            <label class="heading-2 block">Foreground</label>
                            <ColorPicker picker-type="fk" format="hex" theme="black" disable-alpha v-model:pureColor="form.foreground" />
                        </div>
                    </section>
                    <section class="flex flex-col items-center" v-if="form.title">
                        <label class="heading-2 block" for="url">Button Preview</label>
                        <a :href="form.url" :style="{ backgroundColor: form.background, color: form.foreground }" 
                            :class="`no-underline uppercase rounded-[30px] text-[13px] font-bold py-[3px] px-[45px]`"
                            target="_blank">
                            {{ form.title }}
                        </a>
                    </section>

                    <label class="heading-2" for="priority">Priority</label>
                    <select v-if="!stateUrl.includes('edit=true')" id="priority" name="priority" v-model="form.priority">
                        <option value="">Select Priority</option>
                        <option :value="item" v-for="(item, index) in (buttons?.length + 1) || 1" :key="index">Priority {{ index + 1 }}</option>
                    </select>
                    <select v-if="stateUrl.includes('edit=true')" id="priority" name="priority" v-model="form.priority">
                        <option value="">Select Priority</option>
                        <option :value="item" v-for="(item, index) in buttons?.length" :key="index">Priority {{ index + 1 }}</option>
                    </select>
                    <InputError v-if="errors && errors.priority" class="text-center" :message="errors.priority[0]" />


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
                            <th class="hidden lg:inline-block">Title</th>
                            <th class="hidden lg:inline-block">Link</th>
                            <th>Preview</th>
                            <th class="text-center">Priority</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in buttons" :key="item.id" class="text-left text-[13px] md:text-[16px]">
                            <td>{{ index + 1 }}</td>
                            <td class="uppercase hidden lg:inline-block">{{ item.title }}</td>
                            <td class=" hidden lg:inline-block">{{ item.url }}</td>
                            <td>
                                <a :style="{ backgroundColor: item.background, color: item.foreground }" 
                                    class="no-underline uppercase rounded-[30px] text-[13px] font-bold py-[3px] px-[15px] lg:px-[45px]"
                                    target="_blank">
                                    {{ item.title }}
                                </a>
                            </td>
                            <td class="text-center">{{ item.priority }}</td>
                            <td><span class="material-icons-sharp text-[14px] text-[green]" @click="editData(item.id)">edit</span></td>
                            <td><span class="material-icons-sharp text-[14px] text-[red]" @click="deletePrediction(item.id)">delete</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </section>
</template>