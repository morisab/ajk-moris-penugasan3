export type Volume = {
  id: number;
  volume: number;
  jumlah_tersedia: number;
  harga_sewa: number;
  seri_id: number;
};

export type Penulis = {
  id: number;
  nama_depan: string;
  nama_belakang: string;
  peran: string;
};

export type Genre = {
  id: number;
  nama: string;
};

export type Penerbit = Genre;

export type Seri = {
  id: number;
  judul: string;
  sinopsis: string;
  tahun_terbit: string;
  skor: number;
  foto: string;
  penerbit: Penerbit;
  volume: Volume[];
  penulis: Penulis[];
  genre: Genre[];
};

export type SeriCreateResponse = {
  genres: Genre[];
  penulis: Penulis[];
  penerbit: Penerbit[];
};

export type SeriMeta = {
  max_page: number;
  genre: Genre[];
};
