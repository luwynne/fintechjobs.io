<template>
    <div class="modal-backdrop">
    <div class="modal">
      <header class="modal-header">
        <slot name="header">
          <h3>{{job.name}}</h3>

          <button v-if="application.name" type="button" class="btn-close" @click="back">
            <i class="fa fa-arrow-left"></i> Back
          </button>
          <button type="button" class="btn-close" @click="close">
            x
          </button>
        </slot>
      </header>
      <section class="modal-body">
          <div class="row">
              <div v-if="!application.name" class=" col-12 applications-list">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name &nbsp;
                                <i @click="changeSort('name')" class="fa fa-unsorted"></i>
                            </th>
                            <th>Email &nbsp;<i @click="changeSort('email')" class="fa fa-unsorted"></i></th>
                            <th>Date &nbsp;<i @click="changeSort('created_at')" class="fa fa-unsorted"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="application-row" v-for="application in job.applications" :key="application.id" :application="application" @click="getApplication(application)">
                            <td>{{application.name}}</td>
                            <td>{{application.email}}</td>
                            <td>{{moment(application.created_at).format('MMMM Do YYYY')}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-if="application.name" class="col-12 applicant">
                <small>Applied on {{moment(application.created_at).format('MMMM Do YYYY')}}</small>
                <h4 v-if="application.name">Name</h4><p>{{application.name}}</p>
                <h4 v-if="application.email">Email</h4><p>{{application.email}}</p>
                <h4 v-if="application.phone">Phone</h4><p>{{application.phone}}</p>
                <h4 v-if="application.linkedin">Linkedin</h4><p>{{application.linkedin}}</p>
                <h4 v-if="application.cover_letter">Coverletter</h4><p v-html="application.cover_letter"></p>
            </div>
          </div>
      </section>
      <footer class="modal-footer">
    </footer>
  </div>
</div>
</template>


<script>

import moment from 'moment';

export default {

    name: 'ApplicationsList',

    props:['job'],


    data(){
        return{
            application: {name:'', email: '', created_at:'', phone: '', linkedin: '', cover_letter: ''},
            sortBy:'',
            sortDirection:'',
        }
    },

    methods:{

        moment,

        close(){
            this.$emit('closeApplicationsRequest');
        },

        getApplication(application){
            this.application = application;
        },

        back(){
            this.application = '';
        },

        changeSort(sortBy) {

            if(this.sortDirection === ''){
                this.sortDirection = 'asc';
            }else{
                if(this.sortDirection === 'asc'){
                    this.sortDirection = 'desc';
                }else{
                    this.sortDirection = 'asc';
                }
            }

            this.job.applications = this.job.applications.slice()
                .sort((a, b) => {
                    if(a[sortBy] < b[sortBy]) return -1;
                    if(a[sortBy] > b[sortBy]) return 1;
                    return 0;
                });

            return this.sortDirection === "asc" ? this.job.applications
            : this.job.applications.reverse();
        }

    },


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

  .modal {
    background: #FFFFFF;
    box-shadow: 2px 2px 20px 1px;
    overflow-x: auto;
    display: flex;
    flex-direction: column;
    left: 0;
    margin-left: 15%px;
    position: fixed;
    width: 80%;
    height: 80%;
    top: 10%;
    overflow-y: auto;
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


.applicant{
    padding: 25px;
}

ul{
  list-style-type: none;
}

.application-row{
    cursor: pointer;
    transition: all 0.2s;
}

.application-row:hover{
    background-color: whitesmoke;
}

</style>
