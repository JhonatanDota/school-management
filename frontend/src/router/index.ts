import {
  createRouter,
  createWebHistory,
  RouteRecordRaw,
  RouteLocationNormalized,
  NavigationGuardNext,
} from "vue-router";
import { isLogged } from "@/functions/auth";
import LoginPage from "@/pages/login/LoginPage.vue";
import HomePage from "@/pages/HomePage.vue";
import CoursePage from "@/pages/course/CoursePage.vue";
import CourseDetails from "@/pages/course/CourseDetails.vue";
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
  { path: "/home", component: HomePage, meta: { requiresAuth: true } },
  { path: "/courses", component: CoursePage, meta: { requiresAuth: true } },
  { path: "/courses/:id", component: CourseDetails, meta: { requiresAuth: true } },
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

router.beforeEach(
  (
    to: RouteLocationNormalized,
    _: RouteLocationNormalized,
    next: NavigationGuardNext
  ) => {
    const path = to.path;
    const isAuthenticated: boolean = isLogged();
    const isAuthRequired: boolean = Boolean(to.meta.requiresAuth);

    if (path === "/") {
      if (!isAuthenticated) return next();
      return next("/home");
    }

    if (isAuthRequired && !isAuthenticated) return next("/");

    return next();
  }
);

export default router;
