<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
// import { usePage } from '@inertiajs/inertia-vue3';
import { onMounted, watch, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import axios from '../axiosConfig';

onMounted(() => {

    const sideMenu = document.querySelector("aside");
    const menuBtn = document.querySelector("#menu-btn");
    const closeBtn = document.querySelector("#close-btn");
    const themeToggler = document.querySelector(".theme-toggler");

    // show sidebar
    menuBtn?.addEventListener("click", () => {
        sideMenu.style.display = "block";
    });

    // hide sidebar
    closeBtn.addEventListener("click", () => {
        sideMenu.style.display = "none";
    });

    // change theme
    themeToggler?.addEventListener("click", () => {
        document.body.classList.toggle("dark-theme-variables");

        themeToggler.querySelector('span:nth-child(1)').classList.toggle('active');
        themeToggler.querySelector('span:nth-child(2)').classList.toggle('active');
    });
});

const displayMessage = (message, type) => {
    // if (type === 'success') toast.success(message, { autoClose: 1000,});
    // else toast(message, { autoClose: 1000,});
    toast(message, { autoClose: 1000, type}); 
};


const dashboardUrl = '/dashboard';
const usersUrl = '/dashboard/users';
const whiteNinjaUrl = '/dashboard/white-ninja';
const redNinjaUrl = '/dashboard/red-ninja';
const blackNinjaUrl = '/dashboard/black-ninja';
const leaguesUrl = '/dashboard/leagues';
const fixturesUrl = '/dashboard/fixtures';
const tipsUrl = '/dashboard/tips';
const bannersUrl = '/dashboard/banners';

const whiteNinjas = ref(null);
const blackNinjas = ref(null);
const redNinjas = ref(null);
const leagues = ref(null);
const fixtures = ref(null);
const tips = ref(null);
const banners = ref(null);

const loadInitialData = async () => {
  try {
    let response;
    response = await axios.get('white-ninjas');
    whiteNinjas.value = response.data;

    response = await axios.get('black-ninjas');
    blackNinjas.value = response.data;

    response = await axios.get('red-ninjas');
    redNinjas.value = response.data;

    response = await axios.get('leagues');
    leagues.value = response.data;

    response = await axios.get('fixtures');
    fixtures.value = response.data;

    response = await axios.get('tips');
    tips.value = response.data;

    response = await axios.get('banners');
    banners.value = response.data;

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

const otherForm = useForm({
    title: ''
});

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

const submitPrediction = async () => {
    if (stateUrl.value.includes("white-ninja")) {
        try {
            if (stateUrl.value.includes('edit=true') && editDataId) {
                const response = await axios.put(`white-ninjas/${editDataId.value}`, form.data());
                if (response.status === 201) {
                    displayMessage(response.data.message, 'success');
                    const result = await axios.get('white-ninjas');
                    whiteNinjas.value = result.data;
                }
            } else {
                const response = await axios.post('white-ninjas', form.data());
                if (response.status === 201) {
                    displayMessage(response.data.message, 'success');
                    const result = await axios.get('white-ninjas');
                    whiteNinjas.value = result.data;
                    form.reset();
                }
            }
        } catch (error) {
            displayMessage(error.response.statusText, 'error');
        }
    }

    else if (stateUrl.value.includes("red-ninja")) {
        try {
            if (stateUrl.value.includes('edit=true') && editDataId) {
                const response = await axios.put(`red-ninjas/${editDataId.value}`, form.data());
                if (response.status === 201) {
                    displayMessage(response.data.message, 'success');
                    const result = await axios.get('red-ninjas');
                    redNinjas.value = result.data;
                }
            } else {
                const response = await axios.post('red-ninjas', form.data());
                if (response.status === 201) {
                    displayMessage(response.data.message, 'success');
                    const result = await axios.get('red-ninjas');
                    redNinjas.value = result.data;
                    form.reset();
                }
            }
        } catch (error) {
            displayMessage(error.response.statusText, 'error');
        }
    }

    else if (stateUrl.value.includes("black-ninja")) {
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
    
    // console.log(form.data())
    // form.post(route('white-ninja'), {
    //     onFinish: () => form.reset(),
    // });
};

const submitData = async () => {
    if (stateUrl.value.includes("leagues")) {
        try {
            if (stateUrl.value.includes('edit=true') && editDataId) {
                const response = await axios.put(`leagues/${editDataId.value}`, otherForm.data());
                if (response.status === 201) {
                    displayMessage(response.data.message, 'success');
                    const result = await axios.get('leagues');
                    leagues.value = result.data;
                    editDataId.value = '';
                }
            } else {
                const response = await axios.post('leagues', otherForm.data());
                if (response.status === 201) {
                    displayMessage(response.data.message, 'success');
                    const result = await axios.get('leagues');
                    leagues.value = result.data;
                    otherForm.reset();
                    editDataId.value = '';
                }
            }
        } catch (error) {
            displayMessage(error.response.statusText, 'error');
        }
    }

    else if (stateUrl.value.includes("fixtures")) {
        try {
            if (stateUrl.value.includes('edit=true') && editDataId) {
                const response = await axios.put(`fixtures/${editDataId.value}`, otherForm.data());
                if (response.status === 201) {
                    displayMessage(response.data.message, 'success');
                    const result = await axios.get('fixtures');
                    fixtures.value = result.data;
                }
            } else {
                const response = await axios.post('fixtures', otherForm.data());
                if (response.status === 201) {
                    displayMessage(response.data.message, 'success');
                    const result = await axios.get('fixtures');
                    fixtures.value = result.data;
                    otherForm.reset();
                }
            }
        } catch (error) {
            displayMessage(error.response.statusText, 'error');
        }
    }

    else if (stateUrl.value.includes("tips")) {
        try {
            if (stateUrl.value.includes('edit=true') && editDataId) {
                const response = await axios.put(`tips/${editDataId.value}`, otherForm.data());
                if (response.status === 201) {
                    displayMessage(response.data.message, 'success');
                    const result = await axios.get('tips');
                    tips.value = result.data;
                }
            } else {
                const response = await axios.post('tips', otherForm.data());
                if (response.status === 201) {
                    displayMessage(response.data.message, 'success');
                    const result = await axios.get('tips');
                    tips.value = result.data;
                    otherForm.reset();
                }
            }
        } catch (error) {
            displayMessage(error.response.statusText, 'error');
        }
    }

    else if (stateUrl.value.includes("banners")) {
        const formData = new FormData();
        formData.append('name', bannerForm.data().name);
        formData.append('position', bannerForm.data().position);
        formData.append('file', bannerForm.data().file);
        formData.append('url', bannerForm.data().url);
        try {
            if (stateUrl.value.includes('edit=true') && editDataId) {
                const response = await axios.put(`banners/${editDataId.value}`, formData);
                if (response.status === 201) {
                    displayMessage(response.data.message, 'success');
                    const result = await axios.get('banners');
                    banners.value = result.data;
                }
            } else {
                console.log("bannerForm.data()>>>", bannerForm.data())
                const response = await axios.post('banners', formData);
                if (response.status === 201) {
                    displayMessage(response.data.message, 'success');
                    const result = await axios.get('banners');
                    banners.value = result.data;
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
    if (stateUrl.value.includes("white-ninja")) {
        try {
            const response = await axios.delete(`white-ninjas/${id}`);
            if (response.data.success) {
                displayMessage(response.data.message, 'success');
                const result = await axios.get('white-ninjas');
                whiteNinjas.value = result.data;
            }
        } catch (error) {
            displayMessage(error.response.statusText, 'error');
        }
    }

    else if (stateUrl.value.includes("red-ninja")) {
        try {
            const response = await axios.delete(`red-ninjas/${id}`);
            if (response.data.success) {
                displayMessage(response.data.message, 'success');
                const result = await axios.get('red-ninjas');
                redNinjas.value = result.data;
            }
        } catch (error) {
            displayMessage(error.response.statusText, 'error');
        }
    }

    else if (stateUrl.value.includes("black-ninja")) {
        const response = await axios.delete(`black-ninjas/${id}`);
        if (response.data.success) {
            displayMessage(response.data.message, 'success');
            const result = await axios.get('black-ninjas');
            blackNinjas.value = result.data;
        } else {
            displayMessage(response.data.message, 'error');
        }
    }

    else if (stateUrl.value.includes("leagues")) {
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

    else if (stateUrl.value.includes("fixtures")) {
        try {
            const response = await axios.delete(`fixtures/${id}`);
            if (response.data.success) {
                displayMessage(response.data.message, 'success');
                const result = await axios.get('fixtures');
                fixtures.value = result.data;
            }
        } catch (error) {
            displayMessage(error.response.statusText, 'error');
        }
    }

    else if (stateUrl.value.includes("tips")) {
        try {
            const response = await axios.delete(`tips/${id}`);
            if (response.data.success) {
                displayMessage(response.data.message, 'success');
                const result = await axios.get('tips');
                tips.value = result.data;
            }
        } catch (error) {
            displayMessage(error.response.statusText, 'error');
        }
    }

    else if (stateUrl.value.includes("banners")) {
        try {
            const response = await axios.delete(`banners/${id}`);
            console.log("Before-Before", response.data);
            if (response.data.success) {
                console.log("within-Before");
                displayMessage(response.data.message, 'success');
                const result = await axios.get('banners');
                console.log("within-after");
                banners.value = result.data;
            }
        } catch (error) {
            console.log("catch-Before");
            displayMessage(error.response.statusText, 'error');
            console.log("catch-after");
        }
    }
};
    
const editData = async id => {
    if (!stateUrl.value.includes('edit=true')) {
        const newUrl = `${url}?edit=true`;
        stateUrl.value = newUrl;
        window.history.pushState({ path: newUrl }, '', newUrl);
        // Inertia.visit(`${url}/?edit=true`, { preserveState: true });
    }
    editDataId.value = id;

    let data;
    if (stateUrl.value.includes('white-ninja')) {
        const response = await axios.get(`white-ninjas/${id}`);
        data = response.data;
    }

    else if (stateUrl.value.includes('red-ninja')) {
        const response = await axios.get(`red-ninjas/${id}`);
        data = response.data;
    }

    else if (stateUrl.value.includes('black-ninja')) {
        const response = await axios.get(`black-ninjas/${id}`);
        data = response.data;
    }

    else if (stateUrl.value.includes('leagues')) {
        const response = await axios.get(`leagues/${id}`);
        data = response.data;
    }

    else if (stateUrl.value.includes('fixture')) {
        const response = await axios.get(`fixtures/${id}`);
        data = response.data;
    }

    else if (stateUrl.value.includes('tips')) {
        const response = await axios.get(`tips/${id}`);
        data = response.data;
    }

    if (stateUrl.value.includes('white-ninja') || stateUrl.value.includes('red-ninja') || 
    stateUrl.value.includes('black-ninja')) {
        form.league_id = data.league_id;
        form.fixtures = data.fixtures;
        form.tip_id = data.tip_id;
        form.results = data.results === true ? 1 : 0;
    }
    
    if (stateUrl.value.includes('leagues') || stateUrl.value.includes('fixtures') || stateUrl.value.includes('tips')) {
        otherForm.title = data.title;
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

        if (stateUrl.value.includes('leagues') || stateUrl.value.includes('fixtures') || stateUrl.value.includes('tips')) {
            otherForm.reset();
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
    <Head title="Dashboard" />

    <section id="mainContainer" class="">
        <div class="container">
            <aside>
                <div class="top">
                    <div class="logo">
                        <h2>Three <span class="danger">Ninjas</span></h2>
                    </div>
                    <div class="close" id="close-btn">
                        <span class="material-icons-sharp">close</span>
                    </div>
                </div>
                <div class="sidebar">
                    <Link href="/dashboard" :class="{ 'active': $page.url=== dashboardUrl }">
                        <span class="material-icons-sharp">grid_view</span>
                        <h3 class="heading">Dashboard</h3>
                    </Link>
                    <Link href="/dashboard/users" :class="{ 'active': $page.url.includes(usersUrl) }">
                        <span class="material-icons-sharp">account_circle</span>
                        <h3>Users</h3>
                    </Link>
                    <Link href="/dashboard/white-ninja" :class="{ 'active': $page.url.includes(whiteNinjaUrl) }">
                        <span class="material-icons-sharp">person_outline</span>
                        <h3>White Ninja</h3>
                    </Link>
                    <Link href="/dashboard/red-ninja" :class="{ 'active': $page.url.includes(redNinjaUrl) }">
                        <span class="material-icons-sharp">grid_view</span>
                        <h3>Red Ninja</h3>
                    </Link>
                    <Link href="/dashboard/black-ninja" :class="{ 'active': $page.url.includes(blackNinjaUrl) }">
                        <span class="material-icons-sharp">person_add</span>
                        <h3>Black Ninja</h3>
                    </Link>
                    <Link href="/dashboard/leagues" :class="{ 'active': $page.url.includes(leaguesUrl) }">
                        <span class="material-icons-sharp">insights</span>
                        <h3>Leagues</h3>
                    </Link>
                    <!-- <Link href="/dashboard/fixtures">
                        <span class="material-icons-sharp">settings</span>
                        <h3>Fixtures</h3>
                    </Link> -->
                    <Link href="/dashboard/tips" :class="{ 'active': $page.url.includes(tipsUrl) }">
                        <span class="material-icons-sharp">analytics</span>
                        <h3>Tips</h3>
                    </Link>
                    <Link href="/dashboard/banners" :class="{ 'active': $page.url.includes(bannersUrl) }">
                        <span class="material-icons-sharp">stay_current_landscape</span>
                        <h3>Banners</h3>
                    </Link>
                    <Link href="/">
                        <span class="material-icons-sharp">home</span>
                        <h3>Homepage</h3>
                    </Link>
                    <Link :href="route('logout')" method="post">
                        <span class="material-icons-sharp">logout</span>
                        <h3>Logout</h3>
                    </Link>
                </div>
            </aside>
            <!-- End of aside -->
            
            <article>
                <section v-if="$page.url === dashboardUrl" id="mainSection">
                    <main>
                        <h1 class="heading">Dashboard</h1>

                        <div class="date">
                            <input type="date" class="bg-transparent text-dark">
                        </div>

                        <!-- Insights -->
                        <div class="insights">
                            <div class="sales">
                                <span class="material-icons-sharp">analytics</span>
                                <div class="middle">
                                    <div class="left">
                                        <h3>All Users</h3>
                                        <h1>530</h1>
                                    </div>
                                    <div class="progress">
                                        <svg>
                                            <circle 
                                                cx="38" cy="38" r="36" ></circle>
                                        </svg>
                                        <div class="number">
                                            <p>81%</p>
                                        </div>
                                    </div>
                                </div>
                                <small class="text-muted">Last 24hours</small>
                            </div>
                            <!-- End of All Users -->

                            <div class="expenses">
                                <span class="material-icons-sharp">analytics</span>
                                <div class="middle">
                                    <div class="left">
                                        <h3>Subscribed</h3>
                                        <h1>280</h1>
                                    </div>
                                    <div class="progress">
                                        <svg class="w-[7rem] h-[7rem]">
                                            <circle cx="38" cy="38" r="36" ></circle>
                                        </svg>
                                        <div class="number">
                                            <p>62%</p>
                                        </div>
                                    </div>
                                </div>
                                <small class="text-muted">Last 24hours</small>
                            </div>
                            <!-- End of Subscribed Users -->

                            <div class="income">
                                <span class="material-icons-sharp">stacked_line_chart</span>
                                <div class="middle">
                                    <div class="left">
                                        <h3>Premium</h3>
                                        <h1>225</h1>
                                    </div>
                                    <div class="progress">
                                        <svg class="w-[7rem] h-[7rem]">
                                            <circle cx="38" cy="38" r="36" ></circle>
                                        </svg>
                                        <div class="number">
                                            <p>44%</p>
                                        </div>
                                    </div>
                                </div>
                                <small class="text-muted">Last 24hours</small>
                            </div>
                            <!-- End of Premium Users -->
                        </div>

                        <!-- Recent -->
                        <div class="recent-subscriptions">
                            <h2 class="heading">Recent Subscriptions</h2>

                            <table id="dashboard-table">
                                <thead>
                                    <tr>
                                        <th>Customer Name</th>
                                        <th>Customer Number</th>
                                        <th>Payment</th>
                                        <th>Status</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Joshua Gato</td>
                                        <td>0244306303</td>
                                        <td>Due</td>
                                        <td class="warning">Pending</td>
                                        <td class="primary">Details</td>
                                    </tr>
                                    <tr>
                                        <td>Joshua Gato</td>
                                        <td>0244306303</td>
                                        <td>Due</td>
                                        <td class="warning">Pending</td>
                                        <td class="primary">Details</td>
                                    </tr>
                                    <tr>
                                        <td>Joshua Gato</td>
                                        <td>0244306303</td>
                                        <td>Due</td>
                                        <td class="warning">Pending</td>
                                        <td class="primary">Details</td>
                                    </tr>
                                    <tr>
                                        <td>Joshua Gato</td>
                                        <td>0244306303</td>
                                        <td>Due</td>
                                        <td class="warning">Pending</td>
                                        <td class="primary">Details</td>
                                    </tr>
                                </tbody>
                            </table>
                            <Link href="">Show all</Link>
                        </div>
                    </main>
                    <!-- End of main -->

                    <div class="right">
                        <div class="top">
                            <button id="menu-btn" class="hidden">
                                <span class="material-icons-sharp">menu</span>
                            </button>
                            <div class="theme-toggler">
                                <span class="material-icons-sharp active">light_mode</span>
                                <span class="material-icons-sharp">dark_mode</span>
                            </div>
                            <div class="profile">
                                <div class="info">
                                    <p>Hey, <b>Joshua</b></p>
                                    <small class="text-muted">Admin</small>
                                </div>
                                <div class="profile-photo">
                                    <img src="/images/profile-1.jpg" alt="profile picture">
                                </div>
                            </div>
                        </div>
                        <!-- End of top -->

                        <div class="recent-updates">
                            <h2 class="heading">Recent Updates</h2>
                            <div class="updates">
                                <div class="update">
                                    <div class="profile-photo">
                                        <img src="/images/profile-2.jpg" alt="profile picture">
                                    </div>
                                    <div class="message">
                                        <p><b>Joshua Gato</b><span class="text-[gray]"> Paid for premium subscription</span></p>
                                        <small class="text-muted">2 minutes ago</small>
                                    </div>
                                </div>
                                <div class="update">
                                    <div class="profile-photo">
                                        <img src="/images/profile-3.jpg" alt="profile picture">
                                    </div>
                                    <div class="message">
                                        <p><b>Joshua Gato</b><span class="text-[gray]"> Paid for premium subscription</span></p>
                                        <small class="text-muted">2 minutes ago</small>
                                    </div>
                                </div>
                                <div class="update">
                                    <div class="profile-photo">
                                        <img src="/images/profile-4.jpg" alt="profile picture">
                                    </div>
                                    <div class="message">
                                        <p><b>Joshua Gato</b><span class="text-[gray]"> Paid for premium subscription</span></p>
                                        <small class="text-muted">2 minutes ago</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End of recent updates -->

                        <div class="analytics">
                            <h2 class="heading">Analytics</h2>
                            <div class="item online">
                                <div class="icon">
                                    <span class="material-icons-sharp">shopping_cart</span>
                                </div>
                                <div class="right">
                                    <div class="info">
                                        <h3>PrideBet Clicks</h3>
                                        <small class="text-muted">Last 24 hours</small>
                                    </div>
                                    <h5 class="success">+39%</h5>
                                    <h3>3849</h3>
                                </div>
                            </div>
                            <div class="item offline">
                                <div class="icon">
                                    <span class="material-icons-sharp">local_mall</span>
                                </div>
                                <div class="right">
                                    <div class="info">
                                        <h3>Betway Clicks</h3>
                                        <small class="text-muted">Last 24 hours</small>
                                    </div>
                                    <h5 class="danger">-17%</h5>
                                    <h3>1100</h3>
                                </div>
                            </div>
                            <div class="item customers">
                                <div class="icon">
                                    <span class="material-icons-sharp">person</span>
                                </div>
                                <div class="right">
                                    <div class="info">
                                        <h3>New Customers</h3>
                                        <small class="text-muted">Last 24 hours</small>
                                    </div>
                                    <h5 class="">+25%</h5>
                                    <h3>849</h3>
                                </div>
                            </div>
                            <div class="item add-product">
                                <div>
                                    <span class="material-icons-sharp">add</span>
                                    <h3>Add Product</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section v-if="$page.url.startsWith(whiteNinjaUrl)" class="mainSection">
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
                            <h1 class="heading text-center">White Ninja Predictions</h1>
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
                                    <tr v-for="(item, index) in whiteNinjas" :key="item.id" class="text-left text-[13px] md:text-[16px]">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ item.league.title }}</td>
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
                <section v-if="$page.url.startsWith(redNinjaUrl)" class="mainSection">
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
                            <h1 class="heading text-center">Red Ninja Predictions</h1>
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
                                    <tr v-for="(item, index) in redNinjas" :key="item.id" class="text-left text-[13px] md:text-[16px]">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ item.league.title }}</td>
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
                <section v-if="$page.url.startsWith(blackNinjaUrl)" class="mainSection">
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
                <section v-if="$page.url.startsWith(leaguesUrl)" class="mainSection">
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
                <section v-if="$page.url.startsWith(fixturesUrl)" class="mainSection">
                    <main class="prediction-main">
                        
                        <div class="add-record">
                            <h1 v-if="!stateUrl.includes('edit=true')" class="heading text-center text-[13px] md:text-[16px]">Add Fixture</h1>
                            <h1 v-if="stateUrl.includes('edit=true')" class="heading text-center text-[13px] md:text-[16px]">Update Fixture</h1>
                            <form action="" @submit.prevent="submitData">
                                <label class="heading-2" for="fixture">Fixtures</label>
                                <input type="text" id="fixture" v-model="otherForm.title" name="fixture" placeholder="Fixtures">
                            
                                <div class="form-buttons">
                                    <button v-if="!stateUrl.includes('edit=true')" type="reset">Clear</button>
                                    <button v-if="stateUrl.includes('edit=true')" type="button" @click="addNewRecord">Add New</button>

                                    <button v-if="!stateUrl.includes('edit=true')" type="submit">Submit</button>
                                    <button v-if="stateUrl.includes('edit=true')" type="submit">Update</button>
                                </div>
                            </form>
                        </div>

                        <div>
                            <h1 class="heading text-center">Available Fixtures</h1>
                            <table class="predictions">
                                <thead>
                                    <tr class="text-left text-[13px] md:text-[16px]">
                                        <th>#</th>
                                        <th>League Title</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in fixtures" :key="item.id" class="text-left text-[13px] md:text-[16px]">
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
                <section v-if="$page.url.startsWith(tipsUrl)" class="mainSection">
                    <main class="prediction-main">
                        
                        <div class="add-record">
                            <h1 v-if="!stateUrl.includes('edit=true')" class="heading text-center text-[13px] md:text-[16px]">Add Tip</h1>
                            <h1 v-if="stateUrl.includes('edit=true')" class="heading text-center text-[13px] md:text-[16px]">Update Tip</h1>
                            <form action="" @submit.prevent="submitData">
                                <label class="heading-2" for="tips">Tips</label>
                                <input type="text" id="tips" v-model="otherForm.title" name="tips" placeholder="Tips">
                            
                                <div class="form-buttons">
                                    <button v-if="!stateUrl.includes('edit=true')" type="reset">Clear</button>
                                    <button v-if="stateUrl.includes('edit=true')" type="button" @click="addNewRecord">Add New</button>

                                    <button v-if="!stateUrl.includes('edit=true')" type="submit">Submit</button>
                                    <button v-if="stateUrl.includes('edit=true')" type="submit">Update</button>
                                </div>
                            </form>
                        </div>

                        <div>
                            <h1 class="heading text-center">Available Tips</h1>
                            <table class="predictions">
                                <thead>
                                    <tr class="text-left text-[13px] md:text-[16px]">
                                        <th>#</th>
                                        <th>Tip Title</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in tips" :key="item.id" class="text-left text-[13px] md:text-[16px]">
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
                <section v-if="$page.url.startsWith(bannersUrl)" class="mainSection">
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
                                <input type="file" id="banner" @change="attachFile" name="banner" placeholder="Banner">
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
                                        <td><span class="material-icons-sharp text-[14px] text-[green]" @click="editData(item.id)">edit</span></td>
                                        <td><span class="material-icons-sharp text-[14px] text-[red]" @click="deletePrediction(item.id)">delete</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </main>
                </section>
            </article>
        </div>
    </section>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

* {
    margin: 0;
    padding: 0;
    outline: 0;
    appearance: none;
    border: 0;
    text-decoration: none;
    list-style: none;
    box-sizing: border-box;
}

input[type=text], select {
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

.form-buttons button[type=reset], button[type=button] {
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
    margin-top: 10px;
    margin-bottom: 50px;
}

@media screen and (max-width: 768px) {
    div.add-record {
        width: 100%;
        /* margin: auto; */
        margin: 30px auto 60px;
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
    /* padding: var(--card-padding); */ /* why*/
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
    position: absolute;
    bottom: 2rem;
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
    margin-top: 30px;
}

main {
    margin-top: 1.4rem;
}

main .date {
    display: inline-block;
    background: var(--color-light);
    border-radius: var(--border-radius-1);
    margin-top: 1rem;
    padding: 0.5rem 1.6rem;
}

main .date input[type="date"] {
    background: transparent;
    color: var(--color-dark);
}

main .insights {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.6rem
}

main .insights > div {
    background: var(--color-white);
    padding: var(--card-padding);
    border-radius: var(--card-border-radius);
    margin-top: 1rem;
    box-shadow: var(--box-shadow);
    transition: all 300ms ease;
}

main .insights > div:hover {
    box-shadow: none;
}

main .insights > div span {
    background: var(--color-primary);
    padding: 0.5rem;
    border-radius: 50%;
    color: var(--color-white);
    font-size: 2rem;
}

main .insights > div.expenses span {
    background: var(--color-danger);
}

main .insights > div.income span {
    background: var(--color-success);
}

main .insights > div .middle {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

main .insights > div .middle .left h1,
main .insights > div .middle .left h3 {
    color: var(--color-dark);
}

main .insights h3 {
    margin: 1rem 0 0.6rem;
    font-size: 1rem;
}

main .insights .progress {
    position: relative;
    width: 92px;
    height: 92px;
    border-radius: 50%;
}

main .insights svg {
    width: 7rem;
    height: 7rem;
}

main .insights svg circle {
    fill: none;
    stroke: var(--color-primary);
    stroke-width: 14;
    stroke-linecap: round;
    transform: translate(5px, 5px);
    stroke-dasharray: 110;
    stroke-dashoffset: 92;
}

main .insights .sales svg circle {
    stroke-dashoffset: -30;
    stroke-dasharray: 200;
}

main .insights .expenses svg circle {
    stroke-dashoffset: 20;
    stroke-dasharray: 80;
}

main .insights .income svg circle {
    stroke-dashoffset: 35;
    stroke-dasharray: 110;
}

main .insights .progress .number {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}

main .insights .progress .number p {
    color: var(--color-dark);
}

main .insights small {
    margin-top: 1.6rem;
    display: block;
}

main .recent-subscriptions {
    margin-top: 2rem;
}

main .recent-subscriptions h2 {
    margin-bottom: 0.8rem;
}

main .recent-subscriptions table {
    background: var(--color-white);
    width: 100%;
    border-radius: var(--card-border-radius);
    /* padding: var(--card-padding); */ /* why*/
    text-align: center;
    box-shadow: var(--box-shadow);
    transition: all 300ms ease;
}

main .recent-subscriptions table:hover {
    box-shadow: none;
}

main table thead th {
    padding: var(--card-padding) var(--padding-small);
    color: var(--color-dark);
}

main table tbody td {
    height: 2.8rem;
    border-bottom: 1px solid var(--color-light);
    color: var(--color-dark-variant);
    padding: var(--padding-small); /* Why*/
}

main table tbody tr:last-child td {
    border: none;
}

@media screen and (max-width: 768px) {
    main table thead th {
        padding: var(--card-padding) var(--padding-small);
    }

    main table tbody td {
        padding: var(--padding-small) var(--padding-small); /* Why*/
    }
}

main .recent-subscriptions a {
    text-align: center;
    display: block;
    margin: 1rem auto;
    color: var(--color-primary);
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

.right .top .profile {
    display: flex;
    gap: 2rem;
    text-align: right;
}
/* End of right top */

.right .recent-updates {
    margin-top: 1rem;
}

.right .recent-updates h2 {
    margin-bottom: 0.8rem;
}

.right .recent-updates .updates {
    background: var(--color-white);
    padding: var(--card-padding);
    border-radius: var(--card-border-radius);
    box-shadow: var(--box-shadow);
    transition: all 300ms ease;
}

.right recent-updates .updates:hover {
    box-shadow: none;
}

.right .recent-updates .updates .update {
    display: grid;
    grid-template-columns: 2.6rem auto;
    gap: 1rem;
    margin-bottom: 1rem;
}

.right .analytics {
    margin-top: 2rem;
}

.right .analytics h2 {
    margin-bottom: 0.8rem;
}

.right .analytics .item {
    background: var(--color-white);
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 0.7rem;
    padding: 1.4rem var(--card-padding);
    border-radius: var(--border-radius-3);
    box-shadow: var(--box-shadow);
    transition: all 300ms ease;
}

.right .analytics .item:hover {
    box-shadow: none;
}

.right .analytics .item .right {
    display: flex;
    justify-content: space-between;
    align-items: start;
    margin: 0;
    width: 100%;
}

.right .analytics .item .icon {
    padding: 0.6rem;
    color: white;
    border-radius: 50%;
    background: var(--color-primary);
    display: flex;
}

.right .analytics .item.offline .icon {
    background: var(--color-danger);
}

.right .analytics .item.customers .icon {
    background: var(--color-success);
}

.right .analytics .info h3 {
    color: var(--color-dark);
}

.right .analytics .add-product {
    background: transparent;
    border: 2px dashed var(--color-primary);
    color: var(--color-primary);
    display: flex;
    align-items: center;
    justify-content: center;
}

.right .analytics .add-product div {
    display: flex;
    align-content: center;
    gap: 0.6rem;
}

.right .analytics .add-product div h3 {
    font-weight: 600;
}

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
        margin-top: 8rem;
        padding: 0 1rem;
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
} */
</style>