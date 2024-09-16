<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Role') }} / Edit

            </h2>

            <a href="{{ route('role.index') }}" class="bg-slate-700 text-sm rounded-md text-white px-5 py-3">Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form action="{{route("role-update",$role->id)}}" method="post">
                        @csrf
                        <div>
                            <label for="" class="text-lg font-medium">Name</label>
                            <div class="my-3">
                                <input placeholder="Enter name" name="name" type="text"
                                    class="border-gray-300 shadow-sm w-1/2 rounded-lg"
                                    value="{{ old('name', $role->name) }}">
                                @error('name')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>




                            {{-- checkbox------- --}}
                            <div class="grid grid-cols-4 mb-6">
                                @if ($permission->isNotEmpty())
                                    @foreach ($permission as $item)
                                        <div class="mt-3">
                                            <input {{ $hasPermission->contains($item->name) ? 'checked' : '' }}
                                                type="checkbox" value="{{ $item->name }}" class="rounded"
                                                name="permissions[]" id="permission-{{ $item->id }}">
                                            <label for="permission-{{ $item->id }}">{{ $item->name }}</label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            {{-- checkbox------- --}}



                            <button class="bg-slate-700 text-sm rounded-md text-white px-5 py-3">Update</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
