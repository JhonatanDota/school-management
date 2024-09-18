import { requester } from "./config";
import PaginationModel from "@/models/PaginationModel";
import { AxiosResponse } from "axios";
import {
  CourseAddModel,
  CourseEditModel,
  CourseModel,
} from "@/models/CourseModel";

const COURSES_URL: string = "courses";

export interface CoursePagination extends PaginationModel {
  data: CourseModel[];
}

export async function getCourses(): Promise<AxiosResponse<CoursePagination>> {
  return await requester().get(COURSES_URL);
}

export async function getCourse(
  id: number
): Promise<AxiosResponse<CourseModel>> {
  return await requester().get(`${COURSES_URL}/${id}`);
}

export async function addCourse(
  data: CourseAddModel
): Promise<AxiosResponse<CourseModel>> {
  return await requester().post(COURSES_URL, data);
}

export async function editCourse(
  id: number,
  data: CourseEditModel
): Promise<AxiosResponse<CourseModel>> {
  return await requester().patch(`${COURSES_URL}/${id}`, data);
}
