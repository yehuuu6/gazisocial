<?php

namespace App\Livewire\Docs;

use Livewire\Component;
use App\Models\ReportedBug as Bug;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Rapor Edilen Hatalar - Gazi Social Dev Center')]
class ReportedBugsList extends Component
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
            'pending' => 'bg-orange-50 text-orange-400 border-orange-200',
            'resolved' => 'bg-green-50 text-green-600 border-green-200',
            default => 'bg-gray-500'
        };

        return $class;
    }

    public function render()
    {
        return view('livewire.docs.reported-bugs-list', [
            'bugs' => Bug::when($this->bugFilterType !== 'all', fn($query) => $query->where('status', $this->bugFilterType))
                ->with('user')
                ->latest()
                ->simplePaginate(10)
        ]);
    }
}
