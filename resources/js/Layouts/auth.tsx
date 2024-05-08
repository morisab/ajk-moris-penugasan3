import React from 'react';

import { cn } from '@/Libs/utils';

export default function AuthLayout({
  children,
  className,
  ...rest
}: {
  children: React.ReactNode;
} & React.ComponentPropsWithoutRef<'main'>) {
  return (
    <main
      className={cn('flex min-h-screen w-full bg-background', className)}
      {...rest}
    >
      <section className='w-full lg:w-4/12 min-h-screen flex flex-col justify-center px-4 md:px-8 py-6 md:py-12'>
        {children}
      </section>
      <section className='hidden lg:block fixed w-8/12 h-screen right-0 top-0 p-3'>
        <div className='relative w-full h-full flex justify-between p-6 rounded-lg bg-foreground'>
          <div className='flex items-end h-full '>
            <img
              src='/images/auth/bg-left-decoration.png'
              alt='left decoration'
              width='200'
              height='468'
              className='h-1/2 w-fit object-contain object-left-bottom'
            />
          </div>

          <div className='flex justify-center h-full'>
            <img
              src='/images/logo.png'
              alt='logo'
              width='320'
              height='320'
              className='w-1/2 min-w-[200px] object-contain'
            />
          </div>

          <div className='flex flex-row-reverse items-start h-full'>
            <img
              src='/images/auth/bg-right-decoration.png'
              alt='right decoration'
              width='200'
              height='468'
              className='h-1/2 w-fit object-contain object-right-top'
            />
          </div>
        </div>
      </section>
    </main>
  );
}
