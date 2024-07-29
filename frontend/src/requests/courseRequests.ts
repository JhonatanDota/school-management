import { requester } from "./config";
import PaginationModel from "@/models/PaginationModel";
import { AxiosResponse } from "axios";
import { CourseModel } from "@/models/CourseModel";

const COURSES_URL: string = "courses";

export interface CoursePagination extends PaginationModel {
  data: CourseModel[];
}

export async function getCourses(): Promise<AxiosResponse<CoursePagination>> {
  return await requester().get(COURSES_URL);
}
