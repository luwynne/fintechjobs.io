<template>
    <div id="page-wrapper" >
    <div id="page-inner">

        <div v-if="this.loading == true" id="over">
            <img :src="'/fintechjobs.io/public/admin/img/loading.gif'" width="100px">
        </div>

        <div v-else class="row">
            <div v-if="this.canAddUser === true" class="col-lg-12">
                <h2>Invite new user</h2>
                <br>
                <form action="" @submit="inviteUser">
                    <input v-model="email.email" type="text" name="email" placeholder="New user email" style="width:70%;" class="form-control">
                    <button type="submit" v-bind:class="[sendingEmailLoading? 'disabled': '']" class="btn btn-large btn-info">Invite</button>
                    <img v-if="sendingEmailLoading" :src="'/fintechjobs.io/public/admin/img/loading.gif'" alt="Loading" width="25px">
                </form>
            </div>

            <div v-else class="col-lg-12">
                <div class="alert alert-info">You have no more users permission</div>
            </div>

            <div class="col-lg-12">
                <hr>
            <h4>Company users</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th style="text-align:center;">Role</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in users" :key="user.id" :user="user">
                            <td>{{user.name}}</td>
                            <td>{{user.email}}</td>
                            <td v-if="user.role === 'admin' && user.email === company_rep.email" style="text-align:center;">Admin</td>
                            <td v-else style="text-align:center;">
                                <select v-model="user.role" @change="updateUserRole($event, user)" name="role" id="role">
                                    <option v-bind:value="user.role" selected>{{ user.role | capitalize }}</option>
                                    <option v-bind:value="user.role === 'admin' ? 'user' : 'admin' ">{{user.role === 'admin' ? 'User' : 'Admin' }}</option>
                                </select>
                            </td>
                            <td style="text-align:center;">
                                <i @click="deleteUser(user)" v-if="user.email !== company_rep.email" style="display:inline;" class="fa fa-trash-o" aria-hidden="true"></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <UserInvitedResponse v-if="openResponseModal" :response="response" @closeInviteRequest='closeResponseModal'></UserInvitedResponse>
        </div>
        <!-- /. ROW  -->
    </div>
</div>
    <!-- /. PAGE INNER  -->
</template>

<script>

    import axios from 'axios';
    import moment from 'moment';
    import UserInvitedResponse from './UserInviteResponse.vue';

    export default {

        data(){
            return {
                loading: false,
                canAddUser: '',
                user:{id:'', name:'', email:'', role:''},
                users: [],
                email:{email:''},
                response:'',
                error:'',
                openResponseModal: false,
                sendingEmailLoading: false
            }
        },

        async created() {
            this.getCompanyUsers();
        },

        methods:{

            inviteUser(e){
                e.preventDefault();
                if(this.validEmail(this.email.email)){
                    this.sendingEmailLoading = true;
                    axios.post('http://localhost:8888/fintechjobs.io/public/api/new-user', this.email).then((response) => {
                        this.response = response.data.message;
                        this.openResponseModal = true;
                        this.sendingEmailLoading = false;
                    }).catch((error) => {
                            this.response = error.response.data.errors.email[0];
                            this.openResponseModal = true;
                        }
                    );
                }
            },

            validEmail: function (email) {
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            },

            closeResponseModal(){
                this.email.email = '';
                this.openResponseModal = false;
                this.response = '';
            },

            getCompanyUsers(){
                window.axios.get('http://localhost:8888/fintechjobs.io/public/api/users').then((response) =>{
                    this.canAddUser = response.data.canAddUser;
                    this.users = response.data.company_users;
                })
            },

            updateUserRole($event, user){
                axios.patch('http://localhost:8888/fintechjobs.io/public/api/user/change_user_role/'+user.id, user).then((response) => {
                        this.response = 'User role has been updated';
                        this.openResponseModal = true;
                    }).catch((error) => {
                            this.response = 'User could not be updated';
                        }
                    );
            },

            deleteUser(user){
                if(confirm("Are you sure you want o delete this user?")){
                    axios.delete('http://localhost:8888/fintechjobs.io/public/api/user/delete_company_user/'+user.id).then((response) => {
                        this.users.splice(this.users.indexOf(user), 1);
                        this.response = 'User has been deleted';
                        this.openResponseModal = true;

                    }).catch((error) => {
                        this.response = 'User could not be deleted';
                    })
                }
            },


        },

        mounted(){
            this.loading = true;
            setTimeout(() => {
                this.loading = false;
            }, 400);
        },

        computed: { 
            company_rep(){return this.$store.getters.getCompanyRep}
        },

        components:{
            UserInvitedResponse
        }


    }
</script>

<style>

.fa-trash-o{
    font-size: 20px;
    transition: all .2s;
}

.fa-trash-o:hover{
    color:steelblue;
}

</style>
