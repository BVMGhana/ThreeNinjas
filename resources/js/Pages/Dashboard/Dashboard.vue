<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import axios from '../../axiosConfig';
import TimeAgo from 'javascript-time-ago';

// English.
import en from 'javascript-time-ago/locale/en'

TimeAgo.addDefaultLocale(en)

// Create formatter (English).
const timeAgo = new TimeAgo('en-US')

const displayMessage = (message, type) => toast(message, { autoClose: 1000, type});

const usersCount = ref(null);
const subscribersCount = ref(null);
const users = ref(null);
const recentUsers = ref(null);
const sportyBetClicks = ref(null);
const prideBetClicks = ref(null);
const betWayClicks = ref(null);
const premierBetClicks = ref(null);

const loadInitialData = async () => {
  try {
    let response;

    response = await axios.get('users-count');
    usersCount.value = response.data;

    response = await axios.get('subscriptions-count');
    subscribersCount.value = response.data;

    response = await axios.get('users');
    users.value = response.data;
    
    response = await axios.get('recent-users');
    recentUsers.value = response.data;

    response = await axios.get(`bet-button-clicks/count/${'bet-way'}`);
    betWayClicks.value = response.data;

    response = await axios.get(`bet-button-clicks/count/${'pride-bet'}`);
    prideBetClicks.value = response.data;

    response = await axios.get(`bet-button-clicks/count/${'sporty-bet'}`);
    sportyBetClicks.value = response.data;
    
    response = await axios.get(`bet-button-clicks/count/${'premier-bet'}`);
    premierBetClicks.value = response.data;

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
    <section id="mainSection">
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
                            <h1>{{usersCount}}</h1>
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
                            <h1>{{subscribersCount}}</h1>
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
                            <h1>{{usersCount}}</h1>
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
                        <tr class="text-left">
                            <th class="customer-name">Customer Name</th>
                            <th>Customer Number</th>
                            <th>Registered</th>
                            <th class="hidden md:table-cell">Payment</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in users" :key="user.id" class="text-left">
                            <td class="customer-name">{{user.name}}</td>
                            <td>{{user.phone}}</td>
                            <td>{{timeAgo.format(new Date(user.created_at))}}</td>
                            <td class="success hidden md:table-cell">Done</td>
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
                        <p>Hey, <b>{{ $page.props.auth.user.name.split(" ")[0] }}</b></p>
                        <small class="text-muted">Admin</small>
                    </div>
                    <div class="profile-photo">
                        <img src="/images/default-profile.png" alt="profile picture">
                    </div>
                </div>
            </div>
            <!-- End of top -->

            <div class="recent-updates">
                <h2 class="heading">Recent Updates</h2>
                <div class="updates">
                    <div class="update" v-for="user in recentUsers" :key="user.id">
                        <div class="profile-photo">
                            <img src="/images/default-profile.png" alt="profile picture">
                        </div>
                        <div class="message">
                            <p><b>{{user.name}}</b><span class="text-[gray]"> Paid for premium subscription</span></p>
                            <small class="text-muted">{{timeAgo.format(new Date(user.created_at))}}</small>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of recent updates -->

            <div class="analytics">
                <h2 class="heading">Analytics</h2>
                <div class="item online">
                    <div class="icon">
                        <span class="material-icons-sharp">ads_click</span>
                    </div>
                    <div class="right">
                        <div class="info">
                            <h3>PrideBet Clicks</h3>
                            <small class="text-muted">Last 24 hours</small>
                        </div>
                        <h5 class="success">+{{prideBetClicks?.percentageLast24Hours}}%</h5>
                        <h3 class="text-visible">{{prideBetClicks?.countLast24Hours}}</h3>
                    </div>
                </div>
                <div class="item online">
                    <div class="icon">
                        <span class="material-icons-sharp">ads_click</span>
                    </div>
                    <div class="right">
                        <div class="info">
                            <h3>Sporty Bet Clicks</h3>
                            <small class="text-muted">Last 24 hours</small>
                        </div>
                        <h5 class="success">+{{sportyBetClicks?.percentageLast24Hours}}%</h5>
                        <h3 class="text-visible">{{sportyBetClicks?.countLast24Hours}}</h3>
                    </div>
                </div>
                <div class="item online">
                    <div class="icon">
                        <span class="material-icons-sharp">ads_click</span>
                    </div>
                    <div class="right">
                        <div class="info">
                            <h3>Betway Clicks</h3>
                            <small class="text-muted">Last 24 hours</small>
                        </div>
                        <h5 class="success">+{{betWayClicks?.percentageLast24Hours}}%</h5>
                        <h3 class="text-visible">{{betWayClicks?.countLast24Hours}}</h3>
                    </div>
                </div>
                <div class="item online">
                    <div class="icon">
                        <span class="material-icons-sharp">ads_click</span>
                    </div>
                    <div class="right">
                        <div class="info">
                            <h3>Betway Clicks</h3>
                            <small class="text-muted">Last 24 hours</small>
                        </div>
                        <h5 class="success">+{{premierBetClicks?.percentageLast24Hours}}%</h5>
                        <h3 class="text-visible">{{premierBetClicks?.countLast24Hours}}</h3>
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
                        <h5 class="primary">+25%</h5>
                        <h3 class="text-visible">{{usersCount}}</h3>
                    </div>
                </div>
                <!-- <div class="item add-product">
                    <div>
                        <span class="material-icons-sharp">add</span>
                        <h3>Add Product</h3>
                    </div>
                </div> -->
            </div>
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

.text-visible {
    color: var(--color-dark);
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

/* main */

main {
    /* width: 100%; */
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

main .insights>div {
    background: var(--color-white);
    padding: var(--card-padding);
    border-radius: var(--card-border-radius);
    margin-top: 1rem;
    box-shadow: var(--box-shadow);
    transition: all 300ms ease;
}

main .insights>div:hover {
    box-shadow: none;
}

main .insights>div span {
    background: var(--color-primary);
    padding: 0.5rem;
    border-radius: 50%;
    color: var(--color-white);
    font-size: 2rem;
}

main .insights>div.expenses span {
    background: var(--color-danger);
}

main .insights>div.income span {
    background: var(--color-success);
}

main .insights>div .middle {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

main .insights>div .middle .left h1,
main .insights>div .middle .left h3 {
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
    /* padding: var(--card-padding); */
    /* why*/
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
    padding: var(--padding-small);
    /* Why*/
}

main table tbody tr:last-child td {
    border: none;
}

@media screen and (max-width: 768px) {
    main table thead th {
        padding: var(--card-padding) var(--padding-semi-small);
    }

    main table thead th.customer-name,
    main table tbody td.customer-name {
        padding-left: var(--padding-quarter-small);
    }

    main table tbody td {
        padding: var(--padding-small) var(--padding-semi-small);
        /* Why*/
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

.right .recent-updates .updates:hover {
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
        width: 100%;
        /* position: absolute; */
        /* left: 50%; */
        /* transform: translateX(-50%); */
        /* margin: 2rem 0 0 8.8rem; */
        margin: 2rem auto;
    }

    main .recent-subscriptions table {
        /* width: 83vw; */
        /* width: 83%; */
    }

    main table#dashboard-table thead tr th:last-child,
    main table#dashboard-table tbody tr td:last-child {
        display: none;
    }
}

@media screen and (max-width: 768px) {
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
        margin: 4rem auto 0;
        padding: 0 0.5rem;
    }

    #mainSection {
        grid-template-columns: 1fr;
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
        width: 100%;
        margin: 0 auto 4rem;
        /* position: fixed;
        top: 0;
        left: 0;
        height: 3.5rem;
        z-index: 2; */
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

    .right .recent-updates,
    .right .analytics {
        padding: 0 1rem;
    }

    .right .updates {
        /* display: none; */
    }

    .right .analytics {
        /* display: none; */
    }
}

</style>