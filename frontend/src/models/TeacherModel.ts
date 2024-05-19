export interface TeacherModel {
  id: number;
  name: string;
  email: string;
  createdAt: string;
}

export type TeacherAddModel = Omit<TeacherModel, "id" | "createdAt">;
