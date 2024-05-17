import { router } from '@inertiajs/react';
import { SearchIcon } from 'lucide-react';
import queryString from 'query-string';
import React from 'react';
import { FormProvider, useForm } from 'react-hook-form';

import { PaginatedQuery } from '@/Types/entities/page';

import { Input } from '../ui/input';

export interface SearchProps {
  baseUrl: string;
  placeholder?: string;
  className?: string;
}

export default function Search({
  baseUrl,
  placeholder = 'Search',
  className,
}: SearchProps) {
  const query = queryString.parse(location.search, {
    arrayFormat: 'index',
  }) as PaginatedQuery;

  const { search, ...rest } = query;

  const form = useForm<{ search: string }>();
  const { handleSubmit, register } = form;

  const handleSearch = (data: { search: string }) => {
    const queryParams = queryString.stringify(
      { ...rest, search: data.search },
      { arrayFormat: 'index', skipEmptyString: true },
    );

    router.visit(`${baseUrl}?${queryParams}`, { replace: true });
  };

  return (
    <FormProvider {...form}>
      <form onSubmit={handleSubmit(handleSearch)} className={className}>
        <div className='relative'>
          <Input
            placeholder={placeholder}
            defaultValue={search}
            className='relative pl-9'
            {...register('search')}
          />
          <div className='absolute top-0 h-full flex items-center px-3'>
            <SearchIcon className='h-4 w-4 text-muted-foreground' />
          </div>
        </div>
      </form>
    </FormProvider>
  );
}
