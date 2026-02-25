<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

new class extends Component
{
    use WithFileUploads;

    public $photo;

    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'image|max:1024', // 1MB Max
        ]);

        $user = Auth::user();
        
        if ($user->profile_photo_path) {
            Storage::delete($user->profile_photo_path);
        }

        $path = $this->photo->store('profile-photos', 'public');
        
        $user->update([
            'profile_photo_path' => $path,
        ]);

        $this->dispatch('profile-updated'); // Optional: for other components
    }

    public function deleteProfilePhoto()
    {
        $user = Auth::user();

        if ($user->profile_photo_path) {
            Storage::delete($user->profile_photo_path);
            $user->update([
                'profile_photo_path' => null,
            ]);
        }
    }

    public function getUserProperty()
    {
        return Auth::user();
    }
}; ?>

<div class="flex flex-col sm:flex-row items-center sm:items-start gap-8 border-b border-border-light dark:border-border-dark pb-8">
    <div class="relative group cursor-pointer shrink-0" x-data="{ uploading: false, focused: false }">
        <div class="size-24 rounded-full bg-cover bg-center border border-border-light dark:border-border-dark shadow-sm bg-slate-200" 
             style="background-image: url('{{ $photo ? $photo->temporaryUrl() : ($this->user->profile_photo_path ? Storage::url($this->user->profile_photo_path) : 'https://ui-avatars.com/api/?name='.urlencode($this->user->name).'&color=7F9CF5&background=EBF4FF') }}');">
        </div>
        
        <div class="absolute inset-0 bg-black/50 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity backdrop-blur-[2px]"
             x-on:click="document.getElementById('photoInput').click()">
            <span class="material-symbols-outlined text-white text-[20px]">photo_camera</span>
        </div>

        <input type="file" id="photoInput" class="hidden" wire:model="photo" accept="image/*" />
    </div>

    <div class="flex flex-col items-center sm:items-start pt-2 gap-1.5 text-center sm:text-left">
        <div>
            <h2 class="text-xl font-semibold text-text-primary dark:text-white tracking-tight">{{ $this->user->name }}</h2>
            <p class="text-text-secondary dark:text-text-secondary-dark text-[13px] mt-0.5">{{ $this->user->email }}</p>
            {{-- Optional: Show role/cargo if exists --}}
            @if($this->user->cargo)
                <p class="text-text-secondary dark:text-text-secondary-dark text-[11px] mt-0.5">{{ $this->user->cargo }}</p>
            @endif
        </div>
        <div class="flex gap-2 mt-2">
            <button onclick="document.getElementById('photoInput').click()" class="text-[12px] font-medium text-text-primary dark:text-slate-300 border border-border-light dark:border-border-dark bg-white dark:bg-surface-dark rounded px-3 py-1.5 hover:bg-slate-50 dark:hover:bg-white/5 transition-colors shadow-sm">
                Alterar Foto
            </button>
            @if($this->user->profile_photo_path)
                <button wire:click="deleteProfilePhoto" class="text-[12px] font-medium text-red-600 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-900/20 px-3 py-1.5 rounded transition-colors">
                    Remover
                </button>
            @endif
        </div>
        <x-input-error :messages="$errors->get('photo')" class="mt-2" />
    </div>
</div>
