import { Link, router } from '@inertiajs/react';
import { AvatarImage } from '@radix-ui/react-avatar';
import { LogOut, ShoppingCart } from 'lucide-react';
import React from 'react';

import { cn } from '@/Libs/utils';
import { User } from '@/Types/entities/page';

import { Avatar, AvatarFallback } from '../ui/avatar';
import { Button } from '../ui/button';
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from '../ui/dropdown-menu';
import Typography from '../ui/typography';

export interface NavbarProps extends React.ComponentPropsWithoutRef<'nav'> {
  user?: User;
}

export default function Navbar({ user, className, ...rest }: NavbarProps) {
  const endpoint = location.href.split('?')[0];

  const handleLogout = () => router.post(route('auth.logout'));

  return (
    <nav
      className={cn(
        'fixed w-full px-3 md:px-12 py-3 flex justify-between items-center bg-foreground z-50 rounded-b-lg',
        className,
      )}
      {...rest}
    >
      <Link href={route('seri.index')} className='flex items-center gap-2'>
        <img
          src='/images/logo.png'
          alt='logo'
          width={640}
          height={640}
          className='w-10 h-10'
        />
        <Typography
          as='h3'
          variant='h4-20/28'
          weight='semibold'
          className='text-background'
        >
          Tamiyochi
        </Typography>
      </Link>

      <div className='hidden md:flex gap-4 items-center'>
        <Link
          href={route('seri.index')}
          className={cn(
            endpoint.includes(route('seri.index')) && 'pointer-events-none',
          )}
        >
          <Typography
            as='h1'
            variant='h3-24/32'
            weight='semibold'
            className={cn(
              endpoint.includes(route('seri.index'))
                ? 'text-background'
                : 'text-background/50 hover:text-background transition-colors',
            )}
          >
            Koleksi Manga
          </Typography>
        </Link>

        {user && (
          <Link
            href={route('peminjaman.index')}
            className={cn(
              endpoint.includes(route('peminjaman.index')) &&
                'pointer-events-none',
            )}
          >
            <Typography
              as='h1'
              variant='h3-24/32'
              weight='semibold'
              className={cn(
                endpoint.includes(route('peminjaman.index'))
                  ? 'text-background'
                  : 'text-background/50 hover:text-background transition-colors',
              )}
            >
              Manga Terpinjam
            </Typography>
          </Link>
        )}
      </div>

      {!user ? (
        <div className='hidden md:flex gap-4 items-center'>
          <Link href={route('auth.login.index')}>
            <Button variant='secondary'>Sign In</Button>
          </Link>
          <Link href={route('auth.register.index')}>
            <Button>Sign Up</Button>
          </Link>
        </div>
      ) : (
        <div className='hidden md:flex gap-4 items-center'>
          <Link href={route('cart.index')}>
            <Button
              size='icon'
              variant='ghost'
              className='text-background border-background'
            >
              <ShoppingCart className='w-4 h-4' />
            </Button>
          </Link>

          <DropdownMenu modal={false}>
            <DropdownMenuTrigger asChild>
              <Button variant='ghost' className='relative h-8 w-8 rounded-full'>
                <Avatar className='h-8 w-8'>
                  <AvatarImage
                    src={user.image_url}
                    alt='profile'
                    className='w-full h-full object-cover'
                  />
                  <AvatarFallback>
                    {user.name
                      .split(' ')
                      .map((name) => name[0])
                      .join('')}
                  </AvatarFallback>
                </Avatar>
              </Button>
            </DropdownMenuTrigger>

            <DropdownMenuContent className='w-56' align='end' forceMount>
              <DropdownMenuLabel className='space-y-1'>
                <Typography variant='small-14/14' className='truncate'>
                  {user.name}
                </Typography>
                <Typography
                  variant='detail-12/20'
                  weight='normal'
                  className='leading-none text-muted-foreground/70'
                >
                  {user.email}
                </Typography>
              </DropdownMenuLabel>
              {/* <DropdownMenuSeparator />
              <DropdownMenuItem>
                <UserIcon className='mr-2 w-4 h-4 text-foreground' />
                <Typography as='span' variant='small-14/14' weight='medium'>
                  Profile
                </Typography>
              </DropdownMenuItem> */}
              <DropdownMenuSeparator />
              <DropdownMenuItem onClick={() => handleLogout()}>
                <LogOut className='mr-2 w-4 h-4 text-destructive' />
                <Typography
                  as='span'
                  variant='small-14/14'
                  weight='medium'
                  className='text-destructive'
                >
                  Log out
                </Typography>
              </DropdownMenuItem>
            </DropdownMenuContent>
          </DropdownMenu>
        </div>
      )}
    </nav>
  );
}
