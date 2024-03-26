import {  requester } from "./config";

const AUTH: string = "auth";

export async function auth(email: string, password: string){
    return await requester().post(AUTH);
}