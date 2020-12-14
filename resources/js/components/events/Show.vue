<template>
  <div class="modal-backdrop">
    <div class="modal-small">
      <header class="modal-header">
        <slot name="header">
          <h3>{{event.name}}</h3>
          <button v-if="this.editing == false" @click="editForm" type="button" class="btn btn-primary btn-edit">Edit</button>
          <button type="button" class="btn-close" @click="close">
            x
          </button>
        </slot>
      </header>
      <section class="modal-body">
        <slot name="body">
            <br>

                    <label for="start_date">Start date and time</label><br>
                    <VueCtkDateTimePicker :disabled="editing == false" class="datepicker" v-model="event.start_date" name="start_date" />

                    <label for="end_date">End date and time</label><br>
                    <VueCtkDateTimePicker :disabled="editing == false" class="datepicker" v-model="event.end_date" name="end_date" />

                    <label for="address">Address</label>
                    <input :disabled="editing == false" v-model="event.address" type="text" name="address" class="form-control">

                     <label for="city">City</label>
                    <input :disabled="editing == false" v-model="event.city" type="text" name="city" class="form-control">

                    <label for="country">Country</label><br>
                      <div>
                          <select :disabled="editing == false" v-model="event.country_id" name="country_id">
                              <option v-for="country in countries" :key="country.id" :value="country.id">
                                  {{country.name}}
                              </option>
                          </select>
                          <br><br>
                      </div>

                     <label for="fee">Fee</label>
                    <input :disabled="editing == false" v-model="event.fee" type="text" name="fee" class="form-control">

                     <label for="url">URL</label>
                    <input :disabled="editing == false" v-model="event.url" type="text" name="url" class="form-control">

                    <label for="description">Description</label>
                    <vue-editor v-model="event.description" name="description"></vue-editor>
                    <br>

                    <div v-if="img_hidden == true && editing == true">
                         <h4><a @click="getEventFileName(event.id)">Event image</a></h4>
                         <br><br>
                    </div>

                    <div v-if="img_hidden == false">
                        <label for="image">Event cover image<br><small>This image will be displayed on the Event page</small></label><br>
                        <div class="upload-btn-wrapper">
                            <button :disabled="editing == false" class="btn-upload">Upload a file</button>
                            <input type="file" name="image" accept="image/jpeg/png" v-on:change="onImageChange" >
                        </div>
                         <div v-if="img_hidden == false">
                          <img v-if="this.image != ''" :src="this.image" class="img-responsive uploading-image" height="70" width="90">
                          <img v-else :src="'http://localhost:8888/fintechjobs.io/public/admin/img/events/'+this.file_name" class="img-responsive uploading-image" height="70" width="90">
                        </div>
                        <br><br>
                    </div>  

                    <input v-if="editing == true" type="button" class="btn btn-primary" @click="update" value="Save">
                    <div v-if="this.hasErrors">
                        <br>
                        <p class="danger">{{this.error}}</p>
                    </div>
        </slot>
      </section>
      <footer class="modal-footer">
    </footer>
  </div>
</div>
</template>

<script>

import { VueEditor } from "vue2-editor";
import moment from 'moment';
import VueCtkDateTimePicker from 'vue-ctk-date-time-picker';
import 'vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css';

  export default {
    name: 'Show',

    props:['event'],

    data(){
        return{
            image:'',
            editing:false,
            hasErrors: false,
            error:'',
            file_name: '',
            img_hidden: true,
            countries:{},
        }
    },

    methods:{

    getCountries(){
        window.axios.get('http://localhost:8888/fintechjobs.io/public/api/countries').then((response) =>{
          this.countries = response.data;
        })
      },

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
                vm.event.image = e.target.result;
            };
            reader.readAsDataURL(file);
      },    

      close(){
        this.$emit('closeRequest');
      },

      moment,

      editForm(){
          this.editing = true;
      },

      update(){
        this.$emit('updateFromChild', this.event);
        this.close();
      },

      getEventFileName(event_id){
          window.axios.get('http://localhost:8888/fintechjobs.io/public/api/event/file_name/'+event_id).then( response => {
                this.file_name = response.data
                this.img_hidden = false;
            }).catch(e => {
                console.log(e);
            })
      }

    },

    mounted(){
      this.getCountries();        
    },

    components: {
        VueEditor,
        VueCtkDateTimePicker
    }

  }
</script>

<style>
  .modal-backdrop {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: rgba(0, 0, 0, 0.3);
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .modal-small{
    background: #FFFFFF;
    box-shadow: 2px 2px 20px 1px;
    overflow-x: auto;
    display: flex;
    flex-direction: column;
    margin-left: 15%px;
    position: fixed;
    width: 57%;
    height: 80%;
    top: 10%;
    overflow-y: auto;
    /* border: 1px black solid; */
    border-radius: 10px;
    padding: 10px;
    margin-left: auto;
    margin-right: auto;
  }

  .modal-header,
  .modal-footer {
    padding: 15px;
    display: flex;
    border: none!important;
  }

  .modal-header {
    /* border-bottom: 1px solid #eeeeee; */
    color: #214761;
    justify-content: space-between;
  }

  .modal-footer {
    /* border-top: 1px solid #eeeeee; */
    justify-content: flex-end;
  }

  .modal-body {
    position: relative;
    padding: 20px 20px;
    position: relative;
    padding: 20px 10px;
    margin-top: 30px;
    margin-left: 7px;
  }

  .btn-close {
    border: none;
    font-size: 20px;
    padding: 18px;
    cursor: pointer;
    font-weight: bold;
    color: #214761;
    background: transparent;
  }

  .btn-edit{
    padding: 15px;
    margin-top: 21px;
    /* margin-left: 65%; */
    margin-right: -30%;
    padding-bottom: 23px;
    padding-top: 5px;
  }

  .btn-green {
    color: white;
    background: #4AAE9B;
    border: 1px solid #4AAE9B;
    border-radius: 2px;
  }




</style>
