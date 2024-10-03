export interface CourseLessonModel {
  id: number;
  courseId: number;
  name: string;
  order: number;
  createdAt: Date;
  updatedAt: Date;
}

export type CourseLessonAddModel = Omit<
  CourseLessonModel,
  "id" | "order" | "createdAt" | "updatedAt"
>;
