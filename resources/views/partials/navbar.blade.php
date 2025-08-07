<!-- Navigation -->
<nav class="gradient-bg shadow-lg fixed w-full top-0 z-40">
    <div class="container mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <button onclick="toggleSidebar()" class="lg:hidden text-white/80 hover:text-white transition-colors p-2 rounded-lg hover:bg-white/20">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <a href="{{ route('dashboard') }}" class="navbar-brand lg:bg-white/20 flex items-center space-x-2">
                    <i class="fas fa-graduation-cap text-xl"></i>
                    <span>Academic Hub</span>
                </a>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('profile') }}" class="flex items-center space-x-3 text-white/90 hover:text-white transition-colors group">
                    @if($user->profile_picture ?? null)
                        <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile" class="w-8 h-8 rounded-full border-2 border-white/20 group-hover:border-white/40 transition-colors object-cover">
                    @else
                        <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center border-2 border-white/20 group-hover:border-white/40 transition-colors">
                            <i class="fas fa-user text-sm"></i>
                        </div>
                    @endif
                    <span class="text-sm font-medium group-hover:underline">{{ $user->name }}</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-white/90 hover:text-white transition-colors px-3 py-2 rounded-lg hover:bg-white/20">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
