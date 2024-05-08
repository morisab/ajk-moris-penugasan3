import { zodResolver } from '@hookform/resolvers/zod';
import { Link, router } from '@inertiajs/react';
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
import { SignInRequest, SignInSchema } from '@/Schemas/auth';
import { PageProps } from '@/Types/entities/page';

export default function SignInPage({ success, message }: PageProps) {
  const form = useForm<SignInRequest>({
    resolver: zodResolver(SignInSchema),
    defaultValues: {
      email: '',
      password: '',
    },
  });

  const { control, handleSubmit } = form;

  const onSubmit = (data: SignInRequest) => {
    router.post(route('auth.login'), data);
  };

  return (
    <AuthLayout>
      <Form {...form}>
        <form onSubmit={handleSubmit(onSubmit)} className='space-y-6'>
          <Typography
            as='h1'
            variant='h1-48/48'
            weight='bold'
            className='text-center'
          >
            Sign In
          </Typography>

          <div className='space-y-3'>
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
          </div>

          <div className='space-y-1.5'>
            {success === false && (
              <Alert variant='destructive' className='text-center'>
                <AlertDescription>{message}</AlertDescription>
              </Alert>
            )}

            <Button type='submit' className='w-full'>
              Sign In
            </Button>

            <div className='flex justify-center items-center gap-1'>
              <Typography variant='body-14/24' weight='medium'>
                Belum punya akun?
              </Typography>
              <Link href={route('auth.register.index')}>
                <Typography variant='body-14/24' weight='semibold'>
                  Daftar
                </Typography>
              </Link>
            </div>
          </div>
        </form>
      </Form>
    </AuthLayout>
  );
}
