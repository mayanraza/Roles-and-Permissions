<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Role') }} / Edit
            </h2>

            <a href="{{ route('article.index') }}" class="bg-slate-700 text-sm rounded-md text-white px-5 py-3">Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form action="{{ route('article-update', $article->id) }}" method="post">
                        @csrf
                        <div>
                            {{-- Title--------- --}}
                            <label for="" class="text-lg font-medium">Title</label>
                            <div class="my-3">
                                <input placeholder="Enter title" name="title" type="text"
                                    class="border-gray-300 shadow-sm w-1/2 rounded-lg"
                                    value="{{ old('title', $article->title) }}">
                                @error('title')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            {{-- Title--------- --}}

                            {{-- Author--------- --}}
                            <label for="" class="text-lg font-medium">Author</label>
                            <div class="my-3">
                                <input placeholder="Enter author" name="author" type="text"
                                    class="border-gray-300 shadow-sm w-1/2 rounded-lg"
                                    value="{{ old('author', $article->author) }}">
                                @error('author')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            {{-- Author--------- --}}

                            {{-- Text--------- --}}
                            <label for="" class="text-lg font-medium">Content</label>
                            <div class="my-3">
                                <textarea class="border-gray-300 shadow-sm w-full rounded-lg" placeholder="Enter Content here.." name="text"
                                    cols="30" rows="10">{{ old('text', $article->text) }}</textarea>
                                @error('text')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            {{-- Text--------- --}}






                            <button class="bg-slate-700 text-sm rounded-md text-white px-5 py-3">Update</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
