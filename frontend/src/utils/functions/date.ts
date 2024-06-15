import { format as formatter } from "date-fns";

export function dateFormat(date: Date, format: string = "dd/MM/yyyy hh:mm:ss"): string {
  return formatter(date, format);
}
