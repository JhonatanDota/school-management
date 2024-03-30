import { requester } from "./config";
import { AxiosResponse } from "axios";
import AuthSuccessModel from "@/models/AuthSuccessModel";

const AUTH: string = "auth";
const LOGOUT: string = "logout";

export async function auth(
  email: string,
  password: string
): Promise<AxiosResponse<AuthSuccessModel>> {
  return await requester().post(AUTH, {
    email,
    password,
  });
}

export async function logout(): Promise<AxiosResponse> {
  return await requester().post(LOGOUT);
}
