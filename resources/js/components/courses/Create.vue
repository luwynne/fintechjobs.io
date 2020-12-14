<template>
  <div class="modal-backdrop">
    
    <div class="modal-small" v-bind:class="{faded: loading}">
      <header class="modal-header">
        <slot name="header">
          <h3>Create new course</h3>

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
                    <label for="name">Course Title<br></label>
                    <input v-model="course.name" type="text" name="name" class="form-control">

                    <label for="url">URL</label>
                    <input v-model="course.url" type="text" name="url" class="form-control">

                    <label for="description">Description</label>
                    <vue-editor v-model="course.description" name="description"></vue-editor>
                    <br>

                    <input @click="saveCourse" type="button" class="btn btn-primary" value="Save">
              
                    <div v-if="this.hasErrors">
                        <br>
                        <p class="danger">{{this.errors.name}}</p>
                        <p class="danger">{{this.errors.description}}</p>
                        <p class="danger">{{this.errors.url}}</p>
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
            errors: {name:'', description:'', url:''},
            course: {id:'', institution_id:'', name:'', description:'', url:'', created_at:'', updated_at:''},
            loading: false,
        }
    },

    methods:{

      close(){
        this.$emit('closeCreateRequest');
      },

      createNewCourse(course){
          this.$emit('newCourse', course);
          this.$store.dispatch("setNewCourseCreated")
          this.$emit('closeCreateRequest');
      },

      moment,

      saveCourse(){
          this.loading = true;
          axios.post('http://localhost:8888/fintechjobs.io/public/api/course/createCourse',this.course).then((response) => {
              this.course.id = response.data.id;
              this.createNewCourse(this.course);
              this.loading = false;
        }).catch((error) => {
                this.loading = false;
                this.hasErrors = true;
                this.errors.name = error.response.data.errors.name ? error.response.data.errors.name[0] : '';
                this.errors.description = error.response.data.errors.description ? error.response.data.errors.description[0] : '';
                this.errors.url = error.response.data.errors.url ? 'URL is invalid' : '';

            }
        );

      }

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
