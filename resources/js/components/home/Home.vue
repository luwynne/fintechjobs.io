<template>
        <div  id="page-wrapper" >
        <div id="page-inner">
            <div v-if="this.loading == true" id="over">
                <img :src="'/fintechjobs.io/public/admin/img/loading.gif'" width="100px">
            </div>

            <div v-else>
                <div class="row">
                <div class="col-lg-12">
                    <h2>{{company_name}}</h2>
                    <br />
                </div>

        <div class="col-lg-12">
            <table class="table">

                <tbody>

                    <tr v-if="company_plan.id !== 6">
                        <td>
                        <strong>
                        Plan:
                        </strong>
                        </td>
                        <td v-if="company_plan.id !== 0" class="align-left">
                            {{company_plan.name}} <span v-if="company_is_plan_expired" class="expired-badge">EXPIRED</span>
                        </td>
                        <td v-else class="align-left">
                            No Plans for the moment!
                        </td>
                    </tr>

                    <tr v-if="company_courses_allowed > 0"> 
                        <td><strong>Course Credits Total: </strong></td>
                        <td class="align-left" v-bind:class="{ 'blurred' : company_is_plan_expired }">
                            {{company_courses_allowed}}
                        </td>
                    </tr>

                    <tr v-if="company_courses_allowed > 0">
                        <td><strong>Course Credits Used: </strong></td>
                        <td class="align-left" v-bind:class="{ 'blurred' : company_is_plan_expired }">
                            {{company_courses_created}}
                        </td>
                    </tr>

                    <tr v-if="company_courses_allowed > 0">
                        <td><strong>Remaining Course Credits: </strong></td>
                        <td class="align-left" v-if="company_remaining_courses >= 0" v-bind:class="{ 'blurred' : company_is_plan_expired }">
                            {{company_remaining_courses}}
                        </td>
                        <td v-else class="align-left">
                            0
                        </td>
                    </tr>

                    <tr v-if="company_jobs_allowed > 0"> 
                        <td><strong>Job Credits Total: </strong></td>
                        <td class="align-left" v-bind:class="{ 'blurred' : company_is_plan_expired }">
                            {{company_jobs_allowed}}
                        </td>
                    </tr>

                    <tr v-if="company_jobs_allowed > 0">
                        <td><strong>Job Credits Used: </strong></td>
                        <td class="align-left" v-bind:class="{ 'blurred' : company_is_plan_expired }">
                            {{company_jobs_created}}
                        </td>
                    </tr>

                    <tr v-if="company_jobs_allowed > 0">
                        <td><strong>Remaining Job Credits: </strong></td>
                        <td class="align-left" v-if="company_remaining_jobs >= 0" v-bind:class="{ 'blurred' : company_is_plan_expired }">
                            {{company_remaining_jobs}}
                        </td>
                        <td v-else class="align-left">
                            0
                        </td>
                    </tr>

                    <tr v-if="company_events_allowed > 0"> 
                        <td><strong>Event Credits Total: </strong></td>
                        <td class="align-left" v-bind:class="{ 'blurred' : company_is_plan_expired }">
                            {{company_events_allowed}}
                        </td>
                    </tr>

                    <tr v-if="company_events_allowed > 0">
                        <td><strong>Event Credits Used: </strong></td>
                        <td class="align-left" v-bind:class="{ 'blurred' : company_is_plan_expired }">
                            {{company_events_created}}
                        </td>
                    </tr>

                    <tr v-if="company_events_allowed > 0">
                        <td><strong>Remaining Event Credits: </strong></td>
                        <td class="align-left" v-if="company_remaining_events >= 0" v-bind:class="{ 'blurred' : company_is_plan_expired }">
                            {{company_remaining_events}}
                        </td>
                        <td v-else class="align-left">
                            0
                        </td>
                    </tr>

                    <tr>
                        <td><strong>Admin</strong></td>
                        <td>{{company_rep.name}} | {{company_rep.email}}</td>
                    </tr>
                    </tbody>
                </table>
                <!-- TODO Change for actual site url -->
                <button v-if="userAdmin.role === 'admin'" @click="redirectProducts" type="button" class="btn btn-primary modal-primary">
                    <span v-if="company_is_plan_expired">Renew</span>
                    <span v-else>Upgrade</span>
                </button>
            </div>
        </div>
        <!-- /. ROW  -->
        </div>
    </div>
</div>

</template>

<script>

    import axios from 'axios'
    import store from '../../store/store'

    export default {

        data(){
            return {
                company : '',
                loading: false
            }
        },

        methods: {

            redirectProducts(){
                window.location.href = 'http://localhost:8888/fintechjobs.io/admin/products';
            }

        },

        mounted(){
            this.loading = true;
            setTimeout(() => {
                this.loading = false;
            }, 400);
        },

        computed: { // Vuex implementstion Getters

            // Company Info
            company_name(){return this.$store.getters.getCompanyName},
            company_plan(){return this.$store.getters.getCompanyPlan},

            // Company Job plan set
            company_is_plan_expired(){return this.$store.getters.getCompanyIsPlanExpired},
            company_jobs_allowed(){return this.$store.getters.getCompanyJobsAllowed},
            company_jobs_created(){return this.$store.getters.getCompanyJobsCreated},
            company_remaining_jobs(){return this.$store.getters.getCompanyRemainingJobs},

            // Company user set
            company_rep(){return this.$store.getters.getCompanyRep},
            userAdmin(){return this.$store.getters.getCompanyLoggedUser},

            // Company Event plan set
            company_events_allowed(){return this.$store.getters.getCompanyEventsAllowed},
            company_events_created(){return this.$store.getters.getCompanyEventsCreated},
            company_remaining_events(){return this.$store.getters.getCompanyRemainingEvents},

            // Company Course plan set
            company_courses_allowed(){return this.$store.getters.getCompanyCoursesAllowed},
            company_courses_created(){return this.$store.getters.getCompanyCoursesCreated},
            company_remaining_courses(){return this.$store.getters.getCompanyRemainingCourses},
        },

    }
</script>

<style>

#over img {
  margin-left: auto;
  margin-right: auto;
  display: block;
  padding-top: 10%;
}

.blurred{
    filter:blur(4px);
    -o-filter:blur(4px);
    -ms-filter:blur(4px);
    -moz-filter:blur(4px);
    -webkit-filter:blur(4px);
}

.expired-badge{
    border: solid 1px red;
    margin: 1px;
    color: white;
    background-color: red;
    padding: 2px;
    font-size: 11px;
}

</style>


