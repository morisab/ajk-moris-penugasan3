import { router } from '@inertiajs/react';
import { Minus, Plus } from 'lucide-react';
import React from 'react';

import { cn } from '@/Libs/utils';
import { Volume } from '@/Types/entities/seri';

import { Button } from '../../ui/button';
import Typography from '../../ui/typography';

export interface SeriVolumeCardProps extends Volume {}

export default function SeriVolumeCard({
  id,
  volume,
  jumlah_tersedia,
  harga_sewa,
}: SeriVolumeCardProps) {
  const [order, setOrder] = React.useState(1);

  const handleCreateCart = () => {
    const payload = {
      volume_id: id,
      jumlah: order,
    };
    router.post(route('cart.create'), payload);
  };

  return (
    <div className='flex rounded-lg bg-background'>
      <div className='p-3 w-24 flex items-center justify-center bg-muted/50'>
        <Typography variant='h2-30/36' weight='semibold'>
          {volume}
        </Typography>
      </div>

      <div className='p-6 flex-1 flex justify-between items-center'>
        <div className='space-y-0'>
          <Typography variant='body-14/24' weight='semibold'>
            Volume {volume}
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
              className='flex justify-between gap-4 p-1 border border-primary rounded-md cursor-default hover:bg-background'
            >
              <Minus
                onClick={() => setOrder((prev) => prev - 1)}
                className={cn(
                  'rounded-sm hover:bg-muted cursor-pointer',
                  order <= 1 && 'pointer-events-none text-muted-foreground/50',
                )}
              />
              <Typography variant='body-14/24' weight='bold'>
                {order}
              </Typography>
              <Plus
                onClick={() => setOrder((prev) => prev + 1)}
                className={cn(
                  'rounded-sm hover:bg-muted cursor-pointer',
                  order >= jumlah_tersedia &&
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
                Rp. {(order * harga_sewa).toLocaleString('id-ID')}
              </Typography>
            </div>

            <Button
              size='sm'
              onClick={() => handleCreateCart()}
              className='w-40 py-1 border border-primary rounded-md'
            >
              <Plus className='mr-2 w-4 h-4' />
              Pinjaman
            </Button>
          </div>
        </div>
      </div>
    </div>
  );
}
