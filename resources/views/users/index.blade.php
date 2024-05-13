@extends('layouts.app')

@section('content')
<div class="create-container flex justify-center mt-10 overflow-x-auto">
    <div class="w-auto max-w-4xl mx-auto">
        <table class="table w-auto text-white bg-gray-800">
            <thead class="bg-gray-700 text-gray-300">
                <tr>
                    <th class="px-6 py-3 border-b border-gray-600">Email</th>
                    <th class="px-6 py-3 border-b border-gray-600" colspan="2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr class="table-row hover:bg-gray-700">
                    <td class="table-cell px-6 py-4 border-b border-gray-700">{{ $user->email }}</td>
                    <td class="table-cell px-6 py-4 border-b border-gray-700">
                        <a href="{{ route('users.show', $user->id) }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition duration-200">View Profile</a>
                    </td>
                    <td class="table-cell px-6 py-4 border-b border-gray-700">
                        @if(!$user->IsAdmin)
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded transition duration-200">Delete</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
