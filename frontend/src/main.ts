import { createApp } from "vue";
import App from "./App.vue";
import { MotionPlugin } from '@vueuse/motion'
import router from "./router";
import Vue3Toasity, { type ToastContainerOptions } from "vue3-toastify";
import "./index.css";

createApp(App)
  .use(router)
  .use(MotionPlugin)
  .use(Vue3Toasity, {
    autoClose: 3000,
  } as ToastContainerOptions)
  .mount("#app");
  
