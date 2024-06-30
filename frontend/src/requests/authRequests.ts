import { requester } from "./config";
import { AxiosResponse } from "axios";
import { AuthModel } from "@/models/AuthSuccessModel";
import { LoggedUserModel } from "@/models/AuthSuccessModel";

const AUTH: string = "auth";
const ME: string = "me";
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

export async function me(): Promise<AxiosResponse<LoggedUserModel>> {
  return await requester().get(ME);
}