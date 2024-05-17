import { cn } from '@/Libs/utils';
import { Genre, Penerbit, Penulis } from '@/Types/entities/seri';

import Typography from '../../ui/typography';

export interface SeriStatisticCardProps {
  tahun_terbit: string;
  volume: number;
  penerbit?: Penerbit;
  penulis?: Penulis[];
  genre?: Genre[];
  className?: string;
}

export default function SeriStatisticCard({
  tahun_terbit,
  volume,
  penerbit,
  penulis,
  genre,
  className,
}: SeriStatisticCardProps) {
  return (
    <div className={cn('p-3 space-y-3 rounded-lg bg-background', className)}>
      <div className='space-y-0'>
        <Typography variant='body-14/24' weight='semibold'>
          Tahun Terbit
        </Typography>
        <Typography variant='body-14/24' className='text-muted-foreground/50'>
          {tahun_terbit.split('/')[2]}
        </Typography>
      </div>

      <div className='space-y-0'>
        <Typography variant='body-14/24' weight='semibold'>
          Total Volume
        </Typography>
        <Typography variant='body-14/24' className='text-muted-foreground/50'>
          {volume} Volume
        </Typography>
      </div>

      <div className='space-y-0'>
        <Typography variant='body-14/24' weight='semibold'>
          Penerbit
        </Typography>
        <Typography variant='body-14/24' className='text-muted-foreground/50'>
          {penerbit?.nama ?? 'Tidak diketahui'}
        </Typography>
      </div>

      <div className='space-y-0'>
        <Typography variant='body-14/24' weight='semibold'>
          Penulis
        </Typography>
        {penulis ? (
          penulis.map(({ id, nama_depan, nama_belakang }) => (
            <Typography
              key={id}
              variant='body-14/24'
              className='text-muted-foreground/50'
            >
              {nama_belakang}, {nama_depan}
            </Typography>
          ))
        ) : (
          <Typography variant='body-14/24' className='text-muted-foreground/50'>
            Tidak diketahui
          </Typography>
        )}
      </div>

      <div className='space-y-0'>
        <Typography variant='body-14/24' weight='semibold'>
          Genre
        </Typography>
        {genre ? (
          genre.map(({ id, nama }) => (
            <Typography
              key={id}
              variant='body-14/24'
              className='text-muted-foreground/50'
            >
              {nama}
            </Typography>
          ))
        ) : (
          <Typography variant='body-14/24' className='text-muted-foreground/50'>
            Tidak diketahui
          </Typography>
        )}
      </div>
    </div>
  );
}
