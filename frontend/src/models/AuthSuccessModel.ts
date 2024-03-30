export default interface SuccessLoginInterface {
    token: string,
    user: {
      id: number;
      name: string;
      email: string;
    }
  }