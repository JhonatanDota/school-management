import { requester } from "./config";
import { AxiosResponse } from "axios";
import { TeacherModel } from "@/models/TeacherModel";
import PaginationModel from "@/models/PaginationModel";

const TEACHERS_URL: string = "teachers";

export interface TeacherPagination extends PaginationModel {
  data: TeacherModel[];
}

export async function getTeachers(page?: number): Promise<AxiosResponse<TeacherPagination>> {
  return await requester().get(TEACHERS_URL, {params: {page}});
}
