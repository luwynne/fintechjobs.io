<template>

    <div id="page-wrapper" >
    <div id="page-inner">

        <div v-if="this.loading == true" id="over">
            <img :src="'/fintechjobs.io/public/admin/img/loading.gif'" width="100px">
        </div>

        <div v-else>
            <div class="row">
            <div class="col-lg-12">
                <h2>My job vacancies</h2>
                <!--  if(count($positions) > 0) { echo "";} else{ echo "No positions for the moment!"; -->

               <!-- <router-link v-if="this.company_remaining_jobs > 0" v-bind:to="{name: 'Create'}"><button type="button" class="btn btn-primary modal-primary">Create position</button></router-link> -->
                <button v-if="company_remaining_jobs > 0 && !company_is_plan_expired" @click="openJobCreateModal" type="button" class="btn btn-primary modal-primary" data-toggle="modal" data-target="#exampleModalLong" >Create position</button>
                <h3 v-else-if="company_is_plan_expired">Your plan is expired</h3>
                <h3 v-else>You have no job credits available</h3>

                <table v-if="jobs.length > 0" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Job</th>
                            <th>Created</th>
                            <th></th>
                        </tr>
                    </thead>
                     <tbody>
                         <tr v-for="job in jobs" :key="job.id" :job="job">
                            <td>{{job.name}}</td>
                            <td>{{moment(job.created_at).fromNow()}}</td>
                            <td style="text-align:center">
                                <i @click="openViewJobModal(job)"  style="font-size:20px" class="btn fa fa-eye"></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <h4 v-else>No vacancies for the moment!</h4>
        </div>
        <!-- endif -->
            </div>
        </div>


        </div>
        <Show v-if="viewJobModalVisible" :job="job" @updateFromChild="updateJob" @closeRequest='closeJobViewModal'></Show>
        <Create v-if="createJobModalVisible" @closeCreateRequest='closeJobCreateModal' @newJob='getNewJob'></Create>
    </div>

</template>

<script>

    import axios from 'axios';
    import moment from 'moment';
    import Show from './Show.vue';
    import Create from './Create.vue';

    export default {

        data(){
            return {
                jobs: [],
                job: {id:'', name:'', description:'', salary:'', location:'', experience_years:'', bonus:'', expiration:'', created_at:''},
                viewJobModalVisible: false,
                createJobModalVisible: false,
                newJob:'',
                loading: false,
            }
        },

        async created() {
            this.getJobs();
        },

        methods:{

            getJobs(){
                window.axios.get('http://localhost:8888/fintechjobs.io/public/api/vacancies').then( response => {
                    this.jobs = response.data
                }).catch(e => {
                    console.log(e);
                })
            },

            moment,

            openViewJobModal(job){
                this.job = job;
                this.viewJobModalVisible = true;
            },

            closeJobViewModal(){
                this.job = '';
                this.viewJobModalVisible = false;
            },

            openJobCreateModal(){
                this.createJobModalVisible = true;
            },

            closeJobCreateModal(){
                this.createJobModalVisible = false;
            },

            getNewJob(value){
                console.log(value);
                this.jobs.push(value);
                this.$store.dispatch("setNewjobCreated")
            },

            updateJob(value){
                let uri = 'http://localhost:8888/fintechjobs.io/public/api/job/editJob/'+value.id;
                axios.patch(uri, value).then((response) => {
                    this.job = value;
                    console.log(value);
                    console.log(response);
                }).catch((error) => {
                    console.log(error.response.data.errors);
                });
            }

        },

        mounted(){
            this.loading = true;
            setTimeout(() => {
                this.loading = false;
            }, 400);
        },

        computed:{
            company_remaining_jobs(){return this.$store.getters.getCompanyRemainingJobs},
            company_is_plan_expired(){return this.$store.getters.getCompanyIsPlanExpired},
        },

        components:{
            Show,
            Create
        }

    }
</script>
