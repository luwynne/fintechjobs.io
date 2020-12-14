<template>
    <div  id="page-wrapper" >
        <div id="page-inner">
            <div v-if="this.loading == true" id="over">
                <img :src="'/fintechjobs.io/public/admin/img/loading.gif'" width="100px">
            </div>

            <div v-else>
                <div class="row">
                <div class="col-lg-12">
                    <h2>Company assets</h2>
                    <br />

                    <label for="logo"><h4>Logo</h4></label><br>
                    <div class="upload-btn-wrapper">
						<button class="btn-upload">Upload a file</button>
						<input name="logo" type="file" accept="image/jpeg/png" v-on:change="onImageChange" />
					</div>
                    <br>

                    <div>
                        <img v-if="this.image != ''" :src="this.image" class="img-responsive uploading-image" height="70" width="90">
                    </div>
                    
                    <br>

                    <div v-if="company_video_allowed == true"> 
                        <label for="logo"><h4>Video</h4></label><br>
                        <small>Vimeo video ID</small>
                        <div>
                            <input class="form-control" type="text" name="vimeo_video" v-model="external_id" placeholder="Paste here you Vimeo video ID">
                        </div>
                        <vimeo-player v-if="this.external_id !== ''" :video-id="this.external_id"></vimeo-player>
                        <p v-else>No videos loaded...</p>
                    </div>

                    <br>
                    <input @click="saveCompanyAssets" type="button" class="btn btn-primary" value="Save">
                </div>

                <div v-if="this.hasErrors">
                    <br>
                    <p class="danger">{{this.error}}</p>
                </div>

            <AssetsUpdateResponse v-if="openResponseModal" :response="response" @closeAssetsUpdateRequest='closeResponseModal'></AssetsUpdateResponse>
        </div>
        <!-- /. ROW  -->
            </div>
    </div>
</div>
</template>
    
<script>

import { vueVimeoPlayer } from 'vue-vimeo-player'
import AssetsUpdateResponse from './AssetsUpdateResponse.vue';
export default {

    data(){
        return{
           loading: false,
            error:'' ,
            hasErrors: false,
            image:'',
            company_logo:'',
            //company_vimeo_video:{external_id:''},
            external_id:'',
            updateVideo:false,
            openResponseModal:false
        }
    },

    methods:{

        onImageChange(e) {
            let files = e.target.files || e.dataTransfer.files;
            if (!files.length)
                return;
            this.createImage(files[0]);
        },

        createImage(file) {
            let reader = new FileReader();
            let vm = this;
            reader.onload = (e) => {
                vm.image = e.target.result;
            };
            reader.readAsDataURL(file);
            this.updateVideo = true;
        },

        getCompanyLogo(){
            window.axios.get('http://localhost:8888/fintechjobs.io/public/api/company_logo').then((response) =>{
                this.company_logo = response.data;
                if(this.company_logo !== ''){
                    this.image = this.company_logo.full_path;
                }
            })
        },

        getCompanyVimeoVideo(){
            window.axios.get('http://localhost:8888/fintechjobs.io/public/api/company_vimeo_video').then((response) =>{
                this.external_id = response.data.external_id;
            })
        },

        saveImage(){
            axios.post('http://localhost:8888/fintechjobs.io/public/api/company/save_logo',{image: this.image}).then(response => {
                console.log(response);
            })
        }, 
        
        saveVimeoVideo(){
            axios.post('http://localhost:8888/fintechjobs.io/public/api/company/save_vimeo_video',{external_id: this.external_id}).then(response => {
                this.openResponseModal = true; 
            })
        },

        saveCompanyAssets(){
            if(this.updateVideo == true){
                this.saveImage();
            }
            this.saveVimeoVideo();
        },
        
        closeResponseModal(){   
            this.openResponseModal = false; 
        },
    },

    mounted(){
        this.loading = true;
        this.getCompanyLogo();
        this.getCompanyVimeoVideo();
        setTimeout(() => {
            this.loading = false;
        }, 400);
    },

    computed: { 
        company_video_allowed(){return this.$store.getters.getCompanyVideoAllowed},
    },

    components: { 
        vueVimeoPlayer,
        AssetsUpdateResponse
    }
    
}
</script>

<style lang="css">

.logo-upload-class {
    position: relative;
}
 .logo-input{
    position: absolute;
    font-size: 30px!important;
    opacity: 0;
    right: 0;
    top: 0;
}

.uploading-image{
    max-width: 80px;
    padding-top: 10px 
}

.input-logo-file-name{
    padding-left: 20px;
}

#vimeo-video-input-field{
    max-width: 642px;
}

.upload-btn-wrapper {
  position: relative;
  overflow: hidden;
  display: inline-block;
}

.btn-upload {
  border: 2px solid gray;
    color: gray;
    background-color: white;
    padding: 3px 10px;
    border-radius: 8px;
    font-size: 15px;
    font-weight: bold;
}

input[type=file]{
  font-size: 100px;
    position: absolute;
    left: 0;
    top: 0;
    opacity: 0;
}

</style>