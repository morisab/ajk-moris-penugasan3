export type User = {
  id: string;
  kabupaten_id: number;
  name: string;
  email: string;
  no_telp: string;
  user_type: 'user' | 'admin';
  age: number;
  image_url: string;
};

export type PageProps<TData = unknown> = {
  success: boolean;
  message: string;
  data?: TData;
  code?: number;
  user?: User;
};

export type Paginated<TData, KMeta> = {
  data: TData;
  meta: KMeta;
};

export type PaginatedQuery = {
  page?: number;
  per_page?: number;
  filter?: number[];
  search?: string;
};
