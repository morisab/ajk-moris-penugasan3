import React from 'react';

import Navbar from '@/Components/control/navbar';
import { cn } from '@/Libs/utils';
import { User } from '@/Types/entities/page';
('@/Components/control/navbar');

export default function DashboardLayout({
  children,
  className,
  user,
  ...rest
}: {
  children: React.ReactNode;
  user?: User;
} & React.ComponentPropsWithoutRef<'main'>) {
  return (
    <>
      <Navbar user={user} />
      <main
        className={cn(
          'w-full min-h-screen flex flex-col items-center bg-background pt-16',
          className,
        )}
        {...rest}
      >
        {children}
      </main>
    </>
  );
}
