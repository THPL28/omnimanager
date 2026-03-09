# 🏢 OmniManager

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![Livewire](https://img.shields.io/badge/Livewire-3.x-4e56a6?style=for-the-badge&logo=livewire)](https://livewire.laravel.com)
[![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-4.0-38B2AC?style=for-the-badge&logo=tailwind-css)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge)](LICENSE)

**OmniManager** é uma robusta plataforma de Governança Corporativa e Gestão Empresarial (ERP) projetada para orquestrar operações complexas de grandes corporações com múltiplas camadas hierárquicas.

---

## 🎯 O Problema que Resolvemos

Diferente de sistemas SaaS genéricos, o OmniManager foca na **estrutura organizacional real** e no **compliance rigoroso**.

- **Hierarquia Complexa:** Suporte nativo para Grupos Econômicos ➔ Bandeiras Comerciais ➔ Unidades Operacionais.
- **Caos de Informação:** Centraliza dados dispersos em uma única "Fonte da Verdade".
- **Auditoria Proativa:** Rastreabilidade total de cada clique e alteração no sistema.
- **Gestão de Documentos:** Organização segura e centralizada de contratos, alvarás e certificações.

---

## 🚀 Funcionalidades Principais

- **📊 Dashboard Executivo:** Visualização em tempo real de KPIs críticos e feed de atividades recentes.
- **🏢 Gestão Estrutural:** Controle granular de holdings, marcas e filiais.
- **👥 Gestão de Colaboradores:** Alocação inteligente de RH por unidade.
- **🛡️ Audit Log Extremo:** Monitoramento detalhado de todas as ações para auditorias de compliance.
- **📁 Document Center:** Versionamento e armazenamento seguro de documentos corporativos.
- **🌐 Suporte Multi-idioma:** Interface preparada para multinacionais (PT-BR, EN, ES, FR, DE, etc).

---

## 🛠️ Stack Tecnológica

O projeto utiliza o estado da arte do ecossistema PHP (TALL Stack):

- **Core:** [Laravel 12.x](https://laravel.com)
- **Frontend Dinâmico:** [Livewire 3](https://livewire.laravel.com) & [Volt](https://livewire.laravel.com/docs/volt)
- **Styling:** [Tailwind CSS 4.0](https://tailwindcss.com) & [DaisyUI 5](https://daisyui.com)
- **Build Tool:** [Vite 7](https://vitejs.dev)
- **Compliance:** [Laravel Auditing](https://www.laravel-auditing.com)
- **Relatórios:** [Laravel Excel](https://docs.laravel-excel.com)

---

## ⚙️ Instalação e Configuração

### Requisitos
- PHP >= 8.2
- Node.js & NPM
- Composer

### Passo a Passo

1. **Clonar o repositório:**
   ```bash
   git clone git@github.com:THPL28/omnimanager.git
   cd omnimanager
   ```

2. **Instalar dependências PHP:**
   ```bash
   composer install
   ```

3. **Configurar ambiente:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configurar Banco de Dados:**
   No arquivo `.env`, ajuste as configurações de DB e execute:
   ```bash
   php artisan migrate --seed
   ```

5. **Instalar dependências Frontend:**
   ```bash
   npm install
   npm run dev
   ```

6. **Iniciar servidor:**
   ```bash
   php artisan serve
   ```

---

## 🛡️ Segurança e Auditoria

O OmniManager leva a segurança a sério. Cada alteração crítica no sistema gera um registro de auditoria que inclui:
- Usuário que realizou a ação.
- Endereço IP e User Agent.
- Valores antigos e novos (Payload completo).
- Timestamp preciso.

---

## 📄 Licença

Este projeto é um software de código aberto licenciado sob a [MIT license](LICENSE).

---

<p align="center">
  Desenvolvido por Tiago Looze 
</p>
