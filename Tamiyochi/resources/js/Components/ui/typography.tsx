import { cva, VariantProps } from 'class-variance-authority';

import { cn } from '@/Libs/utils';

export const typographyVariants = cva('font-open-sans text-foreground', {
  variants: {
    variant: {
      'h1-48/48': 'text-4xl lg:text-5xl font-extrabold',
      'h2-30/36': 'text-3xl font-semibold',
      'h3-24/32': 'text-2xl font-semibold',
      'h4-20/28': 'text-xl font-semibold',
      'large-18/28': 'text-lg',
      'lead-20/28': 'text-xl',
      'p-16/24': 'text-base',
      'body-14/24': 'text-sm leading-6',
      'subtle-14/20': 'text-sm',
      'small-14/14': 'text-sm leading-none',
      'detail-12/20': 'text-xs leading-5',
    },
    weight: {
      default: '',
      extralight: 'font-extralight',
      light: 'font-light',
      normal: 'font-normal',
      medium: 'font-medium',
      semibold: 'font-semibold',
      bold: 'font-bold',
      extrabold: 'font-extrabold',
    },
  },
  defaultVariants: {
    variant: 'p-16/24',
    weight: 'default',
  },
});

export interface TypographyProps<T extends React.ElementType = 'p'>
  extends VariantProps<typeof typographyVariants> {
  as?: T;
  className?: string;
  children: React.ReactNode;
}

export default function Typography<T extends React.ElementType>({
  as,
  children,
  className,
  variant,
  weight,
  ...rest
}: TypographyProps<T> &
  Omit<React.ComponentPropsWithoutRef<T>, keyof TypographyProps<T>>) {
  const Component = as || 'p';

  return (
    <Component
      className={cn(typographyVariants({ variant, weight, className }))}
      {...rest}
    >
      {children}
    </Component>
  );
}
