<template>
  <div class="modal-backdrop">
    
    <div class="modal-small" v-bind:class="{faded: loading}">
      <header class="modal-header">
        <slot name="header">
          <h3>Create new event</h3>

          
          <div v-if="this.loading == true" class="backdrop-loading" id="over">
              <img :src="'/fintechjobs.io/public/admin/img/loading.gif'" width="50px">
          </div>
          <button type="button" class="btn-close" @click="close">
            x
          </button>
        </slot>
      </header>
      <section class="modal-body">
        <slot name="body">
                    <label for="name">Event Title<br><small>Do not use special carachters. E.g. ()^% /-_*</small></label>
                    <input v-model="event.name" type="text" name="name" class="form-control">

                    <label for="start_date">Start date and time</label><br>
                    <VueCtkDateTimePicker class="datepicker" v-model="event.start_date" name="start_date" />

                    <label for="end_date">End date and time</label><br>
                    <VueCtkDateTimePicker class="datepicker" v-model="event.end_date" name="end_date" />

                    <label for="address">Address</label>
                    <input v-model="event.address" type="text" name="address" class="form-control">

                     <label for="city">City</label>
                    <input v-model="event.city" type="text" name="city" class="form-control">

                      <label for="country">Country</label><br>
                      <div>
                          <select v-model="event.country_id" name="country_id">
                              <option v-for="country in countries" :key="country.id" :value="country.id">
                                  {{country.name}}
                              </option>
                          </select>
                          <br><br>
                      </div>

                     <label for="fee">Fee</label>
                    <input v-model="event.fee" type="text" name="fee" class="form-control">

                     <label for="url">URL</label>
                    <input v-model="event.url" type="text" name="url" class="form-control">

                     <label for="image">Event cover image<br><small>This image will be displayed on the Event page</small></label><br>
                    <div class="upload-btn-wrapper">
                        <button class="btn-upload">Upload a file</button>
                        <input type="file" name="image" accept="image/jpeg/png" v-on:change="onImageChange" >
                    </div>

                    <div>
                        <img v-if="this.image != ''" :src="this.image" class="img-responsive uploading-image" height="70" width="90">
                    </div>

                    <label for="description">Description</label>
                    <vue-editor v-model="event.description" name="description"></vue-editor>
                    <br>

                    <input @click="saveEvent" type="button" class="btn btn-primary" value="Save">
              
                    <div v-if="this.hasErrors">
                        <br>
                        <p class="danger">{{this.errors.name}}</p>
                        <p class="danger">{{this.errors.start_date}}</p>
                        <p class="danger">{{this.errors.end_date}}</p>
                        <p class="danger">{{this.errors.address}}</p>
                        <p class="danger">{{this.errors.city}}</p>
                        <p class="danger">{{this.errors.country}}</p>
                        <p class="danger">{{this.errors.url}}</p>
                        <p class="danger">{{this.errors.image}}</p>
                        <p class="danger">{{this.errors.description}}</p>
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
    name: 'Create',

    data(){
        return{
            hasErrors: false,
            errors: {name:'', description:'', start_date:'', end_date:'', address:'', city:'', country_id:'', fee:'', url:'', image:''},
            event: {id:'', name:'', description:'', start_date:'', end_date:'', address:'', city:'', country_id:'', fee:'', url:'', image:''},
            loading: false,
            image:'',
            countries:{},
        }
    },

    methods:{

      getCountries(){
        window.axios.get('http://localhost:8888/fintechjobs.io/public/api/countries').then((response) =>{
          this.countries = response.data;
        })
      },

      close(){
        this.$emit('closeCreateRequest');
      },

      createNewEvent(event){
          this.$emit('newEvent', event);
          this.$emit('closeCreateRequest');
      },

      moment,

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

      saveEvent(){
          this.loading = true;
          axios.post('http://localhost:8888/fintechjobs.io/public/api/event/createEvent',this.event).then((response) => {
              this.event.id = response.data.id;
              this.createNewEvent(this.event);
              this.loading = false;
        }).catch((error) => {
                this.loading = false;
                this.hasErrors = true;
                this.errors.name = error.response.data.errors.name ? error.response.data.errors.name[0] : '';
                this.errors.description = error.response.data.errors.description ? error.response.data.errors.description[0] : '';
                this.errors.start_date = error.response.data.errors.start_date ? 'Start Date is invalid' : '';
                this.errors.end_date = error.response.data.errors.end_date ? 'End Date is invalid' : '';
                this.errors.address = error.response.data.errors.address ? error.response.data.errors.address[0] : '';
                this.errors.city = error.response.data.errors.city ? error.response.data.errors.city[0] : '';
                this.errors.country = error.response.data.errors.country ? error.response.data.errors.country[0] : '';
                this.errors.fee = error.response.data.errors.fee ? error.response.data.errors.fee[0] : '';
                this.errors.url = error.response.data.errors.url ? error.response.data.errors.url[0] : '';
                this.errors.image = error.response.data.errors.image ? error.response.data.errors.image[0] : '';

            }
        );

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

  .btn-green {
    color: white;
    background: #4AAE9B;
    border: 1px solid #4AAE9B;
    border-radius: 2px;
  }

  .danger{
      color: red!important;
  }

  .backdrop-loading{
    z-index: 0;
    position: fixed;
    padding-left: 24%;
    top: 79%;
  }

  .faded label, .faded input[type=text], .faded h3, .faded .ql-editor{
        color: lightgrey!important;
  }

  .datepicker .field {
    line-height: 10px!important;
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
