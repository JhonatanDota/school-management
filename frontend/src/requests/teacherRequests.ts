import { requester } from "./config";
import { AxiosResponse } from "axios";
import { TeacherModel, TeacherAddModel } from "@/models/TeacherModel";
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

export async function addTeacher(
  data: TeacherAddModel
): Promise<AxiosResponse<TeacherModel>> {
  return await requester().post(TEACHERS_URL, data);
}
