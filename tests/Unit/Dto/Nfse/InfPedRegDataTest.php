<?php

use Nfse\Dto\Nfse\InfPedRegData;

it('sets defaults for optional fields and respects provided values', function () {
    $inf = new InfPedRegData(
        tipoAmbiente: 1,
        versaoAplicativo: '1.2',
        dataHoraEvento: '2025-01-01T12:00:00-03:00',
        chaveNfse: 'ABC',
    );

    expect($inf->nPedRegEvento)->toBe(1);
    expect($inf->tipoEvento)->toBe('101101');
    expect($inf->cnpjAutor)->toBeNull();
    expect($inf->cpfAutor)->toBeNull();
});

it('allows setting cpf and cnpj author fields', function () {
    $inf = new InfPedRegData(
        tipoAmbiente: 1,
        versaoAplicativo: '1.2',
        dataHoraEvento: '2025-01-01T12:00:00-03:00',
        chaveNfse: 'ABC',
        cnpjAutor: '12345678000199',
        cpfAutor: '11122233344',
        nPedRegEvento: 10,
        tipoEvento: '999999'
    );

    expect($inf->cnpjAutor)->toBe('12345678000199');
    expect($inf->cpfAutor)->toBe('11122233344');
    expect($inf->nPedRegEvento)->toBe(10);
    expect($inf->tipoEvento)->toBe('999999');
});
