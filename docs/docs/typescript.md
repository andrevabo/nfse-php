# Geração de Tipos TypeScript

A biblioteca suporta a geração automática de tipos TypeScript a partir dos DTOs PHP. Isso é extremamente útil para desenvolvedores frontend que desejam manter a tipagem sincronizada com o backend.

## Configuração

A configuração da geração está no arquivo `typescript-transformer.php` na raiz do projeto. Ela define quais pastas procurar e onde salvar o arquivo gerado.

## Como Gerar

Para gerar ou atualizar os tipos, execute o script:

```bash
php scripts/generate-types.php
```

O arquivo de tipos será gerado em `types/generated.d.ts`.

## Exemplo de Saída

Um DTO PHP como este:

```php
/** @typescript */
class InfDpsData extends Data {
    public ?string $id;
    public ?int $tipoAmbiente;
}
```

Será convertido para este tipo TypeScript:

```typescript
export type InfDpsData = {
    id: string | null;
    tipoAmbiente: number | null;
}
```

Os nomes das propriedades são automaticamente convertidos para **snake_case** ou mantidos conforme a configuração do DTO.
