import AuthSuccessModel from "@/models/AuthSuccessModel";

const TOKEN_STORAGE_KEY: string = "token";
const USER_STORAGE_KEY: string = "user";

export function getToken(): string | null {
  return localStorage.getItem(TOKEN_STORAGE_KEY);
}

export function getAuthUser(): string | null {
  return localStorage.getItem(USER_STORAGE_KEY);
}

export function storeLoginData(data: AuthSuccessModel): void {
  localStorage.setItem(TOKEN_STORAGE_KEY, data.token);
  localStorage.setItem(USER_STORAGE_KEY, JSON.stringify(data.user));
}

export function cleanStoredLoginData(): void {
  localStorage.removeItem(TOKEN_STORAGE_KEY);
  localStorage.removeItem(USER_STORAGE_KEY);
}

export function isLogged(): boolean {
  return Boolean(
    localStorage.getItem(TOKEN_STORAGE_KEY) &&
      Boolean(localStorage.getItem(USER_STORAGE_KEY))
  );
}
