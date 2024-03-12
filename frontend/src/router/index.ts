import { createRouter, createWebHistory, RouteRecordRaw } from "vue-router";
import LoginPage from "@/pages/login/LoginPage.vue";
import HomePage from "@/pages/HomePage.vue";
import TeacherPage from "@/pages/teacher/TeacherPage.vue";
import KlassPage from "@/pages/klass/KlassPage.vue";
import StudentPage from "@/pages/student/StudentPage.vue";
import FallbackPage from "@/pages/FallbackPage.vue";

const routes: Array<RouteRecordRaw> = [
  {
    path: "/",
    component: LoginPage,
    meta: { requiresAuth: false, hideSideMenu: true },
  },
  { path: "/home", component: HomePage, meta: { requiresAuth: true } },
  { path: "/teachers", component: TeacherPage, meta: { requiresAuth: true } },
  { path: "/classes", component: KlassPage, meta: { requiresAuth: true } },
  { path: "/students", component: StudentPage, meta: { requiresAuth: true } },
  {
    path: "/:catchAll(.*)",
    component: FallbackPage,
    meta: { requiresAuth: false, hideSideMenu: true },
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

router.beforeEach((to, _, next) => {
  const path = to.path;
  const isAuthenticated = localStorage.getItem("isLogged");
  const isAuthRequired = to.meta.requiresAuth;

  if (path === "/") {
    if (!isAuthenticated) return next();
    return next("/home");
  }

  if (isAuthRequired && !isAuthenticated) return next("/");

  return next();
});

export default router;
