<x-app-layout>
    @php $user = auth()->user(); @endphp

    <div class="space-y-8">

        {{-- Toasts --}}
        @if (session('status') === 'profile-updated')
            <x-ui.toast type="success" title="Succès" message="Vos informations ont été mises à jour." />
        @elseif (session('status') === 'password-updated')
            <x-ui.toast type="success" title="Succès" message="Votre mot de passe a été mis à jour." />
        @endif

        {{-- Hero header --}}
        <div class="relative rounded-3xl overflow-hidden shadow-elevated">
            <div class="absolute inset-0 bg-hero-gradient"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-surface-950/60 via-transparent to-transparent"></div>

            <div class="relative z-10 px-6 sm:px-10 pt-16 pb-8">
                <p class="text-[11px] font-semibold text-white/60 uppercase tracking-widest">Mon profil</p>
                <div class="mt-5 flex flex-col sm:flex-row sm:items-center gap-5">
                    <div class="w-20 h-20 rounded-3xl bg-white/10 backdrop-blur-sm border border-white/20 flex items-center justify-center text-2xl font-bold text-white flex-shrink-0 shadow-lg">
                        {{ strtoupper(substr($user->first_name, 0, 1)) }}{{ strtoupper(substr($user->last_name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-3">
                            <h1 class="text-2xl sm:text-3xl font-bold text-white tracking-tight">{{ $user->fullName() }}</h1>
                            <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold uppercase tracking-wider rounded-full px-3 py-1 bg-gold-500/20 text-gold-200 border border-gold-500/30">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                {{ $user->isOwner() ? 'Propriétaire' : 'Voyageur' }}
                            </span>
                        </div>
                        <div class="mt-3 flex flex-wrap items-center gap-x-6 gap-y-2 text-sm text-white/80">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                                {{ $user->email }}
                            </span>
                            @if($user->phone)
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                                    {{ $user->phone }}
                                </span>
                            @endif
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                                Membre depuis {{ $user->created_at->format('M Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Content --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Left column --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="panel p-6 sm:p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-9 h-9 rounded-xl bg-navy-50 flex items-center justify-center">
                            <svg class="w-4.5 h-4.5 text-navy-700" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-semibold text-surface-900">Informations du profil</h2>
                            <p class="text-xs text-surface-500">Prénom, nom, email et téléphone</p>
                        </div>
                    </div>
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="panel p-6 sm:p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-9 h-9 rounded-xl bg-gold-100 flex items-center justify-center">
                            <svg class="w-4.5 h-4.5 text-gold-700" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-semibold text-surface-900">Sécurité</h2>
                            <p class="text-xs text-surface-500">Mettre à jour votre mot de passe</p>
                        </div>
                    </div>
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            {{-- Right column --}}
            <div class="space-y-6">
                <div class="panel p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-9 h-9 rounded-xl bg-surface-100 flex items-center justify-center">
                            <svg class="w-4.5 h-4.5 text-surface-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3l1.5 1.5 3-3.75"/></svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-semibold text-surface-900">Mon compte</h2>
                            <p class="text-xs text-surface-500">Résumé de votre compte</p>
                        </div>
                    </div>
                    <dl class="space-y-3 text-sm">
                        <div class="flex items-center justify-between">
                            <dt class="text-surface-500">Rôle</dt>
                            <dd class="font-semibold text-surface-900 capitalize">{{ $user->role }}</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="text-surface-500">Email vérifié</dt>
                            <dd>
                                @if($user->email_verified_at)
                                    <span class="inline-flex items-center gap-1 text-emerald-600 font-semibold">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Oui
                                    </span>
                                @else
                                    <span class="text-amber-600 font-semibold">Non</span>
                                @endif
                            </dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="text-surface-500">Membre depuis</dt>
                            <dd class="font-semibold text-surface-900">{{ $user->created_at->format('d M Y') }}</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="text-surface-500">Notifications</dt>
                            <dd class="font-semibold text-surface-900">{{ $user->notifications()->unread()->count() }} non lue{{ $user->notifications()->unread()->count() > 1 ? 's' : '' }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="panel border-red-200/80 p-6">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
