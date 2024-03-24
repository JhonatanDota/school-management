export const emailRegex: RegExp =
  /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

export function isValidRegex(str: string, regex: RegExp) {
  return regex.test(str);
}
