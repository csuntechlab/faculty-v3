import Vue from 'vue'
import Router from 'vue-router'
import ProfileHome from '../components/ProfileHome'
import ProfileClasses from '../components/ProfileClasses'
import ProfileProjects from '../components/ProfileProjects'
import ProfileCitations from '../components/ProfileCitations'
import ProfileStudents from '../components/ProfileStudents'

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
    },
    {
      path:'/projects',
      name: 'ProfileProjects',
      component: ProfileProjects,
    },
    {
      path:'/citations',
      name: 'ProfileCitations',
      component: ProfileCitations,
    },
    {
      path:'/students',
      name: 'ProfileStudents',
      component: ProfileStudents,
    }
  ]
})