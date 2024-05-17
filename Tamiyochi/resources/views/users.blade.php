<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite('resources/css/app.css')
  <title>User</title>
</head>
<body>
  <section id="modal" class="hidden fixed w-full h-screen justify-center items-center bg-teal bg-opacity-70">
    <form method="POST" action="/users" class="space-y-10 px-8 py-4 rounded-xl w-[512px] bg-white" enctype="multipart/form-data">
      <h1 class="text-5xl font-bold text-teal">Add User</h1>
      
      @csrf

      <div class="space-y-6">
        <div class="space-y-1.5">
          <label for="email" class="block font-semibold text-teal">Email</label>
          <input type="email" id="email" name="email" placeholder="Enter email" class="w-full block px-3 py-2.5 rounded-md bg-beige placeholder:text-mint-hover text-teal" />
          @error('email')
          <p class="text-red-400">{{ $message }}</p>
          @enderror
        </div>

        <div class="space-y-1.5">
          <label for="name" class="block font-semibold text-teal">Name</label>
          <input type="text" id="name" name="name" placeholder="Enter name" class="w-full block px-3 py-2.5 rounded-md bg-beige placeholder:text-mint-hover text-teal" />
          @error('name')
          <p class="text-red-400">{{ $message }}</p>
          @enderror
        </div>

        <div class="space-y-1.5">
          <label for="no_telp" class="block font-semibold text-teal">Phone Number</label>
          <input type="text" id="no_telp" name="no_telp" placeholder="Enter phone number" class="w-full block px-3 py-2.5 rounded-md bg-beige placeholder:text-mint-hover text-teal" />
          @error('no_telp')
          <p class="text-red-400">{{ $message }}</p>
          @enderror
        </div>

        <div class="space-y-1.5">
          <label for="age" class="block font-semibold text-teal">Age</label>
          <input type="text" id="age" name="age" placeholder="Enter your age" class="w-full block px-3 py-2.5 rounded-md bg-beige placeholder:text-mint-hover text-teal" />
          @error('age')
          <p class="text-red-400">{{ $message }}</p>
          @enderror
        </div>

        <div class="space-y-1.5">
          <label for="image" class="block font-semibold text-teal">Image</label>
          <input type="file" id="image" name="image" accept="image/*" class="w-full block px-3 py-2.5 rounded-md bg-beige text-mint-hover" />
          @error('image')
          <p class="text-red-400">{{ $message }}</p>
          @enderror
        </div>

        <div class="space-y-1.5">
          <label for="password" class="block font-semibold text-teal">Password</label>
          <input type="password" id="password" name="password" placeholder="Enter password" class="w-full block px-3 py-2.5 rounded-md bg-beige placeholder:text-mint-hover text-teal" />
          @error('password')
          <p class="text-red-400">{{ $message }}</p>
          @enderror
        </div>

        <button type="submit" class="w-full block px-6 py-2.5 rounded-md bg-teal hover:bg-teal-hover text-white font-semibold">Submit</button>
        <button type="button" onclick="closeModal()" class="w-full block px-6 py-2.5 rounded-md bg-transparent hover:bg-teal ring-1 ring-inset ring-teal text-teal hover:text-white font-semibold">Cancel</button>
      </div>
    </form>
  </section>

  <div class="w-full min-h-screen flex flex-col items-center font-poppins bg-white">
    <main class="max-w-5xl w-full py-12 space-y-10">
      <div class="flex justify-between items-center">
        <h1 class="font-poppins text-5xl font-bold text-teal">User List</h1>
        <button onclick="openModal()" class="px-6 py-2.5 rounded-md bg-teal hover:bg-teal-hover text-white font-semibold">Add User</button>
      </div>
      <div class="px-4">
        <div class="py-2 grid grid-cols-5 text-teal bg-beige rounded-t-lg">
          <h3 class="font-bold text-center">Image</h3>
          <h3 class="font-bold text-center">Name</h3>
          <h3 class="font-bold text-center">Email</h3>
          <h3 class="font-bold text-center">Phone Number</h3>
          <h3 class="font-bold text-center">Age</h3>
        </div>
        @foreach ($users as $user)
        <div class="py-2 grid grid-cols-5 text-teal ring-1 ring-inset ring-beige last:rounded-b-lg odd:bg-beige odd:bg-opacity-25">
          <div class="flex justify-center">
            <img src="{{ $user->user->getImageUrl() }}" alt="profile picture" class="w-24 rounded-md">
          </div>
          <div class="flex items-center justify-center">
            <p class="text-center">{{ $user->user->getName() }}</p>
          </div>
          <div class="flex items-center justify-center">
            <p class="text-center">{{ $user->user->getEmail()->toString() }}</p>
          </div>
          <div class="flex items-center justify-center">
            <p class="text-center">{{ $user->user->getNoTelp() }}</p>
          </div>
          <div class="flex items-center justify-center">
            <p class="text-center">{{ $user->user->getAge() }}</p>
          </div>
        </div>
        @endforeach
      </div>
    </main>
  </div>

  <script>
    const modal = document.getElementById('modal');

    const openModal = () => {
      modal.classList.remove('hidden');
      modal.classList.add('flex');
    }
    
    const closeModal = () => {
      modal.classList.remove('flex');
      modal.classList.add('hidden');
    }
  </script>
</body>
</html>