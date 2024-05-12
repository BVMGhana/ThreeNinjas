<template>
    <section id="mainSection">
        <main>
            <h1>Dashboard</h1>

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

                <table>
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
                <Link>Show all</Link>
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
</template>