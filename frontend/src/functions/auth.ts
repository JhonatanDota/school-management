import Cookies from "js-cookie";
import userStore from "@/stores/userStore";
import { jwtDecode, JwtPayload } from "jwt-decode";
import { AuthModel, LoggedUserModel } from "@/models/AuthSuccessModel";

const TOKEN_COOKIE_KEY: string = "token";

export function getToken(): string | undefined {
  return Cookies.get(TOKEN_COOKIE_KEY);
}

export function storeLoginData(authData: AuthModel): void {
  const token: string = authData.token;

  Cookies.set(TOKEN_COOKIE_KEY, token);
}

export function cleanStoredLoginData(): void {
  Cookies.remove(TOKEN_COOKIE_KEY);
}

export function isLogged(): boolean {
  return Boolean(Cookies.get(TOKEN_COOKIE_KEY));
}
