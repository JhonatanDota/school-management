import BaseValidations from "./baseValidation";

export default class LoginValidation extends BaseValidations {
  email?: string;
  password?: string;

  constructor(email?: string, password?: string) {
    super();
    this.email = email;
    this.password = password;

    this.checkValidations();
    this.handleValidation();
  }

  checkValidations(): void {
    if (!this.email)
      this.addError({ field: "E-mail", message: "Preencha este campo" });
    if (!this.password)
      this.addError({ field: "Password", message: "Preencha este campo" });
  }
}
