<template>
  <div class="modal-backdrop">
    
    <div class="modal-small" v-bind:class="{faded: loading}">
      <header class="modal-header">
        <slot name="header">
          <h3>Create new position</h3>
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
                    <label for="title">Job Title <br><small>(Do not use special carachters. E.g. ()^% /-_*</small></label>
                    <input v-model="job.name" type="text" name="name" class="form-control" required>

                    <label for="salary">Salary / Amount (k) per year (eg.:30, 40, 65)</label>
                    <input v-model="job.salary" type="number" name="salary"  class="form-control">

                    <label for="location">Location</label>
                    <input v-model="job.location" type="text" name="location" class="form-control" required>

                    <label for="experience">Years of experience eg.:1,2,4,5</label>
                    <input v-model="job.experience_years" type="number" name="experience_years" class="form-control" required>

                    <label for="benefits">Bonus - Benefits</label>
                    <input v-model="job.bonus" type="text" name="bonus" class="form-control">

                    <label for="description">Description / Job details</label>
                    <!-- <textarea v-model="job.description" rows="4" cols="50" name="description" class="form-control large"></textarea> -->
                    <vue-editor v-model="job.description"></vue-editor>
                    <br>

                    <input @click="saveJob" type="button" class="btn btn-primary" value="Save">
              
                    <div v-if="this.hasErrors">
                        <br>
                        <p class="danger">{{this.errors.name}}</p>
                        <p class="danger">{{this.errors.description}}</p>
                        <p class="danger">{{this.errors.salary}}</p>
                        <p class="danger">{{this.errors.location}}</p>
                        <p class="danger">{{this.errors.experience_years}}</p>
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
  export default {
    name: 'Create',

    data(){
        return{
            hasErrors: false,
            errors: {name: '', description:'', salary:'', location:'', experience_years:''},
            jobs: [],
            job: {id:'', name:'', description:'', salary:'', location:'', experience_years:'', bonus:'', expiration:'', created_at:''},
            loading: false,
        }
    },

    methods:{

      close(){
        this.$emit('closeCreateRequest');
      },

      createNewJob(job){
          this.$emit('newJob', job);
          this.$emit('closeCreateRequest');
      },

      moment,

      saveJob(){
          this.loading = true;
          axios.post('http://localhost:8888/fintechjobs.io/public/api/job/createJob',this.job).then((response) => {
              this.createNewJob(this.job);
              this.loading = false;
        }).catch((error) => {
                this.loading = false;
                this.hasErrors = true;
                this.errors.name = error.response.data.errors.name ? error.response.data.errors.name[0] : '';
                this.errors.description = error.response.data.errors.description ? error.response.data.errors.description[0] : '';
                this.errors.salary = error.response.data.errors.salary ? error.response.data.errors.salary[0] : '';
                this.errors.location = error.response.data.errors.location ? error.response.data.errors.location[0] : '';
                this.errors.experience_years = error.response.data.errors.experience_years ? error.response.data.errors.experience_years[0] : '';
            }
        );

      }

    },
    components: {
        VueEditor
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


</style>
