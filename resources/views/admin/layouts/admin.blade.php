<!DOCTYPE html>
<html lang="id" class="h-full bg-[#0a0a0a]">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin - Museum KASAD')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="h-full text-gray-200 antialiased font-montserrat [x-cloak] { display: none !important; }"
    x-data="{ sidebarOpen: window.innerWidth >= 640 }">

    <div class="flex h-screen overflow-hidden">

        @include('admin.partials.sidebar')

        <div :class="sidebarOpen ? 'sm:ml-64' : 'sm:ml-20'"
            class="flex flex-col flex-1 min-w-0 transition-all duration-300 ml-0">

            @include('admin.partials.header')

            <main class="flex-1 overflow-x-hidden overflow-y-auto p-8 bg-[#0a0a0a] sm:p-5">
                <div class="max-w-7xl mx-auto space-y-8">
                    @yield('content')
                </div>
            </main>

        </div>
    </div>

</body>

</html>
