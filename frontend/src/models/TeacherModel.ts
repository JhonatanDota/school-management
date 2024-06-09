export interface TeacherModel {
  id: number;
  name: string;
  email: string;
  isActive: boolean;
  createdAt: string;
}

export type TeacherAddModel = Omit<TeacherModel, "id" | "isActive" | "createdAt">;
