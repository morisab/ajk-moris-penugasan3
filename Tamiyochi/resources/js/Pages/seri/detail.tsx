import { Link, router } from '@inertiajs/react';
import React from 'react';

import SeriStatisticCard from '@/Components/card/seri/statistic';
import SeriVolumeCard from '@/Components/card/seri/volume';
import {
  AlertDialog,
  AlertDialogAction,
  AlertDialogCancel,
  AlertDialogContent,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogHeader,
  AlertDialogTitle,
  AlertDialogTrigger,
} from '@/Components/ui/alert-dialog';
import { Button } from '@/Components/ui/button';
import Typography from '@/Components/ui/typography';
import { useIsOverflow } from '@/Hooks/use-is-overflow';
import DashboardLayout from '@/Layouts/dashboard';
import { cn } from '@/Libs/utils';
import { PageProps } from '@/Types/entities/page';
import { Seri } from '@/Types/entities/seri';

export default function SeriDetailPage({ data, user }: PageProps<Seri>) {
  const [longSynopsis, setLongSynopsis] = React.useState(false);
  const synopsisRef = React.useRef<HTMLDivElement>(null);
  const [isOverflow] = useIsOverflow(synopsisRef);

  const handleDelete = () => router.delete(route('seri.delete', data?.id));

  return (
    <DashboardLayout user={user} className='relative bg-muted'>
      <div className='relative w-full h-72 -mt-10 brightness-50 z-0'>
        <img
          src={data?.foto}
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
      </div>
      <section className='relative w-full flex flex-col items-center bg-background z-10'>
        <div className='w-full max-w-[1440px] flex gap-4 md:gap-8 px-3 md:px-12 py-4 md:py-8'>
          <div className='w-56 h-80 -mt-32 rounded-xl overflow-hidden shadow-md'>
            <img
              src={data?.foto}
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
          </div>
          <div
            className={cn(
              'flex-1 relative space-y-3 h-48 overflow-hidden group',
              longSynopsis && 'h-full',
            )}
            ref={synopsisRef}
          >
            <div className='flex justify-between items-center'>
              <Typography as='h1' variant='h2-30/36' weight='bold'>
                {data?.judul}
              </Typography>
              {user?.user_type === 'admin' && (
                <div className='flex gap-2'>
                  <AlertDialog>
                    <AlertDialogTrigger asChild>
                      <Button variant='outline'>Hapus Manga</Button>
                    </AlertDialogTrigger>
                    <AlertDialogContent>
                      <AlertDialogHeader>
                        <AlertDialogTitle>Apakah Anda yakin?</AlertDialogTitle>
                        <AlertDialogDescription>
                          Anda akan menghapus manga dengan judul{' '}
                          <strong>"{data?.judul}"</strong> dari sistem data
                          Tamiyochi. Aksi ini tidak bisa diubah lagi.
                        </AlertDialogDescription>
                      </AlertDialogHeader>
                      <AlertDialogFooter>
                        <AlertDialogCancel>Batal</AlertDialogCancel>
                        <Button asChild variant='destructive'>
                          <AlertDialogAction onClick={() => handleDelete()}>
                            Hapus Manga
                          </AlertDialogAction>
                        </Button>
                      </AlertDialogFooter>
                    </AlertDialogContent>
                  </AlertDialog>

                  <Link href={route('seri.update.index', data?.id)}>
                    <Button>Edit Detail</Button>
                  </Link>
                </div>
              )}
            </div>
            <Typography variant='p-16/24' className='w-full'>
              {data?.sinopsis}
            </Typography>
            <Typography
              as='p'
              variant='body-14/24'
              weight='bold'
              onClick={() => setLongSynopsis((prev) => !prev)}
              className={cn(
                'absolute bottom-0 w-full pt-8 text-center cursor-pointer hidden',
                'bg-gradient-to-b from-transparent via-background/50 to-background/80 bg-opacity-75',
                (isOverflow || longSynopsis) && 'group-hover:block',
              )}
            >
              {longSynopsis ? 'Lihat Lebih Sedikit' : 'Lihat Lebih Banyak'}
            </Typography>
          </div>
        </div>
      </section>

      <section className='w-full max-w-[1440px] flex flex-col md:flex-row-reverse items-start gap-4 md:gap-8 px-3 md:px-12 py-4 md:py-8'>
        <div className='w-full md:flex-1 space-y-6'>
          <Typography variant='p-16/24' weight='semibold'>
            Volume Tersedia
          </Typography>

          {data &&
            data.volume.map((volume) => (
              <SeriVolumeCard key={volume.id} {...volume} />
            ))}
        </div>
        {data && (
          <SeriStatisticCard
            {...data}
            volume={data.volume.length}
            className='w-full md:w-56'
          />
        )}
      </section>
    </DashboardLayout>
  );
}
