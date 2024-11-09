<?php

declare(strict_types=1);

namespace Core\Libraries;

use Aura\Session\SessionFactory;
use Aura\Session\Session;

class SessionManager
{
    private Session $session;
    private $segment;

    public function __construct()
    {
        $factory = new SessionFactory();
        $this->session = $factory->newInstance($_COOKIE);
        $this->segment = $this->session->getSegment('Auth');
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->segment->get($key, $default);
    }

    public function set(string $key, mixed $value): void
    {
        $this->segment->set($key, $value);
    }

    public function has(string $key): bool
    {
        return $this->segment->get($key) !== null;
    }

    public function destroy(): void
    {
        $this->session->destroy();
    }

    public function regenerateId(): void
    {
        $this->session->regenerateId();
    }
}