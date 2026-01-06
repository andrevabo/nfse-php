<?php

use Nfse\Dto\Nfse\DpsData;
use Nfse\Validator\DpsValidator;

it('validates a valid DPS', function () {
    $dps = new DpsData([
        '@versao' => '1.00',
        'infDPS' => [
            '@Id' => 'DPS123',
            'tpAmb' => 2,
            'dhEmi' => '2023-01-01',
            'verAplic' => '1.0',
            'serie' => '1',
            'nDPS' => '100',
            'dCompet' => '2023-01-01',
            'tpEmit' => 1, // Prestador
            'cLocEmi' => '1234567',
            'prest' => [
                'CNPJ' => '12345678000199',
                'IM' => '12345',
                'xNome' => 'Prestador Teste',
                'end' => [
                    'endNac.cMun' => '1234567',
                    'endNac.CEP' => '12345678',
                    'xLgr' => 'Rua Teste',
                    'nro' => '100',
                    'xBairro' => 'Centro',
                ],
            ],
        ],
    ]);

    $validator = new DpsValidator;
    $result = $validator->validate($dps);

    expect($result->isValid)->toBeTrue();
    expect($result->errors)->toBeEmpty();
});

it('fails when Prestador is missing', function () {
    $dps = new DpsData([
        '@versao' => '1.00',
        'infDPS' => [
            '@Id' => 'DPS123',
            'tpAmb' => 2,
            'dhEmi' => '2023-01-01',
            'verAplic' => '1.0',
            'serie' => '1',
            'nDPS' => '100',
            'dCompet' => '2023-01-01',
            'tpEmit' => 1,
            'cLocEmi' => '1234567',
            'prest' => null, // Missing
        ],
    ]);

    $validator = new DpsValidator;
    $result = $validator->validate($dps);

    expect($result->isValid)->toBeFalse();
    expect($result->errors)->toContain('Prestador data is required.');
});

it('fails when Prestador address is missing and not emitter', function () {
    $dps = new DpsData([
        '@versao' => '1.00',
        'infDPS' => [
            '@Id' => 'DPS123',
            'tpAmb' => 2,
            'dhEmi' => '2023-01-01',
            'verAplic' => '1.0',
            'serie' => '1',
            'nDPS' => '100',
            'dCompet' => '2023-01-01',
            'tpEmit' => 2, // Tomador is emitter
            'cLocEmi' => '1234567',
            'prest' => [
                'CNPJ' => '12345678000199',
                'IM' => '12345',
                'xNome' => 'Prestador Teste',
                'end' => null, // Missing address
            ],
        ],
    ]);

    $validator = new DpsValidator;
    $result = $validator->validate($dps);

    expect($result->isValid)->toBeFalse();
    expect($result->errors)->toContain('Endereço do prestador é obrigatório quando o prestador não for o emitente.');
});

it('fails when Tomador is identified but address is missing', function () {
    $dps = new DpsData([
        '@versao' => '1.00',
        'infDPS' => [
            '@Id' => 'DPS123',
            'tpAmb' => 2,
            'dhEmi' => '2023-01-01',
            'verAplic' => '1.0',
            'serie' => '1',
            'nDPS' => '100',
            'dCompet' => '2023-01-01',
            'tpEmit' => 1,
            'cLocEmi' => '1234567',
            'prest' => [
                'CNPJ' => '12345678000199',
                'IM' => '12345',
                'xNome' => 'Prestador Teste',
                'end' => [
                    'endNac.cMun' => '1234567',
                    'endNac.CEP' => '12345678',
                    'xLgr' => 'Rua Teste',
                    'nro' => '100',
                    'xBairro' => 'Centro',
                ],
            ],
            'toma' => [
                'CPF' => '12345678901', // Identified
                'xNome' => 'Tomador Teste',
                'end' => null, // Missing address
            ],
        ],
    ]);

    $validator = new DpsValidator;
    $result = $validator->validate($dps);

    expect($result->isValid)->toBeFalse();
    expect($result->errors)->toContain('Endereço do tomador é obrigatório quando o tomador é identificado.');
});

it('fails when Tomador has NIF but missing foreign address', function () {
    $dps = new DpsData([
        '@versao' => '1.00',
        'infDPS' => [
            '@Id' => 'DPS123',
            'tpAmb' => 2,
            'dhEmi' => '2023-01-01',
            'verAplic' => '1.0',
            'serie' => '1',
            'nDPS' => '100',
            'dCompet' => '2023-01-01',
            'tpEmit' => 1,
            'cLocEmi' => '1234567',
            'prest' => [
                'CNPJ' => '12345678000199',
                'IM' => '12345',
                'xNome' => 'Prestador Teste',
                'end' => [
                    'endNac.cMun' => '1234567',
                    'endNac.CEP' => '12345678',
                    'xLgr' => 'Rua Teste',
                    'nro' => '100',
                    'xBairro' => 'Centro',
                ],
            ],
            'toma' => [
                'NIF' => 'NIF123', // Foreign
                'xNome' => 'Tomador Estrangeiro',
                'end' => [
                    'endExt' => null, // Missing foreign address
                ],
            ],
        ],
    ]);

    $validator = new DpsValidator;
    $result = $validator->validate($dps);

    expect($result->isValid)->toBeFalse();
    expect($result->errors)->toContain('Endereço no exterior do tomador é obrigatório quando identificado por NIF.');
});

it('fails when Tomador has CPF but missing national address', function () {
    $dps = new DpsData([
        '@versao' => '1.00',
        'infDPS' => [
            '@Id' => 'DPS123',
            'tpAmb' => 2,
            'dhEmi' => '2023-01-01',
            'verAplic' => '1.0',
            'serie' => '1',
            'nDPS' => '100',
            'dCompet' => '2023-01-01',
            'tpEmit' => 1,
            'cLocEmi' => '1234567',
            'prest' => [
                'CNPJ' => '12345678000199',
                'IM' => '12345',
                'xNome' => 'Prestador Teste',
                'end' => [
                    'endNac.cMun' => '1234567',
                    'endNac.CEP' => '12345678',
                    'xLgr' => 'Rua Teste',
                    'nro' => '100',
                    'xBairro' => 'Centro',
                ],
            ],
            'toma' => [
                'CPF' => '12345678901', // National
                'xNome' => 'Tomador Nacional',
                'end' => [
                    'endNac.cMun' => null, // Missing cMun
                ],
            ],
        ],
    ]);

    $validator = new DpsValidator;
    $result = $validator->validate($dps);

    expect($result->isValid)->toBeFalse();
    expect($result->errors)->toContain('Código do município do tomador é obrigatório para endereço nacional.');
});
