# 📊 Fluxo Completo da Classe GrupoEconomico

## 🎯 Visão Geral

A classe **GrupoEconomico** é uma das entidades principais do sistema de gestão empresarial. Ela representa a estrutura corporativa de holdings e vinculações de empresas, permitindo organizar múltiplas bandeiras e unidades sob um mesmo grupo econômico.

---

## 🏗️ Arquitetura do Sistema

O sistema utiliza a arquitetura **TALL Stack** (Tailwind, Alpine.js, Laravel, Livewire) com os seguintes componentes:

```
┌─────────────────────────────────────────────────────────────┐
│                      CAMADA DE APRESENTAÇÃO                  │
│  ┌────────────────────────────────────────────────────┐     │
│  │  Blade View (grupos-economicos-table.blade.php)    │     │
│  │  - Interface visual (HTML + Tailwind CSS)          │     │
│  │  - Interações do usuário                           │     │
│  └────────────────────────────────────────────────────┘     │
└─────────────────────────────────────────────────────────────┘
                            ↕️ (Wire directives)
┌─────────────────────────────────────────────────────────────┐
│                    CAMADA DE COMPONENTES                     │
│  ┌────────────────────────────────────────────────────┐     │
│  │  Livewire Component (GruposEconomicosTable.php)    │     │
│  │  - Lógica de negócio                               │     │
│  │  - Gerenciamento de estado                         │     │
│  │  - Validações                                       │     │
│  │  - Ações CRUD                                       │     │
│  └────────────────────────────────────────────────────┘     │
└─────────────────────────────────────────────────────────────┘
                            ↕️ (Eloquent ORM)
┌─────────────────────────────────────────────────────────────┐
│                      CAMADA DE MODELO                        │
│  ┌────────────────────────────────────────────────────┐     │
│  │  Model (GrupoEconomico.php)                        │     │
│  │  - Definição da entidade                           │     │
│  │  - Relacionamentos                                  │     │
│  │  - Auditoria                                        │     │
│  └────────────────────────────────────────────────────┘     │
└─────────────────────────────────────────────────────────────┘
                            ↕️ (Query Builder)
┌─────────────────────────────────────────────────────────────┐
│                    CAMADA DE PERSISTÊNCIA                    │
│  ┌────────────────────────────────────────────────────┐     │
│  │  Database (MySQL/PostgreSQL)                       │     │
│  │  - Tabela: grupo_economicos                        │     │
│  └────────────────────────────────────────────────────┘     │
└─────────────────────────────────────────────────────────────┘
```

---

## 📁 Estrutura de Arquivos

```
gestao-empresarial/
├── app/
│   ├── Models/
│   │   └── GrupoEconomico.php              # Model Eloquent
│   └── Livewire/
│       └── GrupoEconomico/
│           └── GruposEconomicosTable.php   # Componente Livewire
├── resources/
│   └── views/
│       └── livewire/
│           └── grupo-economico/
│               └── grupos-economicos-table.blade.php  # View
├── database/
│   ├── migrations/
│   │   └── 2025_10_23_034304_create_grupo_economicos_table.php
│   ├── factories/
│   │   └── GrupoEconomicoFactory.php       # Factory para testes
│   └── seeders/
│       └── GrupoEconomicoSeeder.php        # Seeder para dados iniciais
└── routes/
    └── web.php                              # Definição de rotas
```

---

## 🗄️ 1. CAMADA DE BANCO DE DADOS

### 1.1 Migration - Estrutura da Tabela

**Arquivo:** `database/migrations/2025_10_23_034304_create_grupo_economicos_table.php`

```php
Schema::create('grupo_economicos', function (Blueprint $table) {
    $table->id();                    // Chave primária auto-incremento
    $table->string('nome')->unique(); // Nome do grupo (único)
    $table->string('cnpj', 20)->nullable();      // CNPJ Master
    $table->string('responsavel')->nullable();   // Nome do responsável
    $table->enum('status', ['ativo', 'pendente', 'arquivado'])->default('ativo');
    $table->timestamps();            // created_at e updated_at
});
```

**Campos da Tabela:**
- `id`: Identificador único (Primary Key)
- `nome`: Nome do grupo econômico (obrigatório, único)
- `cnpj`: CNPJ da empresa matriz (opcional)
- `responsavel`: Nome do responsável pelo grupo (opcional)
- `status`: Estado do grupo (ativo, pendente, arquivado)
- `created_at`: Data de criação
- `updated_at`: Data da última atualização

### 1.2 Factory - Geração de Dados Fake

**Arquivo:** `database/factories/GrupoEconomicoFactory.php`

```php
public function definition(): array
{
    return [
        'nome' => $this->faker->company(),
        'cnpj' => $this->faker->numerify('##.###.###/0001-##'),
        'responsavel' => $this->faker->name(),
        'status' => $this->faker->randomElement(['ativo', 'pendente', 'arquivado']),
    ];
}
```

**Uso:** Permite criar dados de teste rapidamente:
```php
GrupoEconomico::factory()->count(50)->create();
```

---

## 🎨 2. CAMADA DE MODELO (Model)

**Arquivo:** `app/Models/GrupoEconomico.php`

### 2.1 Definição da Classe

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class GrupoEconomico extends Model implements Auditable
{
    use HasFactory, AuditableTrait;
    
    protected $table = 'grupo_economicos';
    
    protected $fillable = [
        'nome',
        'cnpj',
        'responsavel',
        'status',
    ];
    
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    
    // Relacionamento: Um Grupo tem muitas Bandeiras
    public function bandeiras()
    {
        return $this->hasMany(Bandeira::class, 'grupo_economico_id');
    }
}
```

### 2.2 Características do Model

**Traits Utilizadas:**
- `HasFactory`: Permite usar factories para criar instâncias
- `AuditableTrait`: Registra todas as alterações (criação, edição, exclusão)

**Auditoria Automática:**
Toda operação CRUD é registrada automaticamente na tabela `audits`:
- Quem fez a alteração
- Quando foi feita
- Quais campos foram modificados
- Valores antigos e novos

**Relacionamentos:**
```php
// Um Grupo Econômico possui várias Bandeiras
$grupo = GrupoEconomico::find(1);
$bandeiras = $grupo->bandeiras; // Retorna Collection de Bandeiras
```

**Mass Assignment Protection:**
Apenas os campos em `$fillable` podem ser preenchidos em massa:
```php
GrupoEconomico::create([
    'nome' => 'Grupo ABC',
    'cnpj' => '12.345.678/0001-90',
    'status' => 'ativo'
]);
```

---

## ⚙️ 3. CAMADA DE COMPONENTE LIVEWIRE

**Arquivo:** `app/Livewire/GrupoEconomico/GruposEconomicosTable.php`

### 3.1 Propriedades do Componente

```php
class GruposEconomicosTable extends Component
{
    use WithPagination;
    
    // --- PROPRIEDADES DE LISTAGEM ---
    public string $search = '';           // Termo de busca
    public string $status = '';           // Filtro de status
    public string $sortField = 'nome';    // Campo de ordenação
    public string $sortDirection = 'asc'; // Direção da ordenação
    public string $viewMode = 'table';    // Modo de visualização (table/grid)
    
    // --- AÇÕES EM MASSA ---
    public array $selected = [];          // IDs selecionados
    public bool $selectAll = false;       // Selecionar todos
    
    // --- PROPRIEDADES DO FORMULÁRIO ---
    public bool $showingModal = false;    // Controle do modal
    public ?int $grupoId = null;          // ID do grupo (null = criar, int = editar)
    public string $nome = '';
    public string $cnpj = '';
    public string $responsavel = '';
    public string $formStatus = 'ativo';
}
```

### 3.2 Validação de Dados

```php
protected function rules(): array
{
    return [
        'nome' => [
            'required',
            'string',
            'max:255',
            Rule::unique('grupo_economicos', 'nome')->ignore($this->grupoId)
        ],
        'cnpj' => ['nullable', 'string', 'max:20'],
        'responsavel' => ['nullable', 'string', 'max:255'],
        'formStatus' => ['required', 'in:ativo,pendente,arquivado'],
    ];
}
```

**Regras de Validação:**
- `nome`: Obrigatório, único (exceto ao editar o próprio registro)
- `cnpj`: Opcional, máximo 20 caracteres
- `responsavel`: Opcional, máximo 255 caracteres
- `formStatus`: Obrigatório, deve ser um dos valores permitidos

### 3.3 Métodos Principais

#### 🔍 **Busca e Filtragem**

```php
protected function getFilteredQuery()
{
    return GrupoEconomico::query()
        ->when($this->search, function ($q) {
            $q->where(function($sub) {
                $sub->where('nome', 'like', '%' . $this->search . '%')
                    ->orWhere('cnpj', 'like', '%' . $this->search . '%');
            });
        })
        ->when($this->status, function ($q) {
            $q->where('status', $this->status);
        })
        ->orderBy($this->sortField, $this->sortDirection);
}
```

**Fluxo:**
1. Inicia query no modelo GrupoEconomico
2. Se houver termo de busca, filtra por nome OU cnpj
3. Se houver filtro de status, aplica filtro
4. Ordena pelos campos definidos
5. Retorna query builder (não executada)

#### 📊 **Ordenação**

```php
public function sortBy($field)
{
    if ($this->sortField === $field) {
        // Se clicar no mesmo campo, inverte a direção
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
    } else {
        // Se clicar em campo diferente, ordena ascendente
        $this->sortDirection = 'asc';
    }
    $this->sortField = $field;
}
```

#### ➕ **Criar Novo Grupo**

```php
public function showCreateModal(): void
{
    $this->resetValidation();
    $this->reset(['nome', 'cnpj', 'responsavel', 'grupoId']);
    $this->formStatus = 'ativo';
    $this->showingModal = true;
}
```

**Fluxo:**
1. Limpa erros de validação anteriores
2. Reseta campos do formulário
3. Define status padrão como 'ativo'
4. Exibe o modal

#### ✏️ **Editar Grupo Existente**

```php
public function showEditModal(int $grupoId): void
{
    $this->resetValidation();
    $grupo = GrupoEconomico::findOrFail($grupoId);
    
    $this->grupoId = $grupo->id;
    $this->nome = $grupo->nome;
    $this->cnpj = $grupo->cnpj ?? '';
    $this->responsavel = $grupo->responsavel ?? '';
    $this->formStatus = $grupo->status ?? 'ativo';
    
    $this->showingModal = true;
}
```

**Fluxo:**
1. Limpa erros de validação
2. Busca o grupo no banco (lança exceção se não encontrar)
3. Preenche as propriedades do componente com os dados do grupo
4. Exibe o modal

#### 💾 **Salvar Grupo (Criar ou Atualizar)**

```php
public function saveGrupo(): void
{
    $this->validate();
    
    $data = [
        'nome' => $this->nome,
        'cnpj' => $this->cnpj,
        'responsavel' => $this->responsavel,
        'status' => $this->formStatus,
    ];
    
    if ($this->grupoId) {
        // ATUALIZAR
        $grupo = GrupoEconomico::findOrFail($this->grupoId);
        $grupo->update($data);
        $message = 'Grupo Econômico atualizado com sucesso!';
    } else {
        // CRIAR
        GrupoEconomico::create($data);
        $message = 'Grupo Econômico criado com sucesso!';
    }
    
    $this->showingModal = false;
    $this->reset(['nome', 'cnpj', 'responsavel', 'grupoId']);
    session()->flash('success', $message);
}
```

**Fluxo:**
1. Valida os dados do formulário
2. Prepara array com os dados
3. Verifica se é criação ou edição:
   - Se `grupoId` existe → ATUALIZA registro existente
   - Se `grupoId` é null → CRIA novo registro
4. Fecha o modal
5. Limpa os campos
6. Exibe mensagem de sucesso

#### 🗑️ **Excluir Grupo Individual**

```php
public function deleteGrupo(int $grupoId): void
{
    GrupoEconomico::destroy($grupoId);
    session()->flash('success', 'Grupo Econômico excluído com sucesso!');
}
```

**Fluxo:**
1. Exclui o registro do banco
2. Exibe mensagem de sucesso
3. A view é automaticamente atualizada (reatividade do Livewire)

#### 🗑️ **Excluir Múltiplos Grupos**

```php
public function deleteSelected()
{
    if (empty($this->selected)) return;
    
    GrupoEconomico::whereIn('id', $this->selected)->delete();
    $this->selected = [];
    $this->selectAll = false;
    
    session()->flash('success', 'Registros selecionados excluídos com sucesso!');
}
```

**Fluxo:**
1. Verifica se há itens selecionados
2. Exclui todos os registros cujos IDs estão no array `$selected`
3. Limpa a seleção
4. Exibe mensagem de sucesso

#### 📥 **Exportar para CSV**

```php
public function exportCsv()
{
    $fileName = 'grupos_economicos_' . date('Y-m-d_H-i') . '.csv';
    $headers = [
        'Content-type' => 'text/csv',
        'Content-Disposition' => "attachment; filename=$fileName",
        'Pragma' => 'no-cache',
        'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
        'Expires' => '0',
    ];
    
    $columns = ['ID', 'Nome', 'CNPJ', 'Responsável', 'Status', 'Criado em'];
    
    $callback = function() use ($columns) {
        $file = fopen('php://output', 'w');
        fputcsv($file, $columns);
        
        $this->getFilteredQuery()->chunk(100, function($grupos) use ($file) {
            foreach ($grupos as $grupo) {
                fputcsv($file, [
                    $grupo->id,
                    $grupo->nome,
                    $grupo->cnpj,
                    $grupo->responsavel,
                    $grupo->status,
                    $grupo->created_at,
                ]);
            }
        });
        
        fclose($file);
    };
    
    return response()->stream($callback, 200, $headers);
}
```

**Fluxo:**
1. Define nome do arquivo com timestamp
2. Configura headers HTTP para download
3. Cria callback que:
   - Abre stream de saída
   - Escreve cabeçalhos das colunas
   - Processa registros em lotes de 100 (otimização de memória)
   - Escreve cada linha no CSV
4. Retorna resposta em streaming (não carrega tudo na memória)

#### 🔄 **Renderização**

```php
public function render()
{
    return view('livewire.grupo-economico.grupos-economicos-table', [
        'grupos' => $this->getFilteredQuery()->paginate(10),
    ])->layout('layouts.executive');
}
```

**Fluxo:**
1. Executa a query filtrada
2. Pagina os resultados (10 por página)
3. Passa os dados para a view
4. Usa o layout 'executive'

---

## 🎨 4. CAMADA DE VISUALIZAÇÃO (View)

**Arquivo:** `resources/views/livewire/grupo-economico/grupos-economicos-table.blade.php`

### 4.1 Estrutura da Interface

```
┌─────────────────────────────────────────────────────────┐
│  📊 Grupos Econômicos                    [Exportar] [+] │
├─────────────────────────────────────────────────────────┤
│  🔍 [Buscar...]  │ [Todos] [Ativos] [Pendentes] [Arq.]  │
│                                    10-20 de 50  [📊][🔲] │
├─────────────────────────────────────────────────────────┤
│  ☑ │ Nome          │ CNPJ    │ Vínculos │ Resp │ Status│
│  ☐ │ Grupo ABC     │ 12.345  │ 5 Emp.   │ João │ 🟢    │
│  ☐ │ Holding XYZ   │ 98.765  │ 12 Emp.  │ Maria│ 🟡    │
├─────────────────────────────────────────────────────────┤
│                    « 1 2 3 4 5 »                        │
└─────────────────────────────────────────────────────────┘
```

### 4.2 Componentes da Interface

#### 📌 **Header**
- Título e descrição
- Botão "Exportar CSV"
- Botão "Criar Grupo"

#### 🔍 **Barra de Filtros**
- Campo de busca (debounce de 300ms)
- Chips de filtro por status
- Contador de registros
- Toggle de visualização (tabela/grid)
- Botão de exclusão em massa (quando há seleção)

#### 📊 **Visualização em Tabela**
- Checkbox de seleção em massa
- Colunas ordenáveis
- Badges de status coloridos
- Ações por linha (editar, excluir)

#### 🔲 **Visualização em Grid**
- Cards responsivos
- Informações resumidas
- Ações inline

#### 📄 **Paginação**
- Links automáticos do Laravel
- Informações de página atual

#### 🪟 **Modal de Formulário**
- Campos do formulário
- Validação em tempo real
- Botões de ação (Cancelar, Salvar)

### 4.3 Interatividade Livewire

**Wire Directives Utilizadas:**

```blade
{{-- Busca com debounce --}}
<input wire:model.live.debounce.300ms="search" />

{{-- Ação de clique --}}
<button wire:click="showCreateModal">Criar Grupo</button>

{{-- Confirmação antes da ação --}}
<button wire:click="deleteGrupo({{ $grupo->id }})" 
        wire:confirm="Tem certeza que deseja excluir?">
    Excluir
</button>

{{-- Binding bidirecional --}}
<input wire:model="nome" type="text" />

{{-- Seleção múltipla --}}
<input wire:model.live="selected" value="{{ $grupo->id }}" type="checkbox" />
```

---

## 🔄 5. FLUXO COMPLETO DE OPERAÇÕES

### 5.1 Fluxo de Listagem

```
┌─────────────┐
│   USUÁRIO   │
│ Acessa /grupos
└──────┬──────┘
       │
       ▼
┌─────────────────────────────────┐
│  ROTA (web.php)                 │
│  Route::get('/grupos',          │
│    GruposEconomicosTable::class)│
└──────┬──────────────────────────┘
       │
       ▼
┌─────────────────────────────────┐
│  LIVEWIRE COMPONENT             │
│  GruposEconomicosTable          │
│  - Inicializa propriedades      │
│  - Chama método render()        │
└──────┬──────────────────────────┘
       │
       ▼
┌─────────────────────────────────┐
│  MÉTODO render()                │
│  - Executa getFilteredQuery()   │
│  - Aplica paginação (10 itens)  │
│  - Retorna view com dados       │
└──────┬──────────────────────────┘
       │
       ▼
┌─────────────────────────────────┐
│  ELOQUENT ORM                   │
│  - Monta SQL query              │
│  - Executa no banco             │
│  - Retorna Collection           │
└──────┬──────────────────────────┘
       │
       ▼
┌─────────────────────────────────┐
│  BLADE VIEW                     │
│  - Renderiza HTML               │
│  - Aplica Tailwind CSS          │
│  - Adiciona wire:directives     │
└──────┬──────────────────────────┘
       │
       ▼
┌─────────────────────────────────┐
│  NAVEGADOR DO USUÁRIO           │
│  - Exibe interface              │
│  - Aguarda interações           │
└─────────────────────────────────┘
```

### 5.2 Fluxo de Busca em Tempo Real

```
┌─────────────┐
│   USUÁRIO   │
│ Digita "ABC"│
└──────┬──────┘
       │ (aguarda 300ms - debounce)
       ▼
┌─────────────────────────────────┐
│  LIVEWIRE (JavaScript)          │
│  - Detecta mudança em $search   │
│  - Envia requisição AJAX        │
└──────┬──────────────────────────┘
       │
       ▼
┌─────────────────────────────────┐
│  LIVEWIRE COMPONENT (Backend)   │
│  - Atualiza propriedade $search │
│  - Chama updatingSearch()       │
│  - Reseta paginação para pág. 1 │
└──────┬──────────────────────────┘
       │
       ▼
┌─────────────────────────────────┐
│  MÉTODO render()                │
│  - getFilteredQuery() com busca │
│  - WHERE nome LIKE '%ABC%'      │
│  - OR cnpj LIKE '%ABC%'         │
└──────┬──────────────────────────┘
       │
       ▼
┌─────────────────────────────────┐
│  BANCO DE DADOS                 │
│  - Executa query filtrada       │
│  - Retorna resultados           │
└──────┬──────────────────────────┘
       │
       ▼
┌─────────────────────────────────┐
│  LIVEWIRE (JavaScript)          │
│  - Recebe HTML atualizado       │
│  - Faz diff do DOM              │
│  - Atualiza apenas o necessário │
└──────┬──────────────────────────┘
       │
       ▼
┌─────────────────────────────────┐
│  INTERFACE ATUALIZADA           │
│  - Mostra resultados filtrados  │
│  - SEM recarregar a página      │
└─────────────────────────────────┘
```

### 5.3 Fluxo de Criação de Grupo

```
┌─────────────┐
│   USUÁRIO   │
│ Clica [+Criar]
└──────┬──────┘
       │
       ▼
┌─────────────────────────────────┐
│  wire:click="showCreateModal"   │
│  - Envia evento ao backend      │
└──────┬──────────────────────────┘
       │
       ▼
┌─────────────────────────────────┐
│  MÉTODO showCreateModal()       │
│  - Limpa campos                 │
│  - $showingModal = true         │
└──────┬──────────────────────────┘
       │
       ▼
┌─────────────────────────────────┐
│  BLADE VIEW                     │
│  @if($showingModal)             │
│    <div class="modal">          │
│      <form>...</form>           │
│    </div>                       │
│  @endif                         │
└──────┬──────────────────────────┘
       │
       ▼
┌─────────────────────────────────┐
│  USUÁRIO PREENCHE FORMULÁRIO    │
│  - Nome: "Novo Grupo"           │
│  - CNPJ: "12.345.678/0001-90"   │
│  - Responsável: "João Silva"    │
│  - Status: "ativo"              │
└──────┬──────────────────────────┘
       │ (wire:model atualiza propriedades em tempo real)
       ▼
┌─────────────────────────────────┐
│  USUÁRIO CLICA [Salvar]         │
│  wire:click="saveGrupo"         │
└──────┬──────────────────────────┘
       │
       ▼
┌─────────────────────────────────┐
│  MÉTODO saveGrupo()             │
│  1. Valida dados                │
│  2. Prepara array $data         │
│  3. Verifica $grupoId           │
│  4. Como é null → CREATE        │
└──────┬──────────────────────────┘
       │
       ▼
┌─────────────────────────────────┐
│  ELOQUENT ORM                   │
│  GrupoEconomico::create($data)  │
│  - Monta INSERT SQL             │
│  - Executa no banco             │
└──────┬──────────────────────────┘
       │
       ▼
┌─────────────────────────────────┐
│  BANCO DE DADOS                 │
│  INSERT INTO grupo_economicos   │
│  VALUES (...)                   │
│  - Retorna ID do novo registro  │
└──────┬──────────────────────────┘
       │
       ▼
┌─────────────────────────────────┐
│  AUDITORIA (AuditableTrait)     │
│  - Registra evento "created"    │
│  - Salva em tabela "audits"     │
│  - Armazena dados do usuário    │
└──────┬──────────────────────────┘
       │
       ▼
┌─────────────────────────────────┐
│  MÉTODO saveGrupo() (cont.)     │
│  - $showingModal = false        │
│  - Limpa campos                 │
│  - Flash message de sucesso     │
└──────┬──────────────────────────┘
       │
       ▼
┌─────────────────────────────────┐
│  LIVEWIRE RE-RENDERIZA          │
│  - Modal fecha                  │
│  - Lista atualiza (novo item)   │
│  - Mostra mensagem de sucesso   │
└──────┬──────────────────────────┘
       │
       ▼
┌─────────────────────────────────┐
│  INTERFACE ATUALIZADA           │
│  ✅ "Grupo criado com sucesso!" │
│  - Novo grupo aparece na lista  │
└─────────────────────────────────┘
```

### 5.4 Fluxo de Edição de Grupo

```
┌─────────────┐
│   USUÁRIO   │
│ Clica [✏️ Editar] no grupo ID=5
└──────┬──────┘
       │
       ▼
┌─────────────────────────────────┐
│  wire:click="showEditModal(5)"  │
└──────┬──────────────────────────┘
       │
       ▼
┌─────────────────────────────────┐
│  MÉTODO showEditModal(5)        │
│  1. Busca grupo no banco        │
│     $grupo = GrupoEconomico     │
│              ::findOrFail(5)    │
│  2. Preenche propriedades       │
│     $this->grupoId = 5          │
│     $this->nome = $grupo->nome  │
│     ...                         │
│  3. $showingModal = true        │
└──────┬──────────────────────────┘
       │
       ▼
┌─────────────────────────────────┐
│  MODAL EXIBE COM DADOS          │
│  - Título: "Editar Grupo"       │
│  - Campos preenchidos           │
└──────┬──────────────────────────┘
       │
       ▼
┌─────────────────────────────────┐
│  USUÁRIO ALTERA DADOS           │
│  - Nome: "Grupo ABC Ltda"       │
│  - Status: "pendente"           │
└──────┬──────────────────────────┘
       │
       ▼
┌─────────────────────────────────┐
│  USUÁRIO CLICA [Salvar]         │
│  wire:click="saveGrupo"         │
└──────┬──────────────────────────┘
       │
       ▼
┌─────────────────────────────────┐
│  MÉTODO saveGrupo()             │
│  1. Valida dados                │
│  2. Prepara array $data         │
│  3. Verifica $grupoId           │
│  4. Como é 5 → UPDATE           │
│  5. Busca grupo                 │
│  6. $grupo->update($data)       │
└──────┬──────────────────────────┘
       │
       ▼
┌─────────────────────────────────┐
│  ELOQUENT ORM                   │
│  - Compara valores antigos/novos│
│  - Monta UPDATE SQL             │
│  - Executa no banco             │
└──────┬──────────────────────────┘
       │
       ▼
┌─────────────────────────────────┐
│  BANCO DE DADOS                 │
│  UPDATE grupo_economicos        │
│  SET nome='Grupo ABC Ltda',     │
│      status='pendente',         │
│      updated_at=NOW()           │
│  WHERE id=5                     │
└──────┬──────────────────────────┘
       │
       ▼
┌─────────────────────────────────┐
│  AUDITORIA (AuditableTrait)     │
│  - Registra evento "updated"    │
│  - Salva valores antigos        │
│  - Salva valores novos          │
│  - Identifica campos alterados  │
└──────┬──────────────────────────┘
       │
       ▼
┌─────────────────────────────────┐
│  INTERFACE ATUALIZADA           │
│  ✅ "Grupo atualizado!"         │
│  - Dados atualizados na lista   │
└─────────────────────────────────┘
```

### 5.5 Fluxo de Exclusão

```
┌─────────────┐
│   USUÁRIO   │
│ Clica [🗑️ Excluir] no grupo ID=3
└──────┬──────┘
       │
       ▼
┌─────────────────────────────────┐
│  wire:click="deleteGrupo(3)"    │
│  wire:confirm="Tem certeza?"    │
└──────┬──────────────────────────┘
       │
       ▼
┌─────────────────────────────────┐
│  LIVEWIRE (JavaScript)          │
│  - Exibe dialog de confirmação  │
│  - "Tem certeza que deseja      │
│     excluir?"                   │
└──────┬──────────────────────────┘
       │
       ▼ [USUÁRIO CONFIRMA]
┌─────────────────────────────────┐
│  MÉTODO deleteGrupo(3)          │
│  GrupoEconomico::destroy(3)     │
└──────┬──────────────────────────┘
       │
       ▼
┌─────────────────────────────────┐
│  ELOQUENT ORM                   │
│  - Busca registro ID=3          │
│  - Dispara evento "deleting"    │
│  - Executa DELETE               │
│  - Dispara evento "deleted"     │
└──────┬──────────────────────────┘
       │
       ▼
┌─────────────────────────────────┐
│  BANCO DE DADOS                 │
│  DELETE FROM grupo_economicos   │
│  WHERE id=3                     │
└──────┬──────────────────────────┘
       │
       ▼
┌─────────────────────────────────┐
│  AUDITORIA (AuditableTrait)     │
│  - Registra evento "deleted"    │
│  - Salva snapshot dos dados     │
│  - Permite recuperação futura   │
└──────┬──────────────────────────┘
       │
       ▼
┌─────────────────────────────────┐
│  INTERFACE ATUALIZADA           │
│  ✅ "Grupo excluído!"           │
│  - Item removido da lista       │
└─────────────────────────────────┘
```

### 5.6 Fluxo de Exportação CSV

```
┌─────────────┐
│   USUÁRIO   │
│ Clica [📥 Exportar]
└──────┬──────┘
       │
       ▼
┌─────────────────────────────────┐
│  wire:click="exportCsv"         │
└──────┬──────────────────────────┘
       │
       ▼
┌─────────────────────────────────┐
│  MÉTODO exportCsv()             │
│  1. Define nome do arquivo      │
│  2. Configura headers HTTP      │
│  3. Cria callback de streaming  │
└──────┬──────────────────────────┘
       │
       ▼
┌─────────────────────────────────┐
│  CALLBACK FUNCTION              │
│  1. Abre stream de saída        │
│  2. Escreve cabeçalhos CSV      │
│  3. Processa em chunks de 100   │
└──────┬──────────────────────────┘
       │
       ▼
┌─────────────────────────────────┐
│  BANCO DE DADOS                 │
│  - Executa query em lotes       │
│  - SELECT * FROM grupo_economicos
│    LIMIT 100 OFFSET 0           │
│  - SELECT * FROM grupo_economicos
│    LIMIT 100 OFFSET 100         │
│  - ...                          │
└──────┬──────────────────────────┘
       │
       ▼
┌─────────────────────────────────┐
│  STREAMING RESPONSE             │
│  - Envia dados progressivamente │
│  - Não sobrecarrega memória     │
│  - Permite arquivos grandes     │
└──────┬──────────────────────────┘
       │
       ▼
┌─────────────────────────────────┐
│  NAVEGADOR DO USUÁRIO           │
│  - Recebe arquivo CSV           │
│  - Inicia download              │
│  - grupos_economicos_2025-12-14_│
│    21-30.csv                    │
└─────────────────────────────────┘
```

---

## 🔐 6. SEGURANÇA E AUDITORIA

### 6.1 Auditoria Automática

Toda operação é registrada na tabela `audits`:

```sql
SELECT * FROM audits WHERE auditable_type = 'App\Models\GrupoEconomico';
```

**Exemplo de registro de auditoria:**
```json
{
  "id": 123,
  "user_id": 1,
  "event": "updated",
  "auditable_type": "App\\Models\\GrupoEconomico",
  "auditable_id": 5,
  "old_values": {
    "nome": "Grupo ABC",
    "status": "ativo"
  },
  "new_values": {
    "nome": "Grupo ABC Ltda",
    "status": "pendente"
  },
  "created_at": "2025-12-14 21:30:00"
}
```

### 6.2 Proteção contra Mass Assignment

Apenas campos em `$fillable` podem ser preenchidos:

```php
// ✅ PERMITIDO
GrupoEconomico::create([
    'nome' => 'Teste',
    'status' => 'ativo'
]);

// ❌ BLOQUEADO (id não está em $fillable)
GrupoEconomico::create([
    'id' => 999,
    'nome' => 'Teste'
]);
```

### 6.3 Validação de Unicidade

O nome do grupo deve ser único:

```php
Rule::unique('grupo_economicos', 'nome')->ignore($this->grupoId)
```

- Ao criar: verifica se nome já existe
- Ao editar: ignora o próprio registro na verificação

---

## 🎯 7. RELACIONAMENTOS

### 7.1 Grupo → Bandeiras (One-to-Many)

```php
// No Model GrupoEconomico
public function bandeiras()
{
    return $this->hasMany(Bandeira::class, 'grupo_economico_id');
}

// Uso:
$grupo = GrupoEconomico::find(1);
$bandeiras = $grupo->bandeiras; // Collection de Bandeiras

// Contar bandeiras
$totalBandeiras = $grupo->bandeiras()->count();

// Criar bandeira vinculada
$grupo->bandeiras()->create([
    'nome' => 'Nova Bandeira',
    'status' => 'ativo'
]);
```

### 7.2 Eager Loading (Otimização)

```php
// ❌ N+1 Problem (ruim)
$grupos = GrupoEconomico::all();
foreach ($grupos as $grupo) {
    echo $grupo->bandeiras()->count(); // Query por grupo!
}

