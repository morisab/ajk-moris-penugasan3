export type Cart = {
  volume_id: number;
  foto: string;
  jumlah_tersedia: number;
  jumlah_sewa: number;
  harga_sewa: number;
  volume: number;
  harga_sub_total: number;
  judul_seri: string;
};

export type CartResponse = {
  cart: Cart[];
  total_pinjaman: number;
  total_harga_sewa: number;
};
