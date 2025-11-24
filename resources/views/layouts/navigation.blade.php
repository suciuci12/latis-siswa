<nav class="bg-white border-b border-gray-200 min-h-screen w-60 p-4">

    <h2 class="text-xl font-bold mb-4">Menu</h2>

    <ul class="space-y-2">

        <li>
            <a href="{{ route('siswa.index') }}"
                class="block px-3 py-2 rounded hover:bg-gray-100">
                Siswa
            </a>
        </li>

        <li>
            <a href="{{ route('profile.edit') }}"
                class="block px-3 py-2 rounded hover:bg-gray-100">
                Profile
            </a>
        </li>

        <li class="mt-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="block w-full text-left px-3 py-2 rounded hover:bg-gray-100">
                    Logout
                </button>
            </form>
        </li>

    </ul>

</nav>