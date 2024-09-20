<?php

namespace App\Livewire\Pages\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class SearchUser extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $query = '';

    public function updatingPage()
    {
        $this->dispatch('scroll-to-top');
    }

    public function render()
    {
        return view('livewire.pages.users.search-user', [
            'users' => User::with('roles')
                ->where('name', 'like', '%' . $this->query . '%')
                ->orWhere('username', 'like', '%' . $this->query . '%')
                ->latest('created_at')
                ->simplePaginate(10),
        ])->title($this->query . ' için arama sonuçları - ' . config('app.name'));
    }
}
