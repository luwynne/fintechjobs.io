<template>
    <div  id="page-wrapper" >
        <div id="page-inner">
            <div v-if="this.loading == true" id="over">
                <img :src="'/fintechjobs.io/public/admin/img/loading.gif'" width="100px">
            </div>

            <div v-else>
                <div class="row">
                    <div class="col-lg-12">
                        <h2>My courses</h2>
                        
                        <button v-if="company_remaining_courses > 0 && !company_is_plan_expired" @click="openCourseCreateModal" type="button" class="btn btn-primary modal-primary" data-toggle="modal" data-target="#exampleModalLong" >Create course</button>
                        <h3 v-else-if="company_is_plan_expired">Your plan is expired</h3>
                        <h3 v-else>You have no course credits available</h3>

                        <table v-if="courses.length > 0" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Course</th>
                                <th>Created</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="course in courses" :key="course.id" :course="course">
                                <td>{{course.name}}</td>
                                <td>{{moment(course.created_at).fromNow()}}</td>
                                <td style="text-align:center">
                                    <i @click="openViewCourseModal(course)"  style="font-size:20px" class="btn fa fa-eye"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <h4 v-else>No courses for the moment!</h4>
                </div>
            </div>
        </div>
    </div>

    <Show v-if="viewCourseModalVisible" :course="course" @updateFromChild="updateCourse" @closeRequest='closeCourseViewModal'></Show>
    <Create v-if="createCourseModalVisible" @closeCreateRequest='closeCourseCreateModal' @newCourse='getNewCourse'></Create>

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
                courses:[],
                course: {id:'', institute_id:'', name:'', description:'', url:'', created_at:'', updated_at:''},
                loading: false,
                viewCourseModalVisible: false,
                createCourseModalVisible: false,
                hasErrors: false,
                error:''
            }
        },

        async created() {
            this.getCourses();
        },

        methods:{

            moment,

            openViewCourseModal(course){
                this.course = course;
                this.viewCourseModalVisible = true;
            },

            closeCourseViewModal(){
                this.course = '';
                this.viewCourseModalVisible = false;
            },

            openCourseCreateModal(){
                this.createCourseModalVisible = true;
            },

            closeCourseCreateModal(){
                this.createCourseModalVisible = false;
            },

            getNewCourse(value){
                console.log(value);
                this.courses.push(value);
                //this.$store.dispatch("setNewCourseCreated")
            },

            getCourses(){
                window.axios.get('http://localhost:8888/fintechjobs.io/public/api/courses').then( response => {
                    this.courses = response.data
                }).catch(e => {
                    console.log(e);
                })
            },

            updateCourse(value){
                let uri = 'http://localhost:8888/fintechjobs.io/public/api/course/editCourse/'+value.id;
                axios.patch(uri, value).then((response) => {
                    console.log();
                }).catch((error) => {
                    console.log(error);
                });
            }

        },

        mounted(){
            this.loading = true;
            this.courses_available = 
            setTimeout(() => {
                this.loading = false;
            }, 400);
        },

        computed:{
            company_remaining_courses(){return this.$store.getters.getCompanyRemainingCourses},
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