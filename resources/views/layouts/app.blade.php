<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Tailor Management System')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"> 
</head>

<body class="bg-gray-100" x-data="{ sidebarOpen: true }">

    @include('partials.navbar')

    <div class="flex">

        @include('partials.sidebar')

        <div class="flex-1 ml-72 mt-16 flex flex-col min-h-screen">

            <main class="flex-1 p-6">

                @yield('content')

            </main>

            @include('partials.footer')

        </div>

    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</body>
</html>