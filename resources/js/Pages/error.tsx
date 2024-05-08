export default function ErrorPage({ status }: { status: number }) {
  const message = {
    403: 'Forbidden',
    404: 'Page Not Found',
    500: 'Internal Server Error',
  }[status];

  return (
    <main className='relative flex items-top justify-center min-h-screen bg-gray-900 sm:items-center sm:pt-0'>
      <div className='max-w-xl mx-auto sm:px-6 lg:px-8'>
        <div className='flex items-center pt-8 sm:justify-start sm:pt-0'>
          <div className='px-4 text-lg text-gray-500 border-r border-gray-400 tracking-wider'>
            {status}
          </div>
          <div className='ml-4 text-lg text-gray-500 uppercase tracking-wider'>
            {message}
          </div>
        </div>
      </div>
    </main>
  );
}
