import { router } from '@inertiajs/react';
import { Check, ChevronDown, X } from 'lucide-react';
import React from 'react';
import { useFormContext } from 'react-hook-form';

import { Badge } from '@/Components/ui/badge';
import { Button } from '@/Components/ui/button';
import {
  Command,
  CommandEmpty,
  CommandGroup,
  CommandInput,
  CommandItem,
} from '@/Components/ui/command';
import {
  FormControl,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from '@/Components/ui/form';
import {
  Popover,
  PopoverContent,
  PopoverTrigger,
} from '@/Components/ui/popover';
import { ScrollArea, ScrollBar } from '@/Components/ui/scroll-area';
import Typography from '@/Components/ui/typography';
import { cn } from '@/Libs/utils';
import { SeriRequest } from '@/Schemas/seri';
import { Penulis, SeriCreateResponse } from '@/Types/entities/seri';

export interface SeriCreateDetailArrayCardProps extends SeriCreateResponse {}

export default function SeriCreateDetailArrayCard({
  genres,
  penerbit,
  penulis,
}: SeriCreateDetailArrayCardProps) {
  const form = useFormContext<SeriRequest>();
  const { control } = form;

  const filteredPenerbit = penerbit.filter(({ nama }) => nama !== '');

  const getNamaPenulis = (penulis?: Penulis) =>
    penulis ? `${penulis.nama_depan} ${penulis.nama_belakang}` : undefined;

  return (
    <div className='p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 rounded-lg bg-background'>
      <FormField
        control={control}
        name='penerbit_id'
        render={({ field }) => {
          const [searchedPenerbit, setSearchedPenerbit] = React.useState('');
          const handleCreatePenerbit = () =>
            router.post(route('seri.penerbit.create'), {
              nama: searchedPenerbit,
            });

          return (
            <FormItem className='flex flex-col'>
              <FormLabel>Penerbit Manga</FormLabel>
              <Popover>
                <PopoverTrigger asChild>
                  <FormControl>
                    <Button
                      variant='outline'
                      role='combobox'
                      className='justify-between'
                    >
                      {field.value
                        ? filteredPenerbit.find(({ id }) => id === field.value)
                            ?.nama
                        : 'Pilih Penerbit'}
                      <ChevronDown className='ml-2 h-4 w-4 shrink-0' />
                    </Button>
                  </FormControl>
                </PopoverTrigger>

                <PopoverContent align='start' className='p-0'>
                  <Command>
                    <CommandInput
                      value={searchedPenerbit}
                      onValueChange={setSearchedPenerbit}
                      placeholder='Cari Penerbit'
                    />
                    <CommandEmpty>
                      <Typography
                        as='p'
                        onClick={handleCreatePenerbit}
                        variant='small-14/14'
                        className='pl-8 pr-3 py-2 h-8 flex items-center rounded-sm hover:bg-muted hover:text-foreground/75 cursor-default'
                      >
                        Tambah penerbit {searchedPenerbit}
                      </Typography>
                    </CommandEmpty>
                    <ScrollArea className='h-96'>
                      <CommandGroup>
                        {filteredPenerbit.map(({ id, nama }) => (
                          <CommandItem
                            value={nama}
                            key={id}
                            onSelect={() => form.setValue('penerbit_id', id)}
                          >
                            <Check
                              className={cn(
                                'mr-2 h-4 w-4',
                                field.value === id
                                  ? 'opacity-100'
                                  : 'opacity-0',
                              )}
                            />
                            {nama}
                          </CommandItem>
                        ))}
                        {!!searchedPenerbit &&
                          !penerbit
                            .map(({ nama }) => nama?.toLowerCase())
                            .includes(searchedPenerbit.toLowerCase()) && (
                            <CommandItem
                              value={searchedPenerbit}
                              id='0'
                              onSelect={handleCreatePenerbit}
                              className='pl-8'
                            >
                              Tambah penerbit {searchedPenerbit}
                            </CommandItem>
                          )}
                      </CommandGroup>
                    </ScrollArea>
                  </Command>
                </PopoverContent>
              </Popover>
              <FormMessage />
            </FormItem>
          );
        }}
      />

      <FormField
        control={control}
        name='penulis_id'
        render={({ field }) => {
          const selectedPenulis = field.value ?? [];
          const removePenulis = (penulis_id: number) =>
            form.setValue('penulis_id', [
              ...selectedPenulis.filter((id) => id !== penulis_id),
            ]);
          const addPenulis = (penulis_id: number) =>
            form.setValue('penulis_id', [penulis_id, ...selectedPenulis]);
          const [searchedPenulis, setSearchedPenulis] = React.useState('');
          const handleCreatePenulis = () => {
            const namaPenulis = searchedPenulis.split(' ');

            router.post(route('seri.penulis.create'), {
              nama_depan: namaPenulis[0],
              nama_belakang: namaPenulis.length > 1 ? namaPenulis[1] : '',
              peran: 'penulis',
            });
          };

          return (
            <FormItem className='w-full flex flex-col'>
              <FormLabel>Penulis Manga</FormLabel>
              <Popover>
                <PopoverTrigger asChild>
                  <FormControl>
                    <Button
                      variant='outline'
                      role='combobox'
                      className='justify-between py-0'
                    >
                      <ScrollArea className='flex-1'>
                        <div className='flex-1 flex items-center gap-1.5 py-2 overflow-hidden'>
                          {selectedPenulis.length > 0
                            ? penulis
                                .filter(({ id }) =>
                                  selectedPenulis.includes(id),
                                )
                                .map((penulis) => (
                                  <Badge
                                    key={penulis.id}
                                    onClick={(e) => {
                                      e.stopPropagation();
                                      removePenulis(penulis.id);
                                    }}
                                  >
                                    {getNamaPenulis(penulis)}
                                    <X className='ml-1 h-3 w-3' />
                                  </Badge>
                                ))
                            : 'Pilih Penulis'}
                        </div>
                        <ScrollBar orientation='horizontal' />
                      </ScrollArea>
                      <ChevronDown className='ml-2 h-4 w-4 shrink-0' />
                    </Button>
                  </FormControl>
                </PopoverTrigger>

                <PopoverContent align='start' className='p-0'>
                  <Command>
                    <CommandInput
                      value={searchedPenulis}
                      onValueChange={setSearchedPenulis}
                      placeholder='Cari Penulis'
                    />
                    <ScrollArea className='h-96'>
                      <CommandEmpty className='p-1'>
                        <Typography
                          as='p'
                          onClick={handleCreatePenulis}
                          variant='small-14/14'
                          className='pl-8 pr-3 py-2 h-8 flex items-center rounded-sm hover:bg-muted hover:text-foreground/75 cursor-default'
                        >
                          Tambah penulis {searchedPenulis}
                        </Typography>
                      </CommandEmpty>
                      <CommandGroup>
                        {penulis.map(({ id, nama_depan, nama_belakang }) => (
                          <CommandItem
                            value={`${nama_depan} ${nama_belakang}`}
                            key={id}
                            onSelect={() =>
                              selectedPenulis.includes(id)
                                ? removePenulis(id)
                                : addPenulis(id)
                            }
                          >
                            <Check
                              className={cn(
                                'mr-2 h-4 w-4',
                                selectedPenulis.includes(id)
                                  ? 'opacity-100'
                                  : 'opacity-0',
                              )}
                            />
                            {`${nama_depan} ${nama_belakang}`}
                          </CommandItem>
                        ))}
                        {!!searchedPenulis &&
                          !penulis
                            .map(
                              (_penulis) =>
                                getNamaPenulis(_penulis)?.toLowerCase(),
                            )
                            .includes(searchedPenulis.toLowerCase()) && (
                            <CommandItem
                              value={searchedPenulis}
                              id='0'
                              onSelect={handleCreatePenulis}
                              className='pl-8'
                            >
                              Tambah penulis {searchedPenulis}
                            </CommandItem>
                          )}
                      </CommandGroup>
                    </ScrollArea>
                  </Command>
                </PopoverContent>
              </Popover>
              <FormMessage />
            </FormItem>
          );
        }}
      />

      <FormField
        control={control}
        name='genre_id'
        render={({ field }) => {
          const selectedGenre = field.value ?? [];
          const removeGenre = (genre_id: number) =>
            form.setValue('genre_id', [
              ...selectedGenre.filter((id) => id !== genre_id),
            ]);
          const addGenre = (genre_id: number) =>
            form.setValue('genre_id', [genre_id, ...selectedGenre]);
          const [searchedGenre, setSearchedGenre] = React.useState('');
          const handleCreateGenre = () =>
            router.post(route('seri.genre.create'), {
              nama: searchedGenre,
            });

          return (
            <FormItem className='w-full flex flex-col'>
              <FormLabel>Genre Manga</FormLabel>
              <Popover>
                <PopoverTrigger asChild>
                  <FormControl>
                    <Button
                      variant='outline'
                      role='combobox'
                      className='justify-between py-0'
                    >
                      <ScrollArea className='flex-1'>
                        <div className='flex-1 flex items-center gap-1.5 py-2 overflow-hidden'>
                          {selectedGenre.length > 0
                            ? genres
                                .filter(({ id }) => selectedGenre.includes(id))
                                .map((genre) => (
                                  <Badge
                                    key={genre.id}
                                    onClick={(e) => {
                                      e.stopPropagation();
                                      removeGenre(genre.id);
                                    }}
                                  >
                                    {genre.nama}
                                    <X className='ml-1 h-3 w-3' />
                                  </Badge>
                                ))
                            : 'Pilih Genre'}
                        </div>
                        <ScrollBar orientation='horizontal' />
                      </ScrollArea>
                      <ChevronDown className='ml-2 h-4 w-4 shrink-0' />
                    </Button>
                  </FormControl>
                </PopoverTrigger>

                <PopoverContent align='start' className='p-0'>
                  <Command>
                    <CommandInput
                      value={searchedGenre}
                      onValueChange={setSearchedGenre}
                      placeholder='Cari Genre'
                    />
                    <ScrollArea className='h-96'>
                      <CommandEmpty className='p-1'>
                        <Typography
                          as='p'
                          onClick={handleCreateGenre}
                          variant='small-14/14'
                          className='pl-8 pr-3 py-2 h-8 flex items-center rounded-sm hover:bg-muted hover:text-foreground/75 cursor-default'
                        >
                          Tambah genre {searchedGenre}
                        </Typography>
                      </CommandEmpty>
                      <CommandGroup>
                        {genres.map(({ id, nama }) => (
                          <CommandItem
                            value={nama}
                            key={id}
                            onSelect={() =>
                              selectedGenre.includes(id)
                                ? removeGenre(id)
                                : addGenre(id)
                            }
                          >
                            <Check
                              className={cn(
                                'mr-2 h-4 w-4',
                                selectedGenre.includes(id)
                                  ? 'opacity-100'
                                  : 'opacity-0',
                              )}
                            />
                            {nama}
                          </CommandItem>
                        ))}
                        {!!searchedGenre &&
                          !genres
                            .map(({ nama }) => nama.toLowerCase())
                            .includes(searchedGenre.toLowerCase()) && (
                            <CommandItem
                              value={searchedGenre}
                              id='0'
                              onSelect={handleCreateGenre}
                              className='pl-8'
                            >
                              Tambah genre {searchedGenre}
                            </CommandItem>
                          )}
                      </CommandGroup>
                    </ScrollArea>
                  </Command>
                </PopoverContent>
              </Popover>
              <FormMessage />
            </FormItem>
          );
        }}
      />
    </div>
  );
}
