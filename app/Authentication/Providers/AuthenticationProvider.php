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

    /** @var bool */
    private $useLogin, $useImport;

    public function __construct(int $id, string $name, $options)
    {
        $this->id = $id;
        $this->name = $name;
        $this->options = $options;
    }

    /**
     * @return bool
     */
    public function useLogin(): bool
    {
        return $this->useLogin;
    }

    /**
     * @param bool $useLogin
     * @return self
     */
    public function setUseLogin(bool $useLogin): self
    {
        $this->useLogin = $useLogin;
        return $this;
    }

    /**
     * @return bool
     */
    public function useImport(): bool
    {
        return $this->useImport;
    }

    /**
     * @param bool $useImport
     * @return self
     */
    public function setUseImport(bool $useImport): self
    {
        $this->useImport = $useImport;
        return $this;
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
