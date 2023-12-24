<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create User</title>
</head>
<body>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Admin Dashboard') }}

            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h1>Create New User</h1>

                        <form action="{{ route('store.user') }}" method="post">
                            @csrf
                            <label for="name">Name:</label>
                            <input type="text" id="name" name="name" required>
                            <br>
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" required>
                            <br>
                            <label for="password">Password:</label>
                            <input type="password" id="password" name="password" required>
                            <br>
                            <label for="password_confirmation">Confirm Password:</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required>
                            <br>
                            <button type="submit">Create</button>
                        </form>


</div>
</div>
</div>
</div>

</x-app-layout>

</body>
</html>
