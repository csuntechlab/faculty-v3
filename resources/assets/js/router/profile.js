import Vue from 'vue'
import Router from 'vue-router'
import ProfileHome from '../components/ProfileHome'
import ProfileClasses from '../components/ProfileClasses'

Vue.use(Router);

export default new Router({
  routes: [
    {
      path:'/',
      name: 'ProfileHome',
      component: ProfileHome,
    },
    {
      path:'/classes',
      name: 'ProfileClasses',
      component: ProfileClasses,
    }
  ]
})