<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Quiz App')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow mb-6">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
<a href="{{ url('/') }}" class="flex items-center space-x-2">
    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-auto">
    <span class="text-xl font-bold text-blue-600">Quiz App</span>
</a>
            <div class="space-x-4">
                @auth
                    <a href="{{ route('subjects.index') }}" class="text-gray-700 hover:text-blue-600">Subjects</a>
                    <a href="{{ route('rankings.global') }}" class="text-gray-700 hover:text-blue-600">Rankings</a>
                    <a href="{{ route('groups.index') }}" class="text-gray-700 hover:text-blue-600">Groups</a>
<a href="{{ route('quiz.random') }}" class="text-gray-700 hover:text-blue-600">🎲 Random Quiz</a>                    
<a href="{{ route('custom.my') }}" class="text-gray-700 hover:text-blue-600">📝 My Quizzes</a>
<form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-blue-600">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">Login</a>
                    <a href="{{ route('register') }}" class="text-gray-700 hover:text-blue-600">Register</a>
                @endauth
            </div>
        </div>
    </nav>
    
    <main>
        @yield('content')
    </main>
</body>
</html>
