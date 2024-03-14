import {
  toast as baseToast,
  ToastType,
  type ToastOptions,
} from "vue3-toastify";
// import { toast } from "vue3-toastify"
import "vue3-toastify/dist/index.css";

export function toast(
  message: string,
  type: ToastType = "success",
  duration: number = 2000
) {
  baseToast(message, {
    type,
    theme: "dark",
    transition: "flip",
    hideProgressBar: true,
    autoClose: duration,
  } as ToastOptions);
}