// ✅ Eager Loading (bom)
$grupos = GrupoEconomico::withCount('bandeiras')->get();
foreach ($grupos as $grupo) {
    echo $grupo->bandeiras_count; // Sem queries extras!
}
```

---

## 📊 8. PERFORMANCE E OTIMIZAÇÕES

### 8.1 Paginação

```php
// Limita a 10 registros por página
$grupos = $this->getFilteredQuery()->paginate(10);
```

**Benefícios:**
- Reduz carga no banco
- Melhora tempo de resposta
- Melhor UX em grandes datasets

### 8.2 Chunking na Exportação

```php
$this->getFilteredQuery()->chunk(100, function($grupos) use ($file) {
    foreach ($grupos as $grupo) {
        fputcsv($file, [...]);
    }
});
```

**Benefícios:**
- Processa 100 registros por vez
- Não sobrecarrega memória
- Permite exportar milhões de registros

### 8.3 Debounce na Busca

```blade
<input wire:model.live.debounce.300ms="search" />
```

**Benefícios:**
- Aguarda 300ms após última digitação
- Reduz requisições ao servidor
- Melhora performance

### 8.4 Índices no Banco

```php
// Migration
$table->string('nome')->unique(); // Cria índice automático
$table->index('status');          // Índice para filtros
```

---

## 🧪 9. TESTES

### 9.1 Teste de Criação

```php
/** @test */
public function pode_criar_grupo_economico()
{
    Livewire::test(GruposEconomicosTable::class)
        ->set('nome', 'Grupo Teste')
        ->set('cnpj', '12.345.678/0001-90')
        ->set('responsavel', 'João Silva')
        ->set('formStatus', 'ativo')
        ->call('saveGrupo')
        ->assertHasNoErrors();
    
    $this->assertDatabaseHas('grupo_economicos', [
        'nome' => 'Grupo Teste',
        'cnpj' => '12.345.678/0001-90'
    ]);
}
```

### 9.2 Teste de Validação

```php
/** @test */
public function nome_e_obrigatorio()
{
    Livewire::test(GruposEconomicosTable::class)
        ->set('nome', '')
        ->call('saveGrupo')
        ->assertHasErrors(['nome' => 'required']);
}
```

### 9.3 Teste de Busca

```php
/** @test */
public function pode_buscar_por_nome()
{
    GrupoEconomico::factory()->create(['nome' => 'ABC Corp']);
    GrupoEconomico::factory()->create(['nome' => 'XYZ Ltd']);
    
    Livewire::test(GruposEconomicosTable::class)
        ->set('search', 'ABC')
        ->assertSee('ABC Corp')
        ->assertDontSee('XYZ Ltd');
}
```

---

## 📝 10. RESUMO DOS PRINCIPAIS CONCEITOS

### 10.1 Padrões Utilizados

✅ **MVC (Model-View-Controller)**
- Model: `GrupoEconomico.php`
- View: `grupos-economicos-table.blade.php`
- Controller: `GruposEconomicosTable.php` (Livewire Component)

✅ **Repository Pattern** (implícito no Eloquent)
- Abstração de acesso a dados
- Queries encapsuladas em métodos

✅ **Single Responsibility Principle**
- Model: apenas definição de entidade
- Component: apenas lógica de negócio
- View: apenas apresentação

### 10.2 Tecnologias

- **Laravel 11**: Framework PHP
- **Livewire 3**: Componentes reativos
- **Eloquent ORM**: Mapeamento objeto-relacional
- **Blade**: Template engine
- **Tailwind CSS**: Framework CSS
- **Alpine.js**: JavaScript reativo (usado pelo Livewire)

### 10.3 Funcionalidades Implementadas

✅ Listagem paginada
✅ Busca em tempo real
✅ Filtros por status
✅ Ordenação por colunas
✅ Visualização tabela/grid
✅ CRUD completo
✅ Validação de dados
✅ Seleção múltipla
✅ Exclusão em massa
✅ Exportação CSV
✅ Auditoria automática
✅ Interface responsiva
✅ Dark mode

---

## 🚀 11. PRÓXIMOS PASSOS

### Melhorias Possíveis:

1. **Importação de CSV**
2. **Filtros avançados** (data de criação, responsável)
3. **Soft Deletes** (exclusão lógica)
4. **Permissões** (controle de acesso por role)
5. **API REST** para integração externa
6. **Gráficos e dashboards**
7. **Notificações** (email ao criar/editar)
8. **Versionamento de dados**

---

## 📚 Referências

- [Documentação Laravel](https://laravel.com/docs)
- [Documentação Livewire](https://livewire.laravel.com)
- [Eloquent ORM](https://laravel.com/docs/eloquent)
- [Laravel Auditing](https://laravel-auditing.com)

---

**Documento gerado em:** 14/12/2025 21:54
**Versão:** 1.0
**Autor:** Antigravity AI Assistant
