Document Module (scaffold)

Como funciona:
- Provê rotas em `routes/modules/document.php`
- Controller em `app/Modules/Document/Http/Controllers/DocumentController.php`
- Views em `resources/views/modules/document`
- ServiceProvider em `app/Modules/Document/DocumentServiceProvider.php`

Para habilitar o módulo, registre o provider em `config/app.php` (providers):

    App\Modules\Document\DocumentServiceProvider::class,

Ou registre automaticamente via composer autoload e discovery.

Próximos passos:
- Implementar upload com versions
- Integrar assinaturas (Gov.br, D4Sign)
- Conectar com entidades (Empresa, Setor)

Atualizações feitas:
- Persistência: tabelas `documents` e `document_versions` (migrations)
- Livewire: `DocumentCenter` com upload e adição de versões
- Policies: `DocumentPolicy` e registro em `AppServiceProvider`

Como testar:
- `composer dump-autoload`
- `php artisan migrate`
- `php artisan storage:link`
- acessar `/documentos` e testar upload/versões

Observações:
- Atualmente as permissões usam `users.grupo_economico_id` e `users.role`.
- Integrações (assinatura/OCR) são planejadas como módulos premium.
