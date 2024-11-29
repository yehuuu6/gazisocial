<?php

namespace App\Livewire\Pages\Terms;

use Livewire\Component;
use App\Models\ReportedBug as Bug;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Rapor Edilen Hatalar - Gazi Social Dev Center')]
class ReportedBugsPage extends Component
{
    use WithPagination;

    public $bugFilterType = 'all';

    public function filterBugs($type)
    {
        $this->bugFilterType = $type;
        $this->resetPage();
    }

    public function getBadge(string $type)
    {
        $class = match ($type) {
            'pending' => 'bg-orange-50 text-orange-400 border-orange-400',
            'resolved' => 'bg-green-50 text-green-600 border-green-600',
            default => 'bg-gray-500'
        };

        return $class;
    }

    public function render()
    {
        return view('livewire.pages.terms.reported-bugs-page', [
            'bugs' => Bug::when($this->bugFilterType !== 'all', fn($query) => $query->where('status', $this->bugFilterType))
                ->with('user')
                ->latest()
                ->simplePaginate(10)
        ]);
    }
}
