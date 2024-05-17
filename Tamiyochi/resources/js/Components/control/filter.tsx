import { router } from '@inertiajs/react';
import { Command, CommandInput } from 'cmdk';
import { ChevronDown, X } from 'lucide-react';
import queryString from 'query-string';
import React from 'react';

import { cn } from '@/Libs/utils';
import { PaginatedQuery } from '@/Types/entities/page';

import { Badge } from '../ui/badge';
import { CommandGroup, CommandItem } from '../ui/command';
import { ScrollArea, ScrollBar } from '../ui/scroll-area';

export type FilterData = {
  id: string;
  value: string;
};

export interface FilterProps {
  baseUrl: string;
  filterData: FilterData[];
  maxFilter?: number;
  placeholder?: string;
  className?: string;
}

export default function Filter({
  baseUrl,
  filterData,
  maxFilter,
  placeholder = 'Select Filter',
  className,
}: FilterProps) {
  const inputRef = React.useRef<HTMLInputElement>(null);
  const [inputValue, setInputValue] = React.useState('');
  const [open, setOpen] = React.useState(false);

  const query = queryString.parse(location.search, {
    arrayFormat: 'index',
  }) as PaginatedQuery;

  const filterQuery =
    query.filter?.map((item) =>
      filterData.find(({ id }) => id === item.toString()),
    ) ?? [];

  const selectablesFilter = filterData.filter(
    (item) => !filterQuery.includes(item),
  );

  const revalidate = (filterQuery: (FilterData | undefined)[]) => {
    const queryParams = queryString.stringify(
      { ...query, filter: filterQuery.map((item) => item?.id) },
      { arrayFormat: 'index' },
    );

    router.visit(`${baseUrl}?${queryParams}`, { replace: true });
  };

  const handleUnselect = (deletedItem?: FilterData) => {
    revalidate(filterQuery.filter((item) => item !== deletedItem));
  };

  const handleSelect = (item?: FilterData) => {
    filterQuery.push(item);
    revalidate(filterQuery);
  };

  const handleKeyDown = (e: React.KeyboardEvent<HTMLDivElement>) => {
    const input = inputRef.current;
    if (!input) return;
    if (input.value === '' && (e.key === 'Delete' || e.key === 'Backspace')) {
      handleUnselect(filterQuery[filterQuery.length - 1]);
    }
    if (e.key === 'Escape') input.blur();
  };

  return (
    <Command
      onKeyDown={handleKeyDown}
      className={cn(
        'overflow-x-clip overflow-y-visible bg-transparent',
        className,
      )}
    >
      <div className='group border border-input h-10 flex items-center px-3 text-sm ring-offset-background rounded-md focus-within:ring-2 focus-within:ring-ring focus-within:ring-offset-2'>
        <ScrollArea className='w-full'>
          <div className='flex-1 flex py-2 items-center gap-1.5 overflow-hidden'>
            {filterQuery?.map((item) => (
              <Badge key={item?.id} variant='secondary' className='w-max'>
                {item?.value}{' '}
                <button
                  className='ring-offset-background rounded-full outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2'
                  onKeyDown={(e) => {
                    if (e.key === 'Enter') {
                      handleUnselect(item);
                    }
                  }}
                  onMouseDown={(e) => {
                    e.preventDefault();
                    e.stopPropagation();
                  }}
                  onClick={() => handleUnselect(item)}
                >
                  <X className='h-3 w-3 text-muted-foreground hover:text-foreground' />
                </button>
              </Badge>
            ))}

            {(!maxFilter || filterQuery.length < maxFilter) && (
              <CommandInput
                ref={inputRef}
                value={inputValue}
                onValueChange={setInputValue}
                onBlur={() => setOpen(false)}
                onFocus={() => setOpen(true)}
                placeholder={placeholder}
                className='bg-transparent outline-none placeholder:text-muted-foreground flex-1'
              />
            )}
          </div>
          <ScrollBar orientation='horizontal' />
        </ScrollArea>

        <ChevronDown
          onClick={() => {
            setOpen(true);
            inputRef.current?.focus();
          }}
          className='h-4 w-4 cursor-pointer'
        />
      </div>

      <div className='relative mt-2'>
        {open && selectablesFilter.length > 0 ? (
          <div className='absolute w-full z-10 top-0 rounded-md border bg-popover text-popover-foreground shadow-md outline-none animate-in'>
            <CommandGroup className='h-full overflow-auto'>
              {selectablesFilter.map((item) => {
                return (
                  <CommandItem
                    key={item.id}
                    onMouseDown={(e) => {
                      e.preventDefault();
                      e.stopPropagation();
                    }}
                    onSelect={(_value) => {
                      setInputValue('');
                      handleSelect(item);
                    }}
                    className={'cursor-pointer'}
                  >
                    {item.value}
                  </CommandItem>
                );
              })}
            </CommandGroup>
          </div>
        ) : null}
      </div>
    </Command>
  );
}
