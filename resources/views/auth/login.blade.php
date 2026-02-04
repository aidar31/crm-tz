@extends('layouts.admin')

@section('title', 'Login')

@section('content')
<div class="flex flex-col justify-center items-center min-h-screen px-4 bg-gray-50 dark:bg-gray-950">
    
    <div class="w-full max-w-sm">
        <h1 class="text-2xl font-bold mb-6 text-center text-gray-800 dark:text-white">Вход</h1>

        @if ($errors->any())
            <div class="mb-4 text-sm text-red-500 bg-red-50 dark:bg-red-900/20 p-3 rounded">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="/auth/login" method="POST" class="space-y-4">
            @csrf
            
            <div>
                <label class="block text-sm mb-1 dark:text-gray-300">Email</label>
                <input name="email" type="email" value="{{ old('email') }}" required class="w-full p-2 border rounded dark:bg-gray-800 dark:border-gray-700 dark:text-white outline-none focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-sm mb-1 dark:text-gray-300">Пароль</label>
                <input name="password" type="password" required class="w-full p-2 border rounded dark:bg-gray-800 dark:border-gray-700 dark:text-white outline-none focus:border-indigo-500">
            </div>

            <label class="flex items-center text-sm cursor-pointer dark:text-gray-400">
                <input type="checkbox" name="remember" class="mr-2">Запомнить меня
            </label>

            <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded font-medium hover:bg-indigo-700 transition">Войти
            </button>
        </form>
    </div>

</div>
@endsection