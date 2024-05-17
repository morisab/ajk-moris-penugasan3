import { format } from 'date-fns';

import { ScrollArea } from '@/Components/ui/scroll-area';
import Typography from '@/Components/ui/typography';
import { cn } from '@/Libs/utils';
import { SeriTerpinjam } from '@/Types/entities/peminjaman';

export interface PeminjamanMangaCardProps extends SeriTerpinjam {}

export default function PeminjamanMangaCard({
  volume,
  foto,
  judul,
  penulis_nama_depan,
  penulis_nama_belakang,
  tanggal_peminjaman,
  tanggal_pengembalian,
  sisa_hari,
  status,
}: PeminjamanMangaCardProps) {
  return (
    <div className='w-full flex h-60 rounded-xl bg-muted overflow-hidden'>
      <div className='relative shrink-0 w-48 h-full cursor-pointer'>
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
          className='w-full h-full object-cover'
        />

        <div className='absolute w-full -space-y-1 px-3 py-1 5 bottom-0 bg-foreground opacity-90 group'>
          <Typography
            as='h6'
            variant='p-16/24'
            weight='bold'
            className='text-background group-hover:text-primary-foreground truncate group-hover:overflow-auto group-hover:whitespace-normal'
          >
            {judul}
          </Typography>
          <Typography
            variant='body-14/24'
            className='text-background group-hover:text-primary-foreground truncate'
          >
            {penulis_nama_belakang +
              (penulis_nama_depan && `, ${penulis_nama_depan}`)}
          </Typography>
        </div>
      </div>

      <div className='flex-1 flex flex-col overflow-hidden'>
        <div className='flex flex-col gap-1 flex-1 5 p-3 pb-0 overflow-y-hidden'>
          <Typography
            variant='body-14/24'
            weight='bold'
            className='flex gap-1.5'
          >
            <span>{volume} vol</span>
            {status !== 'EXPIRED' && (
              <>
                <span>•</span>
                <span>Tersisa {sisa_hari} hari</span>
              </>
            )}
          </Typography>
          <ScrollArea className='h-full'>
            <div className='space-y-1.5'>
              <div className='space-y-0'>
                <Typography variant='body-14/24' weight='medium'>
                  Tanggal Peminjaman
                </Typography>
                <Typography
                  variant='small-14/14'
                  className='text-muted-foreground/70'
                >
                  {format(new Date(tanggal_peminjaman), 'PPP')}
                </Typography>
              </div>

              <div className='space-y-0'>
                <Typography variant='body-14/24' weight='medium'>
                  Tanggal Pengembalian
                </Typography>
                <Typography
                  variant='small-14/14'
                  className='text-muted-foreground/70'
                >
                  {format(new Date(tanggal_pengembalian), 'PPP')}
                </Typography>
              </div>
            </div>
          </ScrollArea>
        </div>

        <div className='w-full bg-muted-foreground/20 flex gap-2.5 p-3 overflow-hidden'>
          <div
            className={cn(
              'w-full bg-foreground px-3 py-0.5 rounded-lg whitespace-nowrap',
              status === 'EXPIRED' && 'bg-destructive/70',
            )}
          >
            <Typography
              variant='body-14/24'
              weight='bold'
              className='w-full text-center text-background'
            >
              {status === 'SUCCESS' ? 'Dalam Peminjaman' : ''}
              {status === 'PENDING' ? 'Belum Dibayar' : ''}
              {status === 'EXPIRED' ? 'Harus Dikembalikan' : ''}
            </Typography>
          </div>
        </div>
      </div>
    </div>
  );
}
