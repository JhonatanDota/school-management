import { toast as baseToast, type ToastOptions } from "vue3-toastify";

export function toast(message: string, duration: number = 2000) {
  baseToast(message, {
    autoClose: duration,
  } as ToastOptions);
}
