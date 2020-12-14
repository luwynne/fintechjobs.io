
import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

export default new Vuex.Store({
  
   state: {
      company:{'name':''},
      company_plan: {'id':'', 'name':''},
      company_is_plan_expired: false,
      
      company_jobs_allowed:0,
      company_jobs_created: 0,
      company_remaining_jobs: 0,
      
      company_social_media_allowed: false,
      company_video_allowed: false,
      company_rep: {'id':'', 'name':'', 'email':'', 'role':'', 'provider':null, 'provider_id':null},
      company_logged_user: {'id':'', 'name':'', 'email':'', 'role':'', 'provider':null, 'provider_id':null},
      
      company_events_allowed:0,
      company_events_created: 0,
      company_remaining_events: 0,
      
      company_courses_allowed:0,
      company_courses_created: 0,
      company_remaining_courses: 0,
  },

  getters: {

      getCompanyName(state){ //take parameter state
         return state.company.name;
      },   
   
      getCompanyPlan(state){ //take parameter state
         return state.company_plan;
      },

      getCompanyIsPlanExpired(state){ //take parameter state
         return state.company_is_plan_expired;
      },
      
      getCompanyJobsAllowed(state){ //take parameter state
         return state.company_jobs_allowed;
      },
   
      getCompanyJobsCreated(state){ //take parameter state
         return state.company_jobs_created;
      },

      getCompanyRemainingJobs(state){ //take parameter state
         return state.company_remaining_jobs;
      },

      getCompanySocialMediaAllowed(state){ //take parameter state
         return state.company_social_media_allowed;
      },

      getCompanyVideoAllowed(state){ //take parameter state
         return state.company_video_allowed;
      },

      getCompanyRep(state){ //take parameter state
         return state.company_rep;
      },

      getCompanyLoggedUser(state){ //take parameter state
         return state.company_logged_user;
      },

      getCompanyEventsAllowed(state){ //take parameter state
         return state.company_events_allowed;
      },

      getCompanyEventsCreated(state){ //take parameter state
         return state.company_events_created;
      },

      getCompanyRemainingEvents(state){ //take parameter state
         return state.company_remaining_events;
      },

      getCompanyCoursesAllowed(state){ //take parameter state
         return state.company_courses_allowed;
      },

      getCompanyCoursesCreated(state){ //take parameter state
         return state.company_courses_created;
      },

      getCompanyRemainingCourses(state){ //take parameter state
         return state.company_remaining_courses;
      },

  },

  actions: {
      
      setCompanyInfo(context,payload){
         window.axios.get('http://localhost:8888/fintechjobs.io/public/api/company_info').then((response) =>{
            context.commit('setCompanyName', response.data.company.name)   
            context.commit('setCompanyPlan', response.data.company_plan)
            context.commit('setCompanyIsPlanExpired', response.data.company_isPlanExpired)
            context.commit('setCompanyJobsAllowed', response.data.company_jobsAllowance)
            context.commit('setCompanyJobsCreated', response.data.company_jobs_created)
            context.commit('setCompanyRemainingJobs', response.data.company_remaining_jobs)
            context.commit('setCompanySocialMediaAllowed', response.data.company_social_media_allowed)
            context.commit('setCompanyVideoAllowed', response.data.company_video_allowed)
            context.commit('setCompanyRep', response.data.company_rep)
            context.commit('setCompanyEventsAllowed', response.data.company_eventsAllowance)
            context.commit('setCompanyEventsCreated', response.data.company_events_created)
            context.commit('setCompanyRemainingEvents', response.data.company_remaining_events)
            context.commit('setCompanyCoursesAllowed', response.data.company_coursesAllowance)
            context.commit('setCompanyCoursesCreated', response.data.company_courses_created)
            context.commit('setCompanyRemainingCourses', response.data.company_remaining_courses)
         })
      },
      
      setCompannedLoggedUser(context,payload){
         window.axios.get('http://localhost:8888/fintechjobs.io/public/api/logged_user').then((response) =>{
            context.commit('setCompanyLoggedUser', response.data)
        })
      },

      setNewjobCreated(context,payload){
         context.commit('setNewjobCreated')
      },

      setNewEventCreated(context,payload){
         context.commit('setNewEventCreated')
      },

      setNewCourseCreated(context,payload){
         context.commit('setNewCourseCreated')
      }

  },

  mutations: {

      setCompanyName: (state,payload) => {
         state.company.name = payload
      },   
      
      setCompanyPlan: (state,payload) => {
         state.company_plan = payload
      },

      setCompanyIsPlanExpired : (state,payload) => {
         state.company_is_plan_expired = payload
      },

      setCompanyJobsAllowed : (state,payload) => {
         state.company_jobs_allowed = payload
      },

      setCompanyJobsCreated : (state,payload) => {
         state.company_jobs_created = payload
      },

      setCompanyRemainingJobs : (state,payload) => {
         state.company_remaining_jobs = payload
      },

      setCompanySocialMediaAllowed : (state,payload) => {
         state.company_social_media_allowed = payload
      },

      setCompanyVideoAllowed : (state,payload) => {
         state.company_video_allowed = payload
      },

      setCompanyRep : (state,payload) => {
         state.company_rep = payload
      },

      setCompanyLoggedUser : (state,payload) => {
         state.company_logged_user = payload
      },

      setNewjobCreated: (state) => {
         state.company_jobs_created ++;
         state.company_remaining_jobs --;
      },

      setCompanyEventsAllowed : (state,payload) => {
         state.company_events_allowed = payload
      },

      setCompanyEventsCreated : (state,payload) => {
         state.company_events_created = payload
      },

      setCompanyRemainingEvents : (state,payload) => {
         state.company_remaining_events = payload
      },

      setNewEventCreated: (state) => {
         state.company_events_created ++;
         state.company_remaining_events --;
      },

      setCompanyCoursesAllowed : (state,payload) => {
         state.company_courses_allowed = payload
      },

      setCompanyCoursesCreated : (state,payload) => {
         state.company_courses_created = payload
      },

      setCompanyRemainingCourses : (state,payload) => {
         state.company_remaining_courses = payload
      },

      setNewCourseCreated: (state) => {
         state.company_courses_created ++;
         state.company_remaining_courses --;
      },
  }

})



