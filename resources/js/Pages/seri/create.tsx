import { zodResolver } from '@hookform/resolvers/zod';
import { router } from '@inertiajs/react';
import { format } from 'date-fns';
import { serialize } from 'object-to-formdata';
import React from 'react';
import { useForm } from 'react-hook-form';

import { Button } from '@/Components/ui/button';
import { Form } from '@/Components/ui/form';
import SeriCreateDetailContainer from '@/Containers/seri/create-detail';
import SeriCreateVolumeContainer from '@/Containers/seri/create-volume';
import DashboardLayout from '@/Layouts/dashboard';
import { cn } from '@/Libs/utils';
import { SeriRequest, SeriSchema } from '@/Schemas/seri';
import { PageProps } from '@/Types/entities/page';
import { SeriCreateResponse } from '@/Types/entities/seri';

export default function SeriCreatePage({
  success,
  data,
  user,
}: PageProps<SeriCreateResponse>) {
  const [page, setPage] = React.useState<'detail' | 'volume'>('detail');

  const form = useForm<SeriRequest>({
    resolver: zodResolver(SeriSchema),
    defaultValues: {
      judul: '',
      sinopsis: '',
      volume: [{ volume: 1, harga_sewa: '', jumlah_tersedia: '' }],
    },
  });

  const { trigger, handleSubmit } = form;

  const onNext = () => {
    trigger([
      'judul',
      'sinopsis',
      'tahun_terbit',
      'foto',
      'penerbit_id',
      'penulis_id',
      'genre_id',
    ]).then((res) => res && setPage('volume'));
  };
  const onSubmit = (data: SeriRequest) => {
    const formData = serialize(
      {
        ...data,
        foto: data.foto?.[0],
        tahun_terbit: format(data.tahun_terbit, 'MM/dd/yyyy'),
      },
      { indices: true },
    );
    router.post(route('seri.create'), formData);
  };

  return (
    <DashboardLayout user={user} className='bg-muted'>
      <section className='w-full max-w-[1440px] flex flex-col items-end gap-4 md:gap-8 px-3 md:px-12 py-4 md:py-8'>
        <div className='w-full flex items-start gap-8'>
          <div className='p-3 space-y-3 bg-background rounded-lg'>
            <Button
              variant='ghost'
              onClick={() => setPage('detail')}
              className={cn(
                'w-full flex justify-start',
                page === 'detail' && 'bg-muted',
              )}
            >
              Detail Manga
            </Button>
            <Button
              variant='ghost'
              onClick={onNext}
              className={cn(
                'w-full flex justify-start',
                page === 'volume' && 'bg-muted',
              )}
            >
              Volume Tersedia
            </Button>
          </div>

          <Form {...form}>
            <form
              encType='multipart/formdata'
              onSubmit={handleSubmit(onSubmit)}
              className='grow'
            >
              {success && data && page === 'detail' && (
                <SeriCreateDetailContainer onNext={onNext} {...data} />
              )}
              {success && data && page === 'volume' && (
                <SeriCreateVolumeContainer />
              )}
            </form>
          </Form>
        </div>
      </section>
    </DashboardLayout>
  );
}
