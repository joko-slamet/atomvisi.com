<?php

namespace App\Livewire;

use App\Models\NewsletterSubscriber;
use Livewire\Attributes\Validate;
use Livewire\Component;

class NewsletterSubscribe extends Component
{
    #[Validate('required|email|max:255')]
    public string $email = '';

    public bool $subscribed = false;

    public function submit(): void
    {
        $this->validate();

        NewsletterSubscriber::firstOrCreate(['email' => $this->email]);

        $this->reset('email');
        $this->subscribed = true;
    }

    public function render()
    {
        return view('livewire.newsletter-subscribe');
    }
}
