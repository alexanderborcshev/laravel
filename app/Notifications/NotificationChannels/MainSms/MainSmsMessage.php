<?php

namespace App\Notifications\NotificationChannels\MainSms;

class MainSmsMessage{

    /**
     * @internal
     * @var array
     */
    public array $data = [];

    /**
     * @param string|null $content
     */
    public function __construct(string $content = null)
    {
        if ($content !== null) {
            $this->data['content'] = $content;
        }
    }

    /**
     * @param string $to
     * @return self
     */
    public function to(string $to): static
    {
        $this->data['to'] = $to;
        return $this;
    }

    /**
     * @param string $content
     * @return self
     */
    public function content(string $content): static
    {
        $this->data['content'] = $content;

        return $this;
    }
}
