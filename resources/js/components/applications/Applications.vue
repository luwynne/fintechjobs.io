<template>
    <div id="page-wrapper" >
    <div id="page-inner">

        <div v-if="this.loading == true" id="over">
            <img :src="'/fintechjobs.io/public/admin/img/loading.gif'" width="100px">
        </div>

        <div v-else class="row">
            <div class="col-lg-12">
                <h2>Job applications</h2>
                <br>

                <table v-if="jobs.length > 0" class="table table-bordered">
                    <tbody>
                        <tr v-for="job in jobs" :key="job.id" :job="job">
                            <td class="td-margin-top">{{job.name}} <span v-if="job.applications.length > 0" class="badge badge-light">{{job.applications.length}}</span></td>
                            <td class="td-margin-top">{{moment(job.created_at).fromNow()}}</td>
                            <td class="td-margin-top" style="text-align:center">
                                <i v-if="job.applications.length > 0" @click="openApplicationsModal(job)"  style="font-size:20px" class="btn fa fa-eye"></i>
                                <i v-else style="font-size:20px" class="btn fa fa-ban"></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <h4 v-else>No applications a the moment!</h4>

            </div>
        <!-- endif -->
        </div>

        </div>
        <ApplicationsList v-if="viewApplicationsModalVisible" :job="job" @closeApplicationsRequest="closeApplicationModal"></ApplicationsList>
    </div>
</template>

<script>

    import ApplicationsList from './ApplicationsList.vue';
    import axios from 'axios';
    import moment from 'moment';
    export default {


        data(){

            return {
                loading: false,
                jobs: [],
                job: {id:'', name:'', description:'', salary:'', location:'', experience_years:'', bonus:'', expiration:'', created_at:''},
                viewApplicationsModalVisible: false,
            }

        },

        async created() {
            this.getJobs();
        },

        methods:{

            moment,

            getJobs(){
                window.axios.get('http://localhost:8888/fintechjobs.io/public/api/vacancies').then( response => {
                    this.jobs = response.data
                }).catch(e => {
                    console.log(e);
                })
            },

            openApplicationsModal(job){
                this.job = job;
                this.viewApplicationsModalVisible = true;
            },

            closeApplicationModal(){
                this.job = '';
                this.viewApplicationsModalVisible = false;
            }
        },

        mounted(){
            this.job = '';
            this.loading = true;
            setTimeout(() => {
                this.loading = false;
            }, 400);
        },

        components:{
            ApplicationsList
        }


    }
</script>

<style scoped>

.badge {
    font-size:12px!important;
    float: right!important;
    margin-top: 8px!important;
}

.td-margin-top{
    margin-top: 12px;
    line-height: 2.428571!important;
}

</style>


