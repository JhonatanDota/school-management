import { requester } from "./config";
import { AxiosResponse } from "axios";
import {
  CourseLessonAddModel,
  CourseLessonModel,
  CourseLessonUpdateModel,
} from "@/models/CourseLessonModel";

const LESSONS_URL: string = "lessons";

export async function addCourseLesson(
  data: CourseLessonAddModel
): Promise<AxiosResponse<CourseLessonModel>> {
  return await requester().post(LESSONS_URL, data);
}

export async function updateCourseLesson(
  id: number,
  data: CourseLessonUpdateModel
): Promise<AxiosResponse<CourseLessonModel>> {
  return await requester().patch(`${LESSONS_URL}/${id}`, data);
}
