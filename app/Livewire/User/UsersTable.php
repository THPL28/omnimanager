<?php

namespace App\Livewire\User;

use App\Models\User;
use App\Models\GrupoEconomico;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UsersTable extends Component
{
    use WithPagination;

    // --- PROPRIEDADES DE ESTADO ---
    public string $search = '';
    public bool $showingModal = false;
    
    // Campos do formulário
    public $userId;
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $role = 'user';
    public string $cargo = '';
    public ?int $grupo_economico_id = null;
    public bool $is_active = true;
    public bool $two_factor_enabled = false;

    // --- FILTROS E SELEÇÃO ---
    public $selectedRole = 'Todos';
    public array $selectedUsers = [];
    public bool $selectAll = false;

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->userId)
            ],
            'password' => $this->userId ? 'nullable|min:8' : 'required|min:8',
            'role' => 'required|string',
            'cargo' => 'nullable|string|max:100',
            'grupo_economico_id' => 'nullable|exists:grupo_economicos,id',
        ];
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatedSelectAll($value): void
    {
        if ($value) {
            $this->selectedUsers = User::pluck('id')->map(fn($id) => (string)$id)->toArray();
        } else {
            $this->selectedUsers = [];
        }
    }

    public function updatedSelectedUsers(): void
    {
        $this->selectAll = count($this->selectedUsers) === User::count();
    }

    public function setFilterRole($role): void
    {
        $this->selectedRole = $role;
        $this->resetPage();
    }

    public function toggleUserStatus(int $id): void
    {
        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();
        session()->flash('success', 'Status do usuário atualizado!');
    }

    // --- MÉTODOS DE CRUD ---

    public function showCreateModal(): void
    {
        $this->resetValidation();
        $this->reset(['name', 'email', 'password', 'role', 'cargo', 'grupo_economico_id', 'userId', 'is_active', 'two_factor_enabled']);
        $this->showingModal = true;
    }

    public function showEditModal(int $id): void
    {
        $this->resetValidation();
        $user = User::findOrFail($id);

        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->cargo = $user->cargo ?? '';
        $this->grupo_economico_id = $user->grupo_economico_id;
        $this->is_active = (bool)$user->is_active;
        $this->two_factor_enabled = (bool)$user->two_factor_enabled;
        $this->password = ''; // Limpa para não mostrar hash no input

        $this->showingModal = true;
    }

    public function saveUser(): void
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'cargo' => $this->cargo,
            'grupo_economico_id' => $this->grupo_economico_id,
            'is_active' => $this->is_active,
            'two_factor_enabled' => $this->two_factor_enabled,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        User::updateOrCreate(['id' => $this->userId], $data);

        $this->showingModal = false;
        $this->reset(['name', 'email', 'password', 'role', 'cargo', 'grupo_economico_id', 'userId']);
        session()->flash('success', $this->userId ? 'Usuário atualizado com sucesso!' : 'Usuário criado com sucesso!');
    }

    public function deleteUser(int $id): void
    {
        if ($id === auth()->id()) {
            session()->flash('error', 'Você não pode excluir seu próprio usuário!');
            return;
        }
        User::destroy($id);
        session()->flash('success', 'Usuário excluído com sucesso!');
    }

    public function render()
    {
        $grupos = GrupoEconomico::orderBy('nome')->get(['id', 'nome']);

        $query = User::with('grupo')
            ->when($this->search, function ($query) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('cargo', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->selectedRole !== 'Todos', function ($query) {
                $query->where('role', $this->selectedRole);
            })
            ->orderBy('name', 'asc');

        $usersCount = User::count();
        $adminsCount = User::where('role', 'admin')->count();
        $gerentesCount = User::where('role', 'gerente')->count();

        return view('livewire.user.users-table', [
            'users' => $query->paginate(10),
            'grupos' => $grupos,
            'totalCount' => $usersCount,
            'adminsCount' => $adminsCount,
            'gerentesCount' => $gerentesCount,
        ])->layout('layouts.app');
    }
}
