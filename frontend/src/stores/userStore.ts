import { defineStore } from "pinia";
import { LoggedUserModel } from "@/models/AuthSuccessModel";
import { me } from "@/requests/authRequests";

const userStore = defineStore("userStore", {
  state: (): LoggedUserModel => ({}),

  actions: {
    setUser(user: LoggedUserModel): void {
      this.id = user.id;
      this.name = user.name;
      this.userType = user.userType;
      this.imageUrl = user.imageUrl;
    },

    async fill(): Promise<void> {
      const response = await me();
      this.setUser(response.data);
    },
  },
});

export default userStore;
