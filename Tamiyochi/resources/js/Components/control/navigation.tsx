import { router } from '@inertiajs/react';
import { ChevronsLeft, ChevronsRight } from 'lucide-react';
import queryString from 'query-string';

import { cn } from '@/Libs/utils';
import { PaginatedQuery } from '@/Types/entities/page';

import { Button } from '../ui/button';

export interface NavigationProps {
  baseUrl: string;
  pageCount?: number;
  maxPage?: number;
}

export default function Navigation({
  baseUrl,
  pageCount = 5,
  maxPage = 1,
}: NavigationProps) {
  const query = queryString.parse(location.search, {
    arrayFormat: 'index',
    parseNumbers: true,
  }) as PaginatedQuery;

  const [page, perPage] = [query.page ?? 1, query.per_page];

  const handleNavigation = (page: number, perPage?: number) => {
    const queryParams = queryString.stringify(
      { ...query, page, per_page: perPage },
      { arrayFormat: 'index' },
    );

    router.visit(`${baseUrl}?${queryParams}`, { replace: true });
  };

  const pages = [...Array(maxPage)]
    .map((_, i) => i + 1)
    .slice(
      page <= pageCount >> 2
        ? 0
        : page > maxPage - pageCount + 1
          ? maxPage - pageCount
          : page - (pageCount >> 1),
      page < pageCount >> 1 ? pageCount : page + pageCount - (pageCount >> 1),
    );

  return (
    <div className='flex gap-1.5'>
      <Button
        size='icon'
        disabled={page == 1}
        onClick={() => handleNavigation(1, perPage)}
      >
        <ChevronsLeft className='h-4 w-4' />
      </Button>
      {pages.map((pageNumber, id) => (
        <Button
          key={id}
          variant={page == pageNumber ? 'default' : 'outline'}
          size='icon'
          onClick={() => handleNavigation(pageNumber, perPage)}
          className={cn(page == pageNumber && 'pointer-events-none')}
        >
          {pageNumber}
        </Button>
      ))}
      <Button
        size='icon'
        disabled={page == maxPage}
        onClick={() => handleNavigation(maxPage, perPage)}
      >
        <ChevronsRight className='h-4 w-4' />
      </Button>
    </div>
  );
}
