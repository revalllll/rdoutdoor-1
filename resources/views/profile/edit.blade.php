<x-app-layout>
    <div class="bg-gray-100 min-h-screen py-8">
        <div class="w-full px-2 md:px-12 space-y-6">
            <!-- Back to Dashboard Button -->
            <div class="flex justify-end mb-4">
                <div class="relative inline-block text-left">
                    <button id="profileDropdownBtn" type="button" class="inline-flex items-center px-6 py-2 border border-gray-200 shadow rounded-full bg-white hover:bg-gray-50 text-green-900 font-semibold text-lg transition focus:outline-none focus:ring-2 focus:ring-green-200" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()?->name ?? 'Guest' }}
                        <svg class="ml-2 w-5 h-5 text-orange-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div id="profileDropdownMenu" class="hidden absolute right-0 mt-2 w-56 bg-white border border-gray-200 rounded-xl shadow-xl z-50 py-2 transition-all" style="min-width:180px;">
                        <a href="{{ route('profile.edit') }}" class="block px-5 py-3 text-gray-800 hover:bg-green-50 hover:text-green-900 font-medium rounded-t-xl transition">Edit Profil</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-5 py-3 text-gray-800 hover:bg-green-50 hover:text-green-900 font-medium transition">Logout</button>
                        </form>
                        <form method="POST" action="{{ route('logout') }}" id="switchAccountForm">
                            @csrf
                            <button type="button" onclick="handleSwitchAccount()" class="w-full text-left px-5 py-3 text-gray-800 hover:bg-green-50 hover:text-green-900 font-medium rounded-b-xl transition">Ganti Akun</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Profile Card -->
            <div class="bg-white rounded-2xl shadow p-6 md:p-8 flex flex-col md:flex-row items-center gap-4 md:gap-6 w-full justify-start border-4 border-transparent">
                <img src="{{ Auth::user()?->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()?->name ?? 'Guest') . '&background=17635c&color=fff&size=180' }}" alt="Avatar" class="rounded-full w-32 h-32 md:w-40 md:h-40 object-cover border-4 border-white shadow shrink-0">
                <div class="text-center md:text-left">
                    <h2 class="text-lg md:text-2xl font-semibold text-gray-800">{{ Auth::user()?->name ?? 'Guest' }}</h2>
                    <div class="text-gray-500 text-sm md:text-base">{{ Auth::user()->role->name ?? 'User' }}</div>
                    <div class="text-gray-400 text-sm md:text-base">{{ Auth::user()->city ?? 'Your City' }}, {{ Auth::user()->country ?? 'Your Country' }}</div>
                </div>
            </div>

            <!-- Personal Information Card -->
            <div class="bg-white rounded-2xl shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-green-900">Personal Information</h3>
                    <div x-data="{ showPersonal: false }" class="inline">
                        <button @click="showPersonal = true" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg flex items-center gap-2 text-lg font-semibold shadow transition" style="background-color:#f97316;color:#fff;">
                            Edit
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16"><path d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zm.708-.708a1.5.5 0 0 0-2.121 0l-10 10a1.5 1.5 0 0 0-.328.497l-2 5a1.5 1.5 0 0 0 1.95 1.95l5-2a1.5 1.5 0 0 0 .497-.328l10-10a1.5 1.5 0 0 0 0-2.121l-2.292-2.292z"/></svg>
                        </button>
                        <div x-show="showPersonal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
                            <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-lg relative">
                                <button @click="showPersonal = false" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700">&times;</button>
                                <h2 class="text-xl font-bold mb-4">Edit Personal Information</h2>
                                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PATCH')
                                    <div class="mb-4">
                                        <label class="block text-gray-700">First Name</label>
                                        <input type="text" name="first_name" class="w-full border rounded px-3 py-2" value="{{ old('first_name', Auth::user()->first_name) }}">
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700">Last Name</label>
                                        <input type="text" name="last_name" class="w-full border rounded px-3 py-2" value="{{ old('last_name', Auth::user()->last_name) }}">
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700">Date of Birth</label>
                                        <input type="date" name="dob" class="w-full border rounded px-3 py-2" value="{{ old('dob', Auth::user()->dob) }}">
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700">Phone Number</label>
                                        <input type="text" name="phone" class="w-full border rounded px-3 py-2" value="{{ old('phone', Auth::user()->phone) }}">
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700">Foto Profil</label>
                                        <input type="file" name="profile_photo" class="w-full border rounded px-3 py-2">
                                    </div>
                                    <div class="flex justify-end gap-2 mt-6">
                                        <button type="button" @click="showPersonal = false" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300 text-gray-700">Batal</button>
                                        <button type="submit" class="px-4 py-2 rounded bg-orange-500 hover:bg-orange-600 text-white font-semibold text-base" style="color:#fff !important; background-color:#f97316 !important;">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-gray-700">
                    <div>
                        <div class="text-xs text-gray-400">First Name</div>
                        <div class="font-semibold">{{ Auth::user()->first_name ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-400">Last Name</div>
                        <div class="font-semibold">{{ Auth::user()->last_name ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-400">Date of Birth</div>
                        <div class="font-semibold">{{ Auth::user()->dob ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-400">Email Address</div>
                        <div class="font-semibold break-all">{{ Auth::user()?->email ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-400">Phone Number</div>
                        <div class="font-semibold">{{ Auth::user()->phone ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-400">User Role</div>
                        <div class="font-semibold">{{ Auth::user()->role->name ?? 'User' }}</div>
                    </div>
                </div>
            </div>

            <!-- Address Card -->
            <div class="bg-white rounded-2xl shadow p-6 relative">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-green-900">Address</h3>
                    <div x-data="{ showAddress: false }" class="inline">
                        <a href="#" @click.prevent="showAddress = true" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg flex items-center gap-2 text-lg font-semibold shadow transition" style="background-color:#f97316;color:#fff;">
                            Edit
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16"><path d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zm.708-.708a1.5.5 0 0 0-2.121 0l-10 10a1.5 1.5 0 0 0-.328.497l-2 5a1.5 1.5 0 0 0 1.95 1.95l5-2a1.5 1.5 0 0 0 .497-.328l10-10a1.5 1.5 0 0 0 0-2.121l-2.292-2.292z"/></svg>
                        </a>
                        <div x-show="showAddress" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
                            <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-lg relative">
                                <button @click="showAddress = false" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700">&times;</button>
                                <h2 class="text-xl font-bold mb-4">Edit Address</h2>
                                <form method="POST" action="{{ route('profile.update') }}">
                                    @csrf
                                    @method('PATCH')
                                    <div class="mb-4">
                                        <label class="block text-gray-700">Country</label>
                                        <input type="text" name="country" class="w-full border rounded px-3 py-2" value="{{ old('country', Auth::user()->country) }}">
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700">City</label>
                                        <input type="text" name="city" class="w-full border rounded px-3 py-2" value="{{ old('city', Auth::user()->city) }}">
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700">Postal Code</label>
                                        <input type="text" name="postal_code" class="w-full border rounded px-3 py-2" value="{{ old('postal_code', Auth::user()->postal_code) }}">
                                    </div>
                                    <div class="flex justify-end gap-2 mt-6">
                                        <button type="button" @click="showAddress = false" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300 text-gray-700">Batal</button>
                                        <button type="submit" class="px-4 py-2 rounded bg-orange-500 hover:bg-orange-600 text-white font-semibold text-base" style="color:#fff !important; background-color:#f97316 !important;">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-gray-700">
                    <div>
                        <div class="text-xs text-gray-400">Country</div>
                        <div class="font-semibold">{{ Auth::user()->country ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-400">City</div>
                        <div class="font-semibold">{{ Auth::user()->city ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-400">Postal Code</div>
                        <div class="font-semibold">{{ Auth::user()->postal_code ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @once
        <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @endonce
    <script>
        function handleSwitchAccount() {
            // Logout, lalu redirect ke halaman login setelah logout sukses
            document.getElementById('switchAccountForm').submit();
            setTimeout(function() {
                window.location.href = "{{ route('login') }}";
            }, 400);
        }
        document.addEventListener('DOMContentLoaded', function() {
            var btn = document.getElementById('profileDropdownBtn');
            var menu = document.getElementById('profileDropdownMenu');
            if(btn && menu) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    menu.classList.toggle('hidden');
                });
                document.addEventListener('click', function(e) {
                    if (!btn.contains(e.target) && !menu.contains(e.target)) {
                        menu.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</x-app-layout>
