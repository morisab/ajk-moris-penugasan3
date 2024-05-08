import { router } from '@inertiajs/react';
import { Minus, Plus, Trash } from 'lucide-react';
import React from 'react';

import { Button } from '@/Components/ui/button';
import Typography from '@/Components/ui/typography';
import { cn } from '@/Libs/utils';
import { Cart } from '@/Types/entities/cart';

export interface CartVolumeCardProps extends Cart {}

export default function CartVolumeCard({
  volume_id,
  foto,
  harga_sewa,
  harga_sub_total,
  judul_seri,
  jumlah_sewa,
  jumlah_tersedia,
  volume,
}: CartVolumeCardProps) {
  const handleIncreaseCartVolume = () => {
    const payload = {
      volume_id,
      jumlah: 1,
    };
    router.post(route('cart.create'), payload);
  };

  const handleDecreaseCartVolume = () => {
    router.delete(route('cart.delete', { id: volume_id }));
  };

  const handleDeleteCartVolume = () => {
    router.delete(route('cart.delete.volume', { id: volume_id }));
  };

  return (
    <div className='flex rounded-lg overflow-hidden bg-muted'>
      <div className='w-24 relative flex justify-center items-center'>
        <img
          src={foto}
          alt='manga-cover'
          width={200}
          height={300}
          onError={({ currentTarget }) => {
            currentTarget.onerror = null;
            currentTarget.src =
              'https://downloadwap.com/thumbs2/wallpapers/2022/p2/abstract/47/e9ne9732.jpg';
          }}
          className='absolute w-full h-full object-cover brightness-50'
        />
        <Typography
          variant='h2-30/36'
          weight='semibold'
          className='relative text-background'
        >
          {volume}
        </Typography>
      </div>

      <div className='p-6 flex-1 flex justify-between items-center'>
        <div className='space-y-0'>
          <Typography
            variant='body-14/24'
            weight='semibold'
            className='flex gap-1.5'
          >
            <span>{judul_seri}</span>•<span>Volume {volume}</span>
          </Typography>
          <Typography variant='body-14/24' className='text-muted-foreground/50'>
            Rp. {harga_sewa.toLocaleString('id-ID')} / 7 hari
          </Typography>
        </div>

        <div className='flex gap-6'>
          <div className='space-y-1.5'>
            <div className='flex justify-between'>
              <Typography
                variant='body-14/24'
                className='text-muted-foreground/50'
              >
                Tersisa
              </Typography>
              <Typography variant='body-14/24'>
                {jumlah_tersedia} Vol
              </Typography>
            </div>

            <Button
              size='sm'
              variant='outline'
              className='flex justify-between gap-4 p-1 border border-primary rounded-md cursor-default bg-muted'
            >
              <Minus
                onClick={() => handleDecreaseCartVolume()}
                className={cn(
                  'rounded-sm hover:bg-muted-foreground/10 cursor-pointer',
                  jumlah_sewa <= 1 &&
                    'pointer-events-none text-muted-foreground/50',
                )}
              />
              <Typography variant='body-14/24' weight='bold'>
                {jumlah_sewa}
              </Typography>
              <Plus
                onClick={() => handleIncreaseCartVolume()}
                className={cn(
                  'rounded-sm hover:bg-muted-foreground/10 cursor-pointer',
                  jumlah_sewa >= jumlah_tersedia &&
                    'pointer-events-none text-muted-foreground/50',
                )}
              />
            </Button>
          </div>

          <div className='space-y-1.5'>
            <div className='flex justify-between'>
              <Typography
                variant='body-14/24'
                className='text-muted-foreground/50'
              >
                Subtotal
              </Typography>
              <Typography variant='body-14/24'>
                Rp. {harga_sub_total.toLocaleString('id-ID')}
              </Typography>
            </div>

            <Button
              size='sm'
              variant='destructive'
              onClick={() => handleDeleteCartVolume()}
              className='w-40 py-1 rounded-md'
            >
              <Trash className='mr-2 w-4 h-4' />
              Pinjaman
            </Button>
          </div>
        </div>
      </div>
    </div>
  );
}
