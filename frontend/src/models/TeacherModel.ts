export interface TeacherModel {
  id: number;
  name: string;
  email: string;
  isActive: boolean;
  createdAt: Date;
  updatedAt: Date;
}

export type TeacherAddModel = Omit<TeacherModel, "id" | "isActive" | "createdAt">;
