import BaseValidations from "../baseValidation";
import { TeacherAddModel } from "@/models/TeacherModel";
import { isValidRegex, emailRegex } from "@/utils/regex";

export default class AddTeacherValidation extends BaseValidations {
  teacherData: TeacherAddModel;

  constructor(teacherData: TeacherAddModel) {
    super();
    this.teacherData = teacherData;

    this.checkValidations();
    this.handleValidation();
  }

  checkValidations(): void {
    if (!this.teacherData.name)
      this.addError({ field: "Nome", message: "Preencha este campo" });

    if (!this.teacherData.email)
      this.addError({ field: "Email", message: "Preencha este campo" });
    else if (!isValidRegex(this.teacherData.email, emailRegex))
      this.addError({ field: "E-mail", message: "Email Inválido." });
  }
}
