import { ThModel } from "./DataTableModel";
export interface TeacherModel {
  id: number;
  name: string;
  email: string;
  createdAt: string;
}

export const teacherTdKeys: string[] = ["id", "name", "email", "created_at"];

export const teacherThList: ThModel[] = [
    { text: "Identificador" },
    { text: "Nome" },
    { text: "Email" },
    { text: "Criado em" },
  ];
