import BaseValidations from "../baseValidation";
import { CourseLessonAddModel } from "@/models/CourseLessonModel";

export default class AddCourseLessonValidation extends BaseValidations {
  courseLessonData: CourseLessonAddModel;

  constructor(courseLessonData: CourseLessonAddModel) {
    super();
    this.courseLessonData = courseLessonData;

    this.checkValidations();
    this.handleValidation();
  }

  checkValidations(): void {
    if (!this.courseLessonData.name)
      this.addError({ field: "Nome", message: "Preencha este campo" });
  }
}
