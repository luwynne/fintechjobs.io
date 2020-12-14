<template>
        <div  id="page-wrapper" >
        <div id="page-inner">
            <div v-if="this.loading == true" id="over">
                <img :src="'/fintechjobs.io/public/admin/img/loading.gif'" width="100px">
            </div>

            <div v-else>
                <div class="row">
                <div class="col-lg-12">
                    <h2>Company information</h2>
                    <small>Click on the page to edit</small>
                    <br /><br />
                </div>

            <div v-if="this.company !== '' && this.company_sectors !== ''" class="col-lg-12 info-field" @click="enableEditing">

                <label for="name">Name</label>
                <p v-if="editing == false">{{this.company.name}}</p>
                <input v-else v-model="company.name" type="text" name="name"  class="form-control">

                <div v-if="this.sector_id !== 22">
                    <label for="sector">Sector</label><br>
                    <p v-if="editing == false" >{{this.sector_name}}</p>
                    <div v-else >
                        <select v-model="company.sector_id" name="sector">
                            <option v-for="company_sector in company_sectors" :key="company_sector.id" :value="company_sector.id">
                                {{company_sector.name}}
                            </option>
                        </select>
                        <br><br>
                    </div>
                </div>
                

                <label for="address">Address</label>
                <p v-if="editing == false">{{this.company.address}}</p>
                <input v-else v-model="company.address" type="text" name="address" class="form-control">

                <label for="phone">Phone</label>
                <p v-if="editing == false">{{this.company.phone}}</p>
                <input v-else v-model="company.phone" type="text" name="phone" class="form-control">

                <label for="website">Website</label>
                <p v-if="editing == false">{{this.company.website}}</p>
                <input v-else v-model="company.website" type="text" name="website" class="form-control">

                <div v-if="company_social_media_allowed == true">
                    <label v-if="(this.company.facebook.url && this.company.facebook.url.length > 0) || editing == true" for="website">Facebook profile</label>
                    <p v-if="editing == false">{{this.company.facebook.url}}</p>
                    <input v-else v-model="company.facebook.url" type="text" name="facebook" class="form-control">

                    <label v-if="(this.company.linkedin.url && this.company.linkedin.url.length > 0) || editing == true" for="website">LinkedIn profile</label>
                    <p v-if="editing == false ">{{this.company.linkedin.url}}</p>
                    <input v-else v-model="company.linkedin.url" type="text" name="linkedin" class="form-control">

                    <label v-if="(this.company.twitter.url && this.company.twitter.url.length > 0) || editing == true" for="website">Twitter profile</label>
                    <p v-if="editing == false">{{this.company.twitter.url}}</p>
                    <input v-else v-model="company.twitter.url" type="text" name="twitter" class="form-control">
                </div>


                <label v-if="(this.company.description.content !== null && this.company.description.content.length > 8) || editing == true" for="description">Description</label>
                <p v-if="editing == false" v-html="this.company.description.content"></p>
                <vue-editor v-else name="description" v-model="company.description.content"></vue-editor>

                <br>
                <input v-if="editing == true" type="button" class="btn btn-primary" @click="updateCompany" value="Save">

                <div v-if="this.hasErrors">
                    <br>
                    <p class="danger">{{this.error}}</p>
                </div>

            </div>
        </div>
        <!-- /. ROW  -->
            </div>
    </div>
</div>

</template>

<script>

    import axios from 'axios';
    import moment from 'moment';

    export default {

        data(){
            return {
                company : '',
                company_sectors:'',
                loading: false,
                editing:false,
                hasErrors: false,
                error:'',
                sector_name:'',
                sector_id:''
            }
        },

        methods:{

            getCompanyInfo(){
                window.axios.get('http://localhost:8888/fintechjobs.io/public/api/company_info').then((response) =>{
                    this.company = response.data.company;
                    this.sector_name = this.company.sector.name;
                    this.sector_id = this.company.sector.id;
                    this.company_social_medias = response.data.company_social_medias;
                })
            },

            getCompanySectors(){
                window.axios.get('http://localhost:8888/fintechjobs.io/public/api/company_sectors').then((response) =>{
                    this.company_sectors = response.data;
                })
            },

            enableEditing(){
                this.editing = true;
            },

            updateCompany(sector_name){
                let uri = 'http://localhost:8888/fintechjobs.io/api/company/'+this.company.id;
                axios.patch(uri, this.company).then((response) => {
                    this.sector_name = response.data.sector.name;
                    this.editing = false;
                }).catch((error) => {
                    console.log(error.response);
                });
            }

        },

        mounted(){
            this.loading = true;
            this.getCompanyInfo();
            this.getCompanySectors();
            setTimeout(() => {
                this.loading = false;
            }, 400);
        },

        computed: { 
            company_social_media_allowed(){return this.$store.getters.getCompanySocialMediaAllowed},
        },

    }
</script>

<style>
.info-field{
    cursor: pointer;
}

label{
    font-weight: 600!important;
}

</style>