<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Notifications extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $message_key = session()->get('notification');
        $hasMessage = $message_key !== null;
        $message = [
            'type'=>'info',
            'text' => $message_key
        ];
        $messages = $hasMessage ? config('app-notifications') : [];

        if ($hasMessage)
        {
            if (!empty($messages[$message_key]))
            {
                $message['type'] = $messages[$message_key]['type'];
                $message['text'] = trans($messages[$message_key]['text']);
            }
        }


        return view('components.notifications', compact('hasMessage', 'message'));
    }
}
