import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router'

import HomePage from '@/pages/HomePage.vue'
import KlassPage from '@/pages/klass/KlassPage.vue'
import StudentPage from '@/pages/student/StudentPage.vue'

const routes: Array<RouteRecordRaw> = [
  { path: '/', component: HomePage },
  { path: '/classes', component: KlassPage },
  { path: '/students', component: StudentPage },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
