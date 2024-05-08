export type SeriTerpinjam = {
  volume_id: number;
  status: 'SUCCESS' | 'PENDING' | 'EXPIRED';
  tanggal_peminjaman: string;
  tanggal_pengembalian: string;
  sisa_hari: string;
  volume: string;
  judul: string;
  penulis_nama_depan: string;
  penulis_nama_belakang: string;
  foto: string;
};
