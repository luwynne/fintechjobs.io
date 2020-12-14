

require('./bootstrap');
window.Vue = require('vue');
import VueRouter from 'vue-router'
import store from "./store/store"

//components
let Home = require('./components/home/Home.vue').default;
let Vacancies = require('./components/vacancies/Vacancies.vue').default;
let Applications = require('./components/applications/Applications.vue').default;
let Events = require('./components/events/Events.vue').default;
let Billing = require('./components/billing/Billing.vue').default;
let Users = require('./components/users/Users.vue').default;
let Company = require('./components/company/Company.vue').default;
let Assets = require('./components/assets/Assets.vue').default;
let Courses = require('./components/courses/Courses.vue').default;

//Vue.config.devtools = true
Vue.component('main-component', require('./components/Main.vue').default);

Vue.use(VueRouter);

const routes = [

    {
      path:'/', 
      name: 'Home', 
      component: Home
    },

    {
      path:'/vacancies', 
      name: 'Vacancies', 
      component: Vacancies,
      meta: {
        requiresJobAllowance: true
      }
    },

    {
      path:'/applications', 
      name: 'Applications', 
      component: Applications,
      meta: {
        requiresJobAllowance: true
      }
    },

    {
      path:'/events', 
      name: 'Events', 
      component: Events,
      meta: {
        requiresEventsAllowance: true
      }
    },

    {
      path:'/billing', 
      name: 'Billing', 
      component: Billing
    },

    {
      path:'/users', 
      name: 'Users', 
      component: Users,
      meta: {
        requiresAdminRole: true
      }
    },

    {
      path:'/company', 
      name: 'Company', 
      component: Company,
      meta: {
        requiresAdminRole: true
      }
    },

    {
      path:'/assets', 
      name: 'Assets', 
      component: Assets
    },

    {
      path:'/courses', 
      name: 'Courses', 
      component: Courses,
      meta: {
        requiresCoursesAllowance: true
      }
    },

  ];

  const router = new VueRouter({
    routes: routes,
  })

  

  router.beforeEach((to, from, next) => {

    if (to.matched.some(record => record.meta.requiresAdminRole)) {
        if (store.getters.getCompanyLoggedUser.role === 'admin') {
            next()
            return
        }
        next('/')
    } else {
        next()
    }

    if (to.matched.some(record => record.meta.requiresJobAllowance)) {
      if (store.getters.getCompanyJobsAllowed > 0) {
          next()
          return
      }
      next('/')
    } else {
        next()
    }

    if (to.matched.some(record => record.meta.requiresEventsAllowance)) {
      if (store.getters.getCompanyEventsAllowed > 0) {
          next()
          return
      }
      next('/')
    } else {
        next()
    }

    if (to.matched.some(record => record.meta.requiresCoursesAllowance)) {
      if (store.getters.getCompanyCoursesAllowed > 0) {
          next()
          return
      }
      next('/')
    } else {
        next()
    }

})




Vue.filter('capitalize', function (value) {
    if (!value) return ''
    value = value.toString()
    return value.charAt(0).toUpperCase() + value.slice(1)
})


const app = new Vue({
    el: '#app',
    router: router,
    store: store,
    components:{
        Home,
        Vacancies,
        Applications,
        Events,
        Billing,
        Users,
        Company,
        Assets,
        Courses
    }
});


