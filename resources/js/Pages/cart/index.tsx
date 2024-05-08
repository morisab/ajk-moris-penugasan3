import CartStatisticCard from '@/Components/card/cart/statistic';
import CartVolumeCard from '@/Components/card/cart/volume';
import DashboardLayout from '@/Layouts/dashboard';
import { CartResponse } from '@/Types/entities/cart';
import { PageProps } from '@/Types/entities/page';

export default function CartPage({
  success,
  data,
  user,
}: PageProps<CartResponse>) {
  return (
    <DashboardLayout user={user}>
      <section className='w-full max-w-[1440px] flex flex-col items-end gap-4 md:gap-8 px-3 md:px-12 py-4 md:py-8'>
        <div className='w-full flex items-start gap-4'>
          {success && (
            <div className='flex-1 space-y-8'>
              {data?.cart.map((cart, index) => (
                <CartVolumeCard key={index} {...cart} />
              ))}
            </div>
          )}
          {success && data && (
            <CartStatisticCard {...data} className='w-full md:w-96' />
          )}
        </div>
      </section>
    </DashboardLayout>
  );
}
