import { defineStore } from "pinia";
import { LoggedUserModel } from "@/models/AuthSuccessModel";
import { me } from "@/requests/authRequests";

interface UserStoreInterface {
  user: LoggedUserModel;
  filling: boolean;
}

const initialState: UserStoreInterface = {
  user: {},
  filling: true,
};

const userStore = defineStore("userStore", {
  state: (): UserStoreInterface => initialState,

  actions: {
    setUser(user: LoggedUserModel): void {
      this.user.id = user.id;
      this.user.name = user.name;
      this.user.userType = user.userType;
      this.user.imageUrl = user.imageUrl;
    },

    async fill(): Promise<void> {
      this.filling = true;

      const response = await me();
      this.setUser(response.data);

      this.filling = false;
    },
  },
});

export default userStore;
