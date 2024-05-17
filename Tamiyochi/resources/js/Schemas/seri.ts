import { z } from 'zod';

export const SeriSchema = z.object({
  judul: z.string().min(1, 'Judul tidak boleh kosong'),
  sinopsis: z.string().min(1, 'Sinopsis tidak boleh kosong'),
  tahun_terbit: z.date({ required_error: 'Tahun terbit tidak boleh kosong' }),
  foto: z
    .custom<FileList>(
      (val) => val instanceof FileList,
      'Gambar manga tidak boleh kosong',
    )
    .refine((files) => files.length > 0, 'Gambar manga tidak boleh kosong')
    .refine((files) => files.length <= 1, 'Gambar manga hanya boleh satu file')
    .refine((files) => files[0].size <= 1048576, 'Gambar manga maksimal 1 MB')
    .refine(
      (files) =>
        ['image/png', 'image/jpg', 'image/jpeg'].includes(files[0].type),
      'Gambar mangan hanya boleh bertipe .png, .jpg, atau .jpeg',
    )
    .optional(),
  penerbit_id: z.number({ required_error: 'Penerbit tidak boleh kosong' }),
  penulis_id: z
    .number({ required_error: 'Penulis tidak boleh kosong' })
    .array(),
  genre_id: z.number({ required_error: 'Genre tidak boleh kosong' }).array(),
  volume: z
    .array(
      z.object({
        volume: z.number({ required_error: 'Volume tidak boleh kosong' }),
        harga_sewa: z.string({
          required_error: 'Harga sewa tidak boleh kosong',
        }),
        jumlah_tersedia: z.string({
          required_error: 'Jumlah tersedia tidak boleh kosong',
        }),
      }),
    )
    .min(1, 'Volume tersedia tidak boleh kosong'),
});

export type SeriRequest = z.infer<typeof SeriSchema>;
