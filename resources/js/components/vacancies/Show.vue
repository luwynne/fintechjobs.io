<template>
  <div class="modal-backdrop">
    <div class="modal-small">
      <header class="modal-header">
        <slot name="header">
          <h3>{{job.name}}</h3>
          <button v-if="this.editing == false" @click="editForm" type="button" class="btn btn-primary btn-edit">Edit</button>
          <button type="button" class="btn-close" @click="close">
            x
          </button>
        </slot>
      </header>
      <section class="modal-body">
        <slot name="body">
            <br>
            <label for="title">Title</label>

                    <label for="salary">Salary / Amount (k) per year (eg.:30, 40, 65)</label>
                    <input :disabled="editing == false" v-model="job.salary" type="number" name="salary"  class="form-control">

                    <label for="location">Location</label>
                    <input :disabled="editing == false" v-model="job.location" type="text" name="location" class="form-control" required>

                    <label for="experience">Years of experience eg.:1,2,4,5</label>
                    <input :disabled="editing == false" v-model="job.experience_years" type="number" name="experience_years" class="form-control" required>

                    <label for="benefits">Bonus - Benefits</label>
                    <input :disabled="editing == false" v-model="job.bonus" type="text" name="bonus" class="form-control">

                    <label for="description">Description / Job details</label>
                    <!-- <textarea :disabled="editing == false" v-model="job.description" rows="4" cols="50" name="description" class="form-control large"></textarea> -->
                    <vue-editor :disabled="editing == false" v-model="job.description"></vue-editor>
                    <br>
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
  export default {
    name: 'Show',

    props:['job'],

    data(){
        return{
            editing:false,
            hasErrors: false,
            error:''
        }
    },

    methods:{

      close(){
        this.$emit('closeRequest');
      },

      moment,

      editForm(){
          this.editing = true;
      },

      update(){
        if(this.job.salary <= 999){
          this.$emit('updateFromChild', this.job);
          this.close();
        }else{
          this.hasErrors = true;
          this.error = 'The salary must be between 0 and 999.'
        }
        
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
