import BaseValidations from "../baseValidation";
import { CourseAddModel } from "@/models/CourseModel";

export default class AddCourseValidation extends BaseValidations {
  courseData: CourseAddModel;

  constructor(courseData: CourseAddModel) {
    super();
    this.courseData = courseData;

    this.checkValidations();
    this.handleValidation();
  }

  checkValidations(): void {
    if (!this.courseData.name)
      this.addError({ field: "Nome", message: "Preencha este campo" });
  }
}
