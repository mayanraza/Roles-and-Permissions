<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User') }}
            </h2>

            @can('create users')
                <a href="{{ route('user-create') }}" class="bg-slate-700 text-sm rounded-md text-white px-5 py-3">Create
                @endcan
            </a>
        </div>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    {{-- session message------ --}}
                    @include('components.message')
                    {{-- session message------ --}}




                    {{-- Table Start --}}
                    <div class="overflow-x-auto">
                        <table class="w-full bg-white border border-gray-200">
                            <thead class="bg-gray-100">
                                <tr class=" border-b">
                                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm" width="60">S.No
                                    </th>
                                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Name</th>
                                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">
                                        E-mail</th>
                                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">
                                        Role</th>
                                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm" width="180">
                                        Created At</th>
                                    @canany('edit users', 'delete users')
                                        <th class=" py-3 px-4 uppercase font-semibold text-sm" width="250">Action</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @if ($users->isNotEmpty())
                                    @foreach ($users as $index => $user)
                                        <tr class="border-b">
                                            <td class="py-3 px-4">
                                                {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                                            </td>
                                            <td class="py-3 px-4">{{ $user->name }}</td>
                                            <td class="py-3 px-4">
                                                {{ $user->email }}
                                            </td>
                                            <td class="py-3 px-4">
                                                {{ $user->roles->pluck('name')->implode(' , ') }}
                                            </td>

                                            <td class="py-3 px-4">{{ $user->created_at->format('d-M-Y') }}</td>

                                            @canany('edit users', 'delete users')
                                                <td class="py-3 px-6 text-center">
                                                    @can('edit users')
                                                        <a href="{{ route('user-edit', $user->id) }}"
                                                            class="bg-yellow-300 text-s rounded-md text-white px-3 py-2 hover:bg-yellow-200">Edit</a>
                                                    @endcan

                                                    @can('delete users')
                                                        <a href="javascript:void(0)" onclick="userDelete({{ $user->id }})"
                                                            class="bg-red-600 text-s rounded-md text-white px-3 py-2 hover:bg-red-500">Delete</a>
                                                    @endcan

                                                </td>
                                            @endcanany


                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    {{-- Table End --}}

                    {{-- Pagination Links --}}
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>











                </div>
            </div>
        </div>
    </div>










    <x-slot name="script">
        <script>
            function userDelete(id) {
                if (confirm("Are you sure you want to delete..??")) {
                    $.ajax({
                        url: '{{ route('user-destroy') }}',
                        type: "delete",
                        dataType: "json",
                        data: {
                            id: id
                        },
                        headers: {
                            "x-csrf-token": "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            window.location.href = '{{ route('user.index') }}';
                        }
                    })
                }
            }
        </script>

    </x-slot>





</x-app-layout>
