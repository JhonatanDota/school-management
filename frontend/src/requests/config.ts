import axios, {
  AxiosError,
  AxiosInstance,
  AxiosResponse,
  HttpStatusCode,
} from "axios";
import { getToken, cleanStoredLoginData } from "@/functions/auth";
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
    headers: {
      "Content-Type": "application/json",
      accept: "application/json",
      Authorization: `Bearer ${getToken()}`,
    },
    timeout: API_TIMEOUT_MILISECONDS,
  });

  axiosInstance.interceptors.response.use(
    (response: AxiosResponse) => {
      return response;
    },

    (error: AxiosError) => {
      if (error.response) {
        const statusCode: number = error.response.status;

        if (statusCode === HttpStatusCode.Unauthorized) {
          const url: string | undefined = error.config?.url;

          if (url === "auth") toast("Email ou senha incorretos", "warning");
          else {
            cleanStoredLoginData();
            window.location.href = "/";
          }
        } else if (statusCode === HttpStatusCode.UnprocessableEntity) {
          showRequestErrors(error.response.data as ErrorResponse);
        } else {
          toast("Ocorreu um erro no servidor", "error");
        }

        throw new Error();
      }
    }
  );

  return axiosInstance;
}

export function showRequestErrors(error: ErrorResponse): void {
  Object.keys(error.errors).forEach((field) => {
    error.errors[field].forEach((message) => {
      toast(`${field}: ${message}`, "warning");
    });
  });
}
