import { Plus } from 'lucide-react';
import { useFieldArray, useFormContext } from 'react-hook-form';

import SeriCreateVolumeCard from '@/Components/card/seri/create/volume';
import { Button } from '@/Components/ui/button';
import Typography from '@/Components/ui/typography';
import { SeriRequest } from '@/Schemas/seri';

export interface SeriCreateVolumeContainerProps {
  isUpdate?: boolean;
}

export default function SeriCreateVolumeContainer({
  isUpdate = false,
}: SeriCreateVolumeContainerProps) {
  const { control } = useFormContext<SeriRequest>();

  const { fields, append, remove } = useFieldArray({ control, name: 'volume' });

  return (
    <div className='w-full space-y-6 overflow-x-hidden'>
      <div className='flex justify-between'>
        <Typography variant='h2-30/36' weight='bold'>
          Volume Manga
        </Typography>
        <Button type='submit'>
          {isUpdate ? 'Simpan Perubahan' : 'Tambah Manga'}
        </Button>
      </div>

      <div className='space-y-3'>
        {fields.map((item, index) => (
          <SeriCreateVolumeCard
            key={item.id}
            index={index}
            onRemove={() => remove(index)}
          />
        ))}

        <Button
          type='button'
          size='sm'
          variant='outline'
          onClick={() =>
            append({
              volume: fields.length + 1,
              harga_sewa: '',
              jumlah_tersedia: '',
            })
          }
          className='w-full gap-2'
        >
          <Plus className='w-4 h-4' />
          Tambah Volume
        </Button>
      </div>
    </div>
  );
}
