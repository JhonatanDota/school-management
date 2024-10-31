import { createApp } from "vue";
import App from "./App.vue";
import { MotionPlugin } from "@vueuse/motion";
import router from "./router";
import Vue3Toasity, { type ToastContainerOptions } from "vue3-toastify";
import { plugin as Slicksort } from "vue-slicksort";
import { createPinia } from "pinia";
import { createVfm } from "vue-final-modal";
import "./index.css";
import 'vue-final-modal/style.css'

createApp(App)
  .use(router)
  .use(MotionPlugin)
  .use(Slicksort)
  .use(createPinia())
  .use(createVfm())
  .use(Vue3Toasity, {
    autoClose: 3000,
  } as ToastContainerOptions)
  .mount("#app");
