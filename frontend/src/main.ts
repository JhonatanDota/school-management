import { createApp } from "vue";
import App from "./App.vue";
import { MotionPlugin } from "@vueuse/motion";
import router from "./router";
import Vue3Toasity, { type ToastContainerOptions } from "vue3-toastify";
import { plugin as Slicksort } from "vue-slicksort";
import { createPinia } from "pinia";
import "./index.css";

createApp(App)
  .use(router)
  .use(MotionPlugin)
  .use(Slicksort)
  .use(createPinia())
  .use(Vue3Toasity, {
    autoClose: 3000,
  } as ToastContainerOptions)
  .mount("#app");
