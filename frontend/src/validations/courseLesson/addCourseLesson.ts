import BaseValidations from "../baseValidation";
import { CourseLessonAddModel } from "@/models/CourseLessonModel";

export default class AddCourseLessonValidation extends BaseValidations {
  readonly NAME_MIN_LENGTH: number = 3;
  readonly NAME_MAX_LENGTH: number = 20;

  courseLessonData: CourseLessonAddModel;

  constructor(courseLessonData: CourseLessonAddModel) {
    super();
    this.courseLessonData = courseLessonData;

    this.checkValidations();
    this.handleValidation();
  }

  checkValidations(): void {
    if (!this.courseLessonData.name) {
      this.addError({ field: "Nome", message: "Preencha este campo" });
    } else if (this.courseLessonData.name.length < this.NAME_MIN_LENGTH) {
      this.addError({
        field: "Nome",
        message: `Deve ter no mínimo ${this.NAME_MIN_LENGTH} caracteres.`,
      });
    } else if (this.courseLessonData.name.length > this.NAME_MAX_LENGTH) {
      this.addError({
        field: "Nome",
        message: `Pode ter no máximo ${this.NAME_MAX_LENGTH} caracteres.`,
      });
    }
  }
}
