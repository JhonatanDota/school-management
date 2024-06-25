import { defineStore } from "pinia";
import { LoggedUserModel } from "@/models/AuthSuccessModel";
import UserTypeEnum from "@/enums/UserTypeEnum";

const userStore = defineStore("userStore", {
  state: (): LoggedUserModel => ({
    id: 0,
    name: "",
    userType: UserTypeEnum.MANAGER,
  }),

  actions: {
    setUser(user: LoggedUserModel) {
      this.id = user.id;
      this.name = user.name;
      this.userType = user.userType;
    },
    clearUser() {
      this.id = 0;
      this.name = "";
      this.userType = UserTypeEnum.MANAGER;
    },
  },
});

export default userStore;
