import { Trash2 } from 'lucide-react';
import { useFormContext } from 'react-hook-form';

import { Button } from '@/Components/ui/button';
import {
  FormControl,
  FormField,
  FormItem,
  FormLabel,
} from '@/Components/ui/form';
import { Input } from '@/Components/ui/input';
import Typography from '@/Components/ui/typography';
import { SeriRequest } from '@/Schemas/seri';

export interface SeriCreateVolumeCardProps {
  index: number;
  onRemove: () => void;
}

export default function SeriCreateVolumeCard({
  index,
  onRemove,
}: SeriCreateVolumeCardProps) {
  const { control } = useFormContext<SeriRequest>();

  return (
    <div className='flex rounded-lg bg-background'>
      <div className='p-3 w-24 flex items-center justify-center bg-muted/50'>
        <FormField
          control={control}
          name={`volume.${index}.volume`}
          render={({ field }) => (
            <Typography variant='h2-30/36' weight='semibold'>
              {field.value}
            </Typography>
          )}
        />
      </div>

      <div className='p-6 flex-1 flex items-end gap-6'>
        <FormField
          control={control}
          name={`volume.${index}.harga_sewa`}
          render={({ field }) => (
            <FormItem className='w-full'>
              <FormLabel>Harga Sewa</FormLabel>
              <FormControl>
                <Input placeholder='Masukkan harga sewa / 7 hari' {...field} />
              </FormControl>
            </FormItem>
          )}
        />

        <FormField
          control={control}
          name={`volume.${index}.jumlah_tersedia`}
          render={({ field }) => (
            <FormItem className='w-full'>
              <FormLabel>Jumlah Tersedia</FormLabel>
              <FormControl>
                <Input
                  placeholder='Masukkan jumlah volume tersedia'
                  {...field}
                />
              </FormControl>
            </FormItem>
          )}
        />

        <Button
          type='button'
          size='icon'
          variant='destructive'
          onClick={onRemove}
          disabled={index === 0}
          className='shrink-0'
        >
          <Trash2 className='w-4 h-4' />
        </Button>
      </div>
    </div>
  );
}
