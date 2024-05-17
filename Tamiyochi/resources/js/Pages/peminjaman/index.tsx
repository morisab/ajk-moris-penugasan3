import React from 'react';

import PeminjamanMangaCard from '@/Components/card/peminjaman/manga';
import DashboardLayout from '@/Layouts/dashboard';
import { PageProps } from '@/Types/entities/page';
import { SeriTerpinjam } from '@/Types/entities/peminjaman';

export default function PeminjamanPage({
  success,
  data,
  user,
}: PageProps<SeriTerpinjam[]>) {
  return (
    <DashboardLayout user={user} className='space-y-8'>
      <section className='w-full max-w-[1440px] flex flex-col items-end gap-4 md:gap-8 px-3 md:px-12 py-4 md:py-8'>
        {success && (
          <div className='w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-8'>
            {data &&
              data.map((seriTerpinjam, index) => (
                <PeminjamanMangaCard key={index} {...seriTerpinjam} />
              ))}
          </div>
        )}
      </section>
    </DashboardLayout>
  );
}
