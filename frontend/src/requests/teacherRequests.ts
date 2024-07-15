import { requester } from "./config";
import { AxiosResponse } from "axios";
import {
  TeacherModel,
  TeacherAddModel,
  TeacherEditModel,
} from "@/models/TeacherModel";
import PaginationModel from "@/models/PaginationModel";

const TEACHERS_URL: string = "teachers";

export interface TeacherPagination extends PaginationModel {
  data: TeacherModel[];
}

export async function getTeachers(
  params?: object
): Promise<AxiosResponse<TeacherPagination>> {
  return await requester().get(TEACHERS_URL, { params });
}

export async function getTeacher(
  id: number
): Promise<AxiosResponse<TeacherModel>> {
  return await requester().get(`${TEACHERS_URL}/${id}`);
}

export async function addTeacher(
  data: TeacherAddModel
): Promise<AxiosResponse<TeacherModel>> {
  return await requester().post(TEACHERS_URL, data);
}

export async function editTeacher(
  id: number,
  data: TeacherEditModel
): Promise<AxiosResponse<TeacherModel>> {
  return await requester().patch(`${TEACHERS_URL}/${id}`, data);
}
