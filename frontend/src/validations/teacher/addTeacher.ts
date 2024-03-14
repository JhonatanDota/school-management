import BaseValidations from "../baseValidation";

export default class AddTeacherValidation extends BaseValidations {
    name?: string;
    email?: string;

    constructor(name?: string, email?: string) {
        super();
        this.name = name;
        this.email = email;
    
        this.checkValidations();
        this.handleValidation();
      }

      checkValidations(): void {
        if (!this.name)
          this.addError({ field: "Nome", message: "Preencha este campo" });
        if (!this.email)
          this.addError({ field: "Email", message: "Preencha este campo" });
      }
    
}