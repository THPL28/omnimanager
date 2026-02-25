<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.onboarding')]
class Onboarding extends Component
{
    public int $step = 1;

    public function render()
    {
        return view('livewire.onboarding');
    }

    public function nextStep(): void
    {
        if ($this->step < 4) {
             $this->step++;
        }
    }

    public function previousStep(): void
    {
        if ($this->step > 1) {
             $this->step--;
        }
    }

    public function skip(): void
    {
        $this->step = 4;
    }

    public function finish(): void
    {
        $this->redirect(route('register'), navigate: true);
    }
}
