<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User') }} / Create
            </h2>

            <a href="{{ route('user.index') }}" class="bg-slate-700 text-sm rounded-md text-white px-5 py-3">Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form action="{{ route('user-store') }}" method="post">
                        @csrf
                        <div>
                            {{-- name---- --}}
                            <label for="" class="text-lg font-medium">Name</label>
                            <div class="my-3">
                                <input placeholder="Enter name" name="name" type="text"
                                    class="border-gray-300 shadow-sm w-1/2 rounded-lg" value="{{ old('name') }}">
                                @error('name')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            {{-- name---- --}}


                            {{-- email---- --}}
                            <label for="" class="text-lg font-medium">Email</label>
                            <div class="my-3">
                                <input placeholder="Enter email" name="email" type="email"
                                    class="border-gray-300 shadow-sm w-1/2 rounded-lg" value="{{ old('email') }}">
                                @error('email')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            {{-- email---- --}}




                            {{-- password---- --}}
                            <label for="" class="text-lg font-medium">Password</label>
                            <div class="my-3">
                                <input placeholder="Enter password" name="password" type="password"
                                    class="border-gray-300 shadow-sm w-1/2 rounded-lg" value="{{ old('password') }}">
                                @error('password')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            {{-- password---- --}}





                            {{-- confirm password---- --}}
                            <label for="" class="text-lg font-medium">Confirm Password</label>
                            <div class="my-3">
                                <input placeholder="confirm password" name="confirm-password" type="password"
                                    class="border-gray-300 shadow-sm w-1/2 rounded-lg" value="{{ old('confirm-password') }}">
                                @error('confirm-password')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            {{-- confirm password---- --}}







                            {{-- checkbox------- --}}
                            <div class="grid grid-cols-4 mb-6">
                                @if ($roles->isNotEmpty())
                                    @foreach ($roles as $item)
                                        <div class="mt-3">
                                            <input type="checkbox" value="{{ $item->name }}" class="rounded"
                                                name="role[]" id="role-{{ $item->id }}">
                                            <label for="role-{{ $item->id }}">{{ $item->name }}</label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            {{-- checkbox------- --}}



                            <button class="bg-slate-700 text-sm rounded-md text-white px-5 py-3">Create</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
