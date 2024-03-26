import axios, {
  AxiosError,
  AxiosInstance,
  AxiosResponse,
  HttpStatusCode,
} from "axios";

import { toast } from "@/utils/functions/toast";

const BASE_URL: string = process.env.VUE_APP_API_URL;
const API_TIMEOUT_MILISECONDS: number = 10000;
interface ErrorResponse {
  message: string;
  errors: {
    [key: string]: string[];
  };
}

export function requester(): AxiosInstance {
  const axiosInstance: AxiosInstance = axios.create({
    baseURL: BASE_URL,
    timeout: API_TIMEOUT_MILISECONDS,
    headers: {
      "Content-Type": "application/json",
      accept: "application/json",
    },
  });

  axiosInstance.interceptors.response.use(
    (response: AxiosResponse) => {
      return response;
    },

    (error: AxiosError) => {
      if (error.response) {
        const statusCode: number = error.response.status;

        if (statusCode === HttpStatusCode.Unauthorized) {
          console.log("xablaue");
        } else if (statusCode === HttpStatusCode.UnprocessableEntity) {
          showRequestErrors(error.response.data as ErrorResponse);
        }
      }
    }
  );

  return axiosInstance;
}

export function showRequestErrors(error: ErrorResponse): void {
  Object.keys(error.errors).forEach((field) => {
    error.errors[field].forEach((message) => {
      toast(`${field}: ${message}`, "error");
    });
  });
}
