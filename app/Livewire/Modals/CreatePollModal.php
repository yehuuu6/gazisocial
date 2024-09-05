<?php
namespace App\Livewire\Modals;

use LivewireUI\Modal\ModalComponent;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Validation\ValidationException;

class CreatePollModal extends ModalComponent
{
    use LivewireAlert;

    public $question;
    public $optionInputs = [
        ['option' => ''],
        ['option' => ''],
    ];

    public function removeOption($index)
    {
        if (count($this->optionInputs) <= 2) {
            $this->alert('error', 'En az 2 seçenek olmalıdır.');
            return;
        }

        unset($this->optionInputs[$index]);
        $this->optionInputs = array_values($this->optionInputs);
    }

    public function addOption()
    {
        if (count($this->optionInputs) >= 5) {
            $this->alert('error', 'En fazla 5 seçenek ekleyebilirsiniz.');
            return;
        }

        $this->optionInputs[] = ['option' => ''];
        $this->optionInputs = array_values($this->optionInputs);
    }

    public function createPoll()
    {
        $messages = [
            'question.required' => 'Sorusu olmayan anket olmaz!',
            'question.min' => 'Soru en az :min karakter olmalıdır.',
            'question.max' => 'Soru en fazla :max karakter olmalıdır.',
            'optionInputs.*.option.required' => 'Yanıt boş bırakılamaz!',
            'optionInputs.*.option.string' => 'Yanıt metin olmalıdır.',
            'optionInputs.*.option.min' => 'Yanıt en az :min karakter olmalıdır.',
            'optionInputs.*.option.max' => 'Yanıt en fazla :max karakter olmalıdır.',
        ];

        try {
            $this->validate([
                'question' => 'bail|required|min:2|max:100',
            ], $messages);

            $this->validate([
                'optionInputs.*.option' => 'bail|required|string|min:1|max:50',
            ], $messages);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            $errorMessage = implode('<br>', $errors);
            $this->alert('error', $errorMessage);
            return;
        }

        $options = array_map(function($option) {
            return $option['option'];
        }, $this->optionInputs);

        $pollData = [
            'question' => $this->question,
            'options' => $options,
        ];

        $this->dispatch('pollCreated', $pollData);

        $this->alert('success', 'Anket oluşturuldu.');

        // Reset form
        $this->question = '';
        $this->optionInputs = [
            ['option' => ''],
            ['option' => ''],
        ];

        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.modals.create-poll-modal');
    }
}
