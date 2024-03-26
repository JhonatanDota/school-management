import BaseValidations from "./baseValidation";
import { isValidRegex, emailRegex } from "@/utils/regex";

export default class LoginValidation extends BaseValidations {
  email: string;
  password: string;

  constructor(email: string, password: string) {
    super();
    this.email = email;
    this.password = password;

    this.checkValidations();
    this.handleValidation();
  }

  checkValidations(): void {
    if (!this.email.length)
      this.addError({ field: "E-mail", message: "Preencha este campo." });
    else if (!isValidRegex(this.email, emailRegex))
      this.addError({ field: "E-mail", message: "Email Inválido." });

    if (!this.password.length)
      this.addError({ field: "Password", message: "Preencha este campo." });
  }
}
