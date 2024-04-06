export default interface PaginationModel {
  current_page: number;
  next_page_url: string | null;
  prev_page_url: string | null;
  total: number;
}
