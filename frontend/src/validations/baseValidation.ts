import ValidationModel from "@/models/ValidationsModel";
import { toast } from "@/utils/functions/toast";

export default abstract class BaseValidations {
  validationErrors: ValidationModel[] = [];

  abstract checkValidations(): void;
  
  handleValidation(){
    this.showValidationErrors(this.validationErrors);

    if (this.validationErrors.length) {
      throw new Error();
    }
  }

  addError(error: ValidationModel): void {
    this.validationErrors.push(error);
  }

  showValidationErrors(errors: ValidationModel[]): void {
    errors.forEach((error: ValidationModel) => {
      toast(error.message);
    });
  }
}
