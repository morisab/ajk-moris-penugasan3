import React from 'react';

export function useIsOverflow<T extends HTMLElement>(
  ref: React.RefObject<T>,
): [boolean] {
  const [isOverflow, setIsOverflow] = React.useState(false);

  React.useEffect(() => {
    const { current } = ref;

    if (!current) return;

    const hasOverflow = current.scrollHeight > current.clientHeight;
    setIsOverflow(hasOverflow);
  }, [ref]);

  return [isOverflow];
}
