<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Roles') }}
            </h2>

            @can('create roles')
                <a href="{{ route('role-create') }}" class="bg-slate-700 text-sm rounded-md text-white px-5 py-3">Create
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
                                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm" width="550">
                                        Permissions</th>
                                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm" width="150">
                                        Created At</th>
                                    @canany(['edit roles', 'delete roles'])
                                        <th class="py-3 px-4 uppercase font-semibold text-sm" width="200">Action</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @if ($roles->isNotEmpty())
                                    @foreach ($roles as $index => $role)
                                        <tr class="border-b">
                                            <td class="py-3 px-4">
                                                {{ ($roles->currentPage() - 1) * $roles->perPage() + $loop->iteration }}
                                            </td>
                                            <td class="py-3 px-4">{{ $role->name }}</td>
                                            <td class="py-3 px-4">
                                                {{ $role->permissions->pluck('name')->implode(', ') }}
                                            </td>

                                            <td class="py-3 px-4">{{ $role->created_at->format('d-M-Y') }}</td>
                                            @canany('edit roles', 'delete roles')
                                                <td class="py-3 px-6 text-center">

                                                    @can('edit roles')
                                                        <a href="{{ route('role-edit', $role->id) }}"
                                                            class="bg-yellow-300 text-s rounded-md text-white px-3 py-2 hover:bg-yellow-200">Edit</a>
                                                    @endcan

                                                    @can('delete roles')
                                                        <a href="javascript:void(0)" onclick="roleDelete({{ $role->id }})"
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
                        {{ $roles->links() }}
                    </div>











                </div>
            </div>
        </div>
    </div>










    <x-slot name="script">
        <script>
            function roleDelete(id) {
                if (confirm("Are you sure you want to delete..??")) {
                    $.ajax({
                        url: '{{ route('role-destroy') }}',
                        type: "delete",
                        dataType: "json",
                        data: {
                            id: id
                        },
                        headers: {
                            "x-csrf-token": "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            window.location.href = '{{ route('role.index') }}';
                        }
                    })
                }
            }
        </script>

    </x-slot>





</x-app-layout>
