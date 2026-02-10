<?php

namespace Nfse\Http\Exceptions;

use Exception;

class NfseApiException extends Exception
{
    private array $errors = [];

    public static function requestError(string $message, int $code = 0, array $errors = []): self
    {
        $exception = new self("Erro na requisição: {$message}", $code);
        $exception->errors = $errors;
        return $exception;
    }

    public static function responseError(string $message, int $code = 0, array $errors = []): self
    {
        $exception = new self("Erro na resposta da API: {$message}", $code);
        $exception->errors = $errors;
        return $exception;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
