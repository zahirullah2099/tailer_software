<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-900 via-blue-900 to-indigo-900">

        <div class="w-full max-w-md">

            <div class="bg-white rounded-2xl shadow-2xl p-8">

                <div class="text-center mb-8">

                    <div
                        class="w-20 h-20 mx-auto rounded-full bg-blue-600 flex items-center justify-center text-white text-3xl font-bold">
                        T
                    </div>

                    <h1 class="text-3xl font-bold mt-4">
                        Tailor Management
                    </h1>

                    <p class="text-gray-500 mt-2">
                        Login to continue
                    </p>

                </div>

                <form action="{{ route('login.store') }}" method="POST">

                    @csrf

                    <div class="mb-5">

                        <label class="block mb-2 font-medium">
                            Phone Number
                        </label>

                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="03XXXXXXXXX"
                            class="w-full rounded-lg border px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none @error('phone') border-red-500 @enderror">

                        @error('phone')
                            <p class="text-red-500 text-sm mt-2">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    <div class="mb-6">

                        <label class="block mb-2 font-medium">
                            Password
                        </label>

                        <input type="password" name="password" placeholder="********"
                            class="w-full rounded-lg border px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none @error('password') border-red-500 @enderror">

                        @error('password')
                            <p class="text-red-500 text-sm mt-2">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    <button
                        class="w-full bg-blue-600 hover:bg-blue-700 transition text-white py-3 rounded-lg font-semibold">

                        Login

                    </button>

                </form>

            </div>

        </div>

    </div>

</body>

</html>
