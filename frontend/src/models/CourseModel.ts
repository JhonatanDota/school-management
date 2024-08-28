export interface CourseModel {
  id: number;
  name: string;
  description?: string;
  createdAt: Date;
  updatedAt: Date;
}

export type CourseAddModel = Omit<
  CourseModel,
  "id" | "createdAt" | "updatedAt"
>;
