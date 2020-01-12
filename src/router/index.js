import Vue from 'vue'
import Router from 'vue-router'
import HelloWorld from '@/components/HelloWorld'
import BackEndHome from '@/components/backend/BackEndHome.vue'
import LogIn from '@/components/logIn.vue'
import NewImage from '@/components/backend/newImage.vue'

Vue.use(Router)

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'HelloWorld',
      component: HelloWorld
    },
    {
      path: '/login',
      name: 'logIn',
      component: LogIn
    },
    {
      path: '/backend',
      name: 'BackEndHome',
      component: BackEndHome
    },
    {
      path: '/newImage',
      name: 'NewImage',
      component: NewImage
    }
  ]
})
