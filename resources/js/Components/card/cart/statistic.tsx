import { router } from '@inertiajs/react';

import { Button } from '@/Components/ui/button';
import Typography from '@/Components/ui/typography';
import { cn } from '@/Libs/utils';

export interface CartStatisticCardProps {
  total_pinjaman: number;
  total_harga_sewa: number;
  className?: string;
}

export default function CartStatisticCard({
  total_pinjaman,
  total_harga_sewa,
  className,
}: CartStatisticCardProps) {
  const handlePinjam = () => {
    const payload = {
      amount: total_harga_sewa,
    };

    router.post(route('peminjaman.create'), payload);
  };

  return (
    <div className={cn('p-6 space-y-6 rounded-lg bg-muted', className)}>
      <Typography variant='h2-30/36' weight='bold'>
        Ringkasan Pinjaman
      </Typography>

      <div className='space-y-1.5'>
        <div className='flex justify-between'>
          <Typography variant='p-16/24' className='text-muted-foreground/50'>
            Total Pinjaman
          </Typography>
          <Typography variant='p-16/24' weight='semibold'>
            {total_pinjaman} Manga
          </Typography>
        </div>

        <div className='flex justify-between'>
          <Typography variant='p-16/24' className='text-muted-foreground/50'>
            Total Harga Sewa
          </Typography>
          <Typography variant='p-16/24' weight='semibold'>
            Rp. {total_harga_sewa.toLocaleString('id-ID')}
          </Typography>
        </div>
      </div>

      {/* <a
        href='https://checkout-staging.xendit.co/v2/6564458e1bb390687c3a72c3'
        target='_blank'
        className='block'
      > */}
      <Button onClick={() => handlePinjam()} className='w-full'>
        Pinjam
      </Button>
      {/* </a> */}
    </div>
  );
}
