import { requester } from "./config";
import { AxiosResponse } from "axios";
import { AuthModel } from "@/models/AuthSuccessModel";

const AUTH: string = "auth";
const LOGOUT: string = "logout";

export async function auth(
  email: string,
  password: string
): Promise<AxiosResponse<AuthModel>> {
  return await requester().post(AUTH, {
    email,
    password,
  });
}

export async function logout(): Promise<AxiosResponse> {
  return await requester().post(LOGOUT);
}
