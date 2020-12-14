<template>
    <div  id="page-wrapper" >
        <div id="page-inner">
            <div v-if="this.loading == true" id="over">
                <img :src="'/fintechjobs.io/public/admin/img/loading.gif'" width="100px">
            </div>

            <div v-else>
                <div class="row">
                    <div class="col-lg-12">
                        <h2>My events</h2>
                        
                        <button v-if="company_remaining_events > 0 && !company_is_plan_expired" @click="openEventCreateModal" type="button" class="btn btn-primary modal-primary" data-toggle="modal" data-target="#exampleModalLong" >Create event</button>
                        <h3 v-else-if="company_is_plan_expired">Your plan is expired</h3>
                        <h3 v-else>You have no event credits available</h3>

                        <table v-if="events.length > 0" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Event</th>
                                <th>Created</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="event in events" :key="event.id" :event="event">
                                <td>{{event.name}}</td>
                                <td>{{moment(event.created_at).fromNow()}}</td>
                                <td style="text-align:center">
                                    <i @click="openViewEventModal(event)"  style="font-size:20px" class="btn fa fa-eye"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <h4 v-else>No events for the moment!</h4>
                </div>
            </div>
        </div>
    </div>

    <Show v-if="viewEventModalVisible" :event="event" @updateFromChild="updateEvent" @closeRequest='closeEventViewModal'></Show>
    <Create v-if="createEventModalVisible" @closeCreateRequest='closeEventCreateModal' @newEvent='getNewEvent'></Create>

    </div>
</template>

<script>

    import axios from 'axios';
    import moment from 'moment';
    import Create from './Create.vue';
    import Show from './Show.vue';
    

    export default {

        data(){
            return {
                events:[],
                event: {id:'', name:'', description:'', start_date:'', end_date:'', address:'', city:'', country:'', fee:'', url:'', file_name:'', created_at:''},
                loading: false,
                viewEventModalVisible: false,
                createEventModalVisible: false,
                hasErrors: false,
                error:'',
            }
        },

        async created() {
            this.getEvents();
        },

        methods:{

            moment,

            openViewEventModal(event){
                this.event = event;
                this.viewEventModalVisible = true;
            },

            closeEventViewModal(){
                this.event = '';
                this.viewEventModalVisible = false;
            },

            openEventCreateModal(){
                this.createEventModalVisible = true;
            },

            closeEventCreateModal(){
                this.createEventModalVisible = false;
            },

            getNewEvent(value){
                console.log(value);
                this.events.push(value);
                this.$store.dispatch("setNewEventCreated")
            },

            getEvents(){
                window.axios.get('http://localhost:8888/fintechjobs.io/public/api/events').then( response => {
                    this.events = response.data
                }).catch(e => {
                    console.log(e);
                })
            },

            updateEvent(value){
                let uri = 'http://localhost:8888/fintechjobs.io/public/api/event/editEvent/'+value.id;
                axios.patch(uri, value).then((response) => {
                    console.log();
                }).catch((error) => {
                    console.log(error);
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
            company_remaining_events(){return this.$store.getters.getCompanyRemainingEvents},
            company_is_plan_expired(){return this.$store.getters.getCompanyIsPlanExpired},
        },

        components:{
            Create,
            Show
        }

    }
</script>

<style>


</style>