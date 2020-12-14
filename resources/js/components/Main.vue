<template>
    <div>
        <nav class="navbar-default navbar-side" id="navbar-superadmin" role="navigation">
                <div id="navbar-div" class="sidebar-collapse">
                    <ul class="nav" id="main-menu">
                        <li @click="changeNavbarStatus"><router-link class="nav-link" :to="'/'"><i class="fa fa-desktop"></i>Dashboard</router-link></li>
                        <li @click="changeNavbarStatus" v-if="company_courses_allowed > 0"><router-link class="nav-link" :to="'/courses'"><i class="fa fa-book"></i>My courses</router-link></li>
                        <li @click="changeNavbarStatus" v-if="company_jobs_allowed > 0"><router-link class="nav-link" :to="'/vacancies'"><i class="fa fa-table"></i>My vacancies</router-link></li>
                        <li @click="changeNavbarStatus" v-if="company_jobs_allowed > 0"><router-link class="nav-link" :to="'/applications'"><i class="fa fa-bar-chart-o"></i>Applications</router-link></li>
                        <li @click="changeNavbarStatus" v-if="company_events_allowed > 0"><router-link class="nav-link" :to="'/events'"><i class="fa fa-table"></i>My events</router-link></li>
                        <li @click="changeNavbarStatus"><router-link class="nav-link" :to="'/billing'"><i class="fa fa-credit-card"></i>Billing</router-link></li>
                        <li @click="changeNavbarStatus" v-if="userAdmin.role === 'admin'"><router-link class="nav-link" :to="'/users'"><i class="fa fa-users"></i>Users</router-link></li>
                        <li @click="changeNavbarStatus" v-if="userAdmin.role === 'admin'"><router-link class="nav-link" :to="'/company'"><i class="fa fa-gears"></i>Company</router-link></li>
                        <li @click="changeNavbarStatus"><router-link class="nav-link" :to="'/assets'"><i class="fa fa-image"></i>Assets</router-link></li>
                    </ul>
                </div>
            </nav>
            <router-view></router-view>
    </div>
</template>

<script>
    
    export default {

        name: 'Main',

        mounted(){
            this.$store.dispatch("setCompannedLoggedUser")
            this.$store.dispatch("setCompanyInfo")
        },

        computed: { 
            userAdmin(){return this.$store.getters.getCompanyLoggedUser},
            company_jobs_allowed(){return this.$store.getters.getCompanyJobsAllowed},
            company_events_allowed(){return this.$store.getters.getCompanyEventsAllowed},
            company_courses_allowed(){return this.$store.getters.getCompanyCoursesAllowed},
        },

        methods: {

            changeNavbarStatus(){
                let navbar_div = document.getElementById('navbar-div');
                navbar_div.classList.remove("in");
                navbar_div.classList.remove("show");
            }
        }


    }
</script>
