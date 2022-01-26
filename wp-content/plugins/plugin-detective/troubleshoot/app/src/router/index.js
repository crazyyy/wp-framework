import Vue from 'vue'
import Router from 'vue-router'
import Hello from '@/components/Hello'
import FindProblem from '@/components/FindProblem'
import Witnesses from '@/components/Witnesses'
import Interrogating from '@/components/Interrogating'
import Test from '@/components/Test'
import Complete from '@/components/Complete'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Hello',
      component: Hello
    },
    {
      path: '/find-the-problem',
      name: 'Find the Problem',
      component: FindProblem
    },
    {
      path: '/key-witnesses',
      name: 'Witnesses',
      component: Witnesses
    },
    {
      path: '/interrogating',
      name: 'Interrogating',
      component: Interrogating
    },
    {
      path: '/test',
      name: 'Test',
      component: Test
    },
    {
      path: '/investigation-complete',
      name: 'Complete',
      component: Complete
    }
  ]
})
