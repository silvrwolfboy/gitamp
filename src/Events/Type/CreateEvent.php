<?php declare(strict_types = 1);

namespace ekinhbayar\GitAmp\Events\Type;

use ekinhbayar\GitAmp\Presentation\NumericalType;
use ekinhbayar\GitAmp\Presentation\Ring;

class CreateEvent extends BaseEvent
{
    public function __construct(array $event)
    {
        parent::__construct(
            (int) $event['id'],
            new NumericalType(6),
            'CreateEvent',
            $event['repo']['name'],
            $this->buildUrl($event),
            $this->buildPayload($event),
            $this->buildMessage($event),
            new Ring(3000, 80)
        );
    }

    private function buildUrl(array $event): string
    {
        return 'https://github.com/' . $event['repo']['name'];
    }

    private function buildPayload(array $event): string
    {
        if (isset($event['payload']['description'])) {
            return $event['payload']['description'];
        }

        return 'https://github.com/' . $event['repo']['name'];
    }

    private function buildMessage(array $event): string
    {
        return sprintf('%s created %s', $event['actor']['login'], $event['repo']['name']);
    }
}
