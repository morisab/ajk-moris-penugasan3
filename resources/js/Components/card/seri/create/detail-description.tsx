import { format } from 'date-fns';
import { CalendarIcon } from 'lucide-react';
import { useFormContext } from 'react-hook-form';

import { Button } from '@/Components/ui/button';
import { Calendar } from '@/Components/ui/calendar';
import {
  FormControl,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from '@/Components/ui/form';
import { Input } from '@/Components/ui/input';
import {
  Popover,
  PopoverContent,
  PopoverTrigger,
} from '@/Components/ui/popover';
import { Textarea } from '@/Components/ui/textarea';
import { cn } from '@/Libs/utils';
import { SeriRequest } from '@/Schemas/seri';
import { Seri } from '@/Types/entities/seri';

export interface SeriCreateDetailDescriptionCardProps {
  defaultValue?: Seri;
  isUpdate?: boolean;
}

export default function SeriCreateDetailDescriptionCard({
  defaultValue,
  isUpdate = false,
}: SeriCreateDetailDescriptionCardProps) {
  const { control } = useFormContext<SeriRequest>();

  return (
    <div className='p-6 space-y-3 rounded-lg bg-background'>
      <FormField
        control={control}
        name='judul'
        render={({ field }) => (
          <FormItem>
            <FormLabel>Judul Manga</FormLabel>
            <FormControl>
              <Input placeholder='Masukkan Judul Manga' {...field} />
            </FormControl>
            <FormMessage />
          </FormItem>
        )}
      />

      <FormField
        control={control}
        name='sinopsis'
        render={({ field }) => (
          <FormItem>
            <FormLabel>Sinopsis Manga</FormLabel>
            <FormControl>
              <Textarea
                rows={5}
                placeholder='Tulis Sinopsis Manga'
                {...field}
              />
            </FormControl>
            <FormMessage />
          </FormItem>
        )}
      />

      <FormField
        control={control}
        name='tahun_terbit'
        render={({ field }) => (
          <FormItem className='flex flex-col'>
            <FormLabel>Tahun Terbit</FormLabel>
            <Popover>
              <PopoverTrigger asChild>
                <FormControl>
                  <Button
                    variant={'outline'}
                    className={cn(
                      'w-full pl-3 text-left font-normal',
                      !field.value && 'text-muted-foreground',
                    )}
                  >
                    {field.value ? (
                      format(field.value, 'PPP')
                    ) : (
                      <span>Pick a date</span>
                    )}
                    <CalendarIcon className='ml-auto h-4 w-4 opacity-50' />
                  </Button>
                </FormControl>
              </PopoverTrigger>
              <PopoverContent className='w-auto p-0' align='start'>
                <Calendar
                  mode='single'
                  selected={field.value}
                  onSelect={field.onChange}
                  disabled={(date) =>
                    date > new Date() || date < new Date('1900-01-01')
                  }
                  captionLayout='dropdown-buttons'
                  fromDate={new Date('1900-01-01')}
                  toDate={new Date()}
                />
              </PopoverContent>
            </Popover>
            <FormMessage />
          </FormItem>
        )}
      />

      <FormField
        control={control}
        name='foto'
        render={({ field: { value: _value, onChange, ...field } }) => (
          <FormItem>
            <FormLabel>Gambar Manga</FormLabel>
            {isUpdate && (
              <div className='w-56 h-80 -mt-32 rounded-xl overflow-hidden shadow-md'>
                <img
                  src={defaultValue?.foto}
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
            )}
            <div className={'flex items-center gap-2'}>
              {isUpdate && (
                <FormLabel className='shrink-0'>Ganti Gambar</FormLabel>
              )}
              <FormControl>
                <Input
                  type='file'
                  accept='image/png, image/jpg, image/jpeg'
                  onChange={(e) => onChange(e.target.files)}
                  {...field}
                />
              </FormControl>
            </div>
            <FormMessage />
          </FormItem>
        )}
      />
    </div>
  );
}
