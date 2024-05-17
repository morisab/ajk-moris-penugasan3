import { zodResolver } from '@hookform/resolvers/zod';
import { Link, router } from '@inertiajs/react';
import { serialize } from 'object-to-formdata';
import React from 'react';
import { useForm } from 'react-hook-form';

import { Alert, AlertDescription } from '@/Components/ui/alert';
import { Button } from '@/Components/ui/button';
import {
  Form,
  FormControl,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from '@/Components/ui/form';
import { Input } from '@/Components/ui/input';
import Typography from '@/Components/ui/typography';
import AuthLayout from '@/Layouts/auth';
import { SignUpRequest, SignUpSchema } from '@/Schemas/auth';
import { PageProps } from '@/Types/entities/page';

export default function SignUpPage({ success, message }: PageProps) {
  const form = useForm<SignUpRequest>({
    resolver: zodResolver(SignUpSchema),
    defaultValues: {
      name: '',
      email: '',
      password: '',
      no_telp: '',
      age: 0,
    },
  });

  const { control, handleSubmit } = form;

  const onSubmit = (data: SignUpRequest) => {
    const formData = serialize(
      { ...data, image: data.image[0] },
      { indices: true },
    );
    router.post(route('auth.register'), formData);
  };

  return (
    <AuthLayout>
      <Form {...form}>
        <form
          encType='multipart/formdata'
          onSubmit={handleSubmit(onSubmit)}
          className='space-y-6'
        >
          <Typography
            as='h1'
            variant='h1-48/48'
            weight='bold'
            className='text-center'
          >
            Sign Up
          </Typography>

          <div className='space-y-3'>
            <FormField
              control={control}
              name='name'
              render={({ field }) => (
                <FormItem>
                  <FormLabel>Nama Lengkap</FormLabel>
                  <FormControl>
                    <Input placeholder='Masukkan Nama Lengkap' {...field} />
                  </FormControl>
                  <FormMessage />
                </FormItem>
              )}
            />

            <FormField
              control={control}
              name='email'
              render={({ field }) => (
                <FormItem>
                  <FormLabel>Email</FormLabel>
                  <FormControl>
                    <Input placeholder='Masukkan Email' {...field} />
                  </FormControl>
                  <FormMessage />
                </FormItem>
              )}
            />

            <FormField
              control={control}
              name='password'
              render={({ field }) => (
                <FormItem>
                  <FormLabel>Password</FormLabel>
                  <FormControl>
                    <Input
                      type='password'
                      placeholder='Masukkan Password'
                      {...field}
                    />
                  </FormControl>
                  <FormMessage />
                </FormItem>
              )}
            />

            <FormField
              control={control}
              name='no_telp'
              render={({ field }) => (
                <FormItem>
                  <FormLabel>Nomor Telepon</FormLabel>
                  <FormControl>
                    <Input placeholder='Masukkan Nomor Telepon' {...field} />
                  </FormControl>
                  <FormMessage />
                </FormItem>
              )}
            />

            <FormField
              control={control}
              name='age'
              render={({ field: { onChange, ...field } }) => (
                <FormItem>
                  <FormLabel>Usia</FormLabel>
                  <FormControl>
                    <Input
                      type='number'
                      placeholder='Masukkan Usia'
                      onChange={(e) => onChange(e.target.valueAsNumber)}
                      {...field}
                    />
                  </FormControl>
                  <FormMessage />
                </FormItem>
              )}
            />

            <FormField
              control={control}
              name='image'
              render={({ field: { value: _value, onChange, ...field } }) => (
                <FormItem>
                  <FormLabel>Image</FormLabel>
                  <FormControl>
                    <Input
                      type='file'
                      accept='image/png, image/jpg, image/jpeg'
                      onChange={(e) => onChange(e.target.files)}
                      {...field}
                    />
                  </FormControl>
                  <FormMessage />
                </FormItem>
              )}
            />
          </div>

          <div className='space-y-1.5'>
            {success === false && (
              <Alert variant='destructive' className='text-center'>
                <AlertDescription className='capitalize'>
                  {message}
                </AlertDescription>
              </Alert>
            )}

            <Button type='submit' className='w-full'>
              Sign Up
            </Button>

            <div className='flex justify-center items-center gap-1'>
              <Typography variant='body-14/24' weight='medium'>
                Sudah punya akun?
              </Typography>
              <Link href={route('auth.login.index')}>
                <Typography variant='body-14/24' weight='semibold'>
                  Masuk
                </Typography>
              </Link>
            </div>
          </div>
        </form>
      </Form>
    </AuthLayout>
  );
}
