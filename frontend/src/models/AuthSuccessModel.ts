import UserTypeEnum from "@/enums/UserTypeEnum";

export interface AuthModel {
  token: string;
}

export interface LoggedUserModel {
  id?: number;
  name?: string;
  imageUrl?: string;
  userType?: UserTypeEnum;
}
