<?php

namespace App\Livewire\Components;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class OrderButtons extends Component
{

    use LivewireAlert;

    public $order = 'created_at'; // Default to newest
    public $validOrders = ['created_at', 'popularity'];

    public function mount()
    {
        // Retrieve the saved order state from the session
        $this->order = session('order', 'created_at');
    }

    public function getActiveClass($order)
    {
        return $this->order === $order ? 'bg-blue-100 text-primary' : 'text-gray-700 text-opacity-80 hover:text-opacity-100';
    }

    public function setPopular()
    {
        $this->setOrder('popularity');
        $this->alert('info', 'En popüler gönderilere göre sıralandı.');
    }

    public function setNewest()
    {
        $this->setOrder('created_at');
        $this->alert('info', 'En yeni gönderilere göre sıralandı.');
    }

    public function setOrder($order)
    {

        // Set to default if the order is invalid
        if (!in_array($order, $this->validOrders)) {
            $order = 'created_at';
        }

        // Update the order state
        $this->order = $order;

        // Return if the order is the same
        if (session('order') === $order) return;

        // Store the order in the session
        session(['order' => $order]);

        // Dispatch an event to inform the components that the order has changed
        $this->dispatch('orderChanged');
    }

    public function render()
    {
        return view('livewire.components.order-buttons');
    }
}
