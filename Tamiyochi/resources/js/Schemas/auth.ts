import { z } from 'zod';

import { REG_PHONE } from '@/Constants/regex';

export const SignInSchema = z.object({
  email: z
    .string()
    .min(1, 'Email tidak boleh kosong')
    .email('Email tidak valid'),
  password: z.string().min(1, 'Password tidak boleh kosong'),
});

export type SignInRequest = z.infer<typeof SignInSchema>;

export const SignUpSchema = z.object({
  email: z
    .string()
    .min(1, 'Email tidak boleh kosong')
    .email('Email tidak valid'),
  name: z
    .string()
    .min(1, 'Nama tidak boleh kosong')
    .min(8, 'Nama harus terdiri dari minimal 8 karakter')
    .max(128, 'Nama harus terdiri dari minimal 128 karakter'),
  no_telp: z.string().regex(REG_PHONE, 'Nomor handphone tidak valid'),
  age: z.number(),
  /** @see https://github.com/shadcn-ui/ui/issues/884#issuecomment-1695758803 */
  image: z
    .custom<FileList>(
      (val) => val instanceof FileList,
      'Image tidak boleh kosong',
    )
    .refine((files) => files.length > 0, 'Image tidak boleh kosong')
    .refine((files) => files.length <= 1, 'Image hanya boleh satu file')
    .refine((files) => files[0].size <= 1048576, 'Image maksimal 1 MB')
    .refine(
      (files) =>
        ['image/png', 'image/jpg', 'image/jpeg'].includes(files[0].type),
      'Image hanya boleh bertipe .png, .jpg, atau .jpeg',
    ),
  password: z
    .string()
    .min(1, 'Password tidak boleh kosong')
    .min(8, 'Password harus terdiri dari minimal 8 huruf')
    .max(64, 'Password tidak boleh melebihi 64 karakter'),
});

export type SignUpRequest = z.infer<typeof SignUpSchema>;
