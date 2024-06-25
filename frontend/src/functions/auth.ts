import { AuthModel, LoggedUserModel } from "@/models/AuthSuccessModel";
import { jwtDecode, JwtPayload } from "jwt-decode";
import Cookies from "js-cookie";

const TOKEN_STORAGE_KEY: string = "token";
const USER_STORAGE_KEY: string = "user";

export function getToken(): string | null {
  return localStorage.getItem(TOKEN_STORAGE_KEY);
}

export function getUserFromToken(token: string): LoggedUserModel {
  const user: LoggedUserModel = jwtDecode<
    JwtPayload & { user: LoggedUserModel }
  >(token).user;

  return user;
}

export function storeLoginData(data: AuthModel): void {
  localStorage.setItem(TOKEN_STORAGE_KEY, data.token);
}

export function cleanStoredLoginData(): void {
  localStorage.removeItem(TOKEN_STORAGE_KEY);
  localStorage.removeItem(USER_STORAGE_KEY);
}

export function isLogged(): boolean {
  return Boolean(localStorage.getItem(TOKEN_STORAGE_KEY));
}
