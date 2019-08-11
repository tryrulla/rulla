<?php

namespace Rulla\Authentication\Providers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class AuthenticationProvider
{
    /** @var integer */
    private $id;

    /** @var string */
    private $name;

    /** @var object|null */
    private $options;

    public function __construct(int $id, string $name, $options)
    {
        $this->id = $id;
        $this->name = $name;
        $this->options = $options;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return object|null
     */
    public function getOptions()
    {
        return $this->options;
    }

    abstract function authenticate(Request $request): Response;
}
