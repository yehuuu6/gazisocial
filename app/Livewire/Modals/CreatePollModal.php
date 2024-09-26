<?php

namespace App\Livewire\Modals;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Validation\ValidationException;

class CreatePollModal extends Component
{
    use LivewireAlert;

    public $question;
    public $optionInputs = [
        '',
        '',
    ];

    public function validateOptions(): bool
    {

        if (count($this->optionInputs) < 2) {
            $this->alert('error', 'En az 2 yanıt olmalıdır.');
            return false;
        }

        if (count($this->optionInputs) > 5) {
            $this->alert('error', 'En fazla 5 yanıt ekleyebilirsiniz.');
            return false;
        }

        // Check if there are empty options
        foreach ($this->optionInputs as $option) {
            if (empty($option)) {
                $this->alert('error', 'Boş yanıt ekleyemezsiniz.');
                return false;
            }
        }

        // Check if the options are between 1 and 50 characters
        foreach ($this->optionInputs as $option) {
            if (strlen($option) < 1 || strlen($option) > 50) {
                $this->alert('error', 'Yanıt en az 1 en fazla 50 karakter olmalıdır.');
                return false;
            }
        }

        return true;
    }

    public function createPoll()
    {

        if (!$this->validateOptions()) return;

        $messages = [
            'question.required' => 'Sorusu olmayan anket olmaz!',
            'question.min' => 'Soru en az :min karakter olmalıdır.',
            'question.max' => 'Soru en fazla :max karakter olmalıdır.',
        ];

        try {
            $this->validate([
                'question' => 'bail|required|min:2|max:100',
            ], $messages);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            $errorMessage = implode('<br>', $errors);
            $this->alert('error', $errorMessage);
            return;
        }

        $options = array_map(function ($option) {
            return $option;
        }, $this->optionInputs);

        $pollData = [
            'question' => $this->question,
            'options' => $options,
        ];

        $this->dispatch('poll-created', $pollData);

        $this->alert('success', 'Anket oluşturuldu.');

        // Reset form
        $this->question = '';
        $this->optionInputs = [
            '',
            '',
        ];
    }

    public function render()
    {
        return view('livewire.modals.create-poll-modal');
    }
}
