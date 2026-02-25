# Visão Geral do Sistema OmniManager

## 🏢 O Que é o OmniManager?
O **OmniManager** é uma plataforma integrada de gestão empresarial (ERP) projetada para orquestrar operações complexas de grandes corporações que possuem múltiplas camadas hierárquicas, como Grupos Econômicos, Bandeiras Comerciais e Unidades Operacionais.

Diferente de sistemas genéricos, o OmniManager foca na **estrutura organizacional** e na **conformidade (compliance)**, garantindo que a gestão de pessoas, documentos e auditorias seja fluida, centralizada e auditável.

---

## 🎯 Quais Dores e Problemas Ele Resolve?

### 1. Descentralização e Caos de Informação
*   **A Dor:** Em grandes empresas, os dados costumam ficar espalhados em planilhas, sistemas legados desconectados e e-mails. É difícil saber "quantos colaboradores temos hoje na Unidade X?" ou "qual o status legal da Bandeira Y?".
*   **A Solução OmniManager:** Uma fonte única da verdade. O dashboard executivo consolida dados de todas as unidades e grupos em tempo real. Se uma unidade contrata alguém, o número sobe no painel instantaneamente.

### 2. Gestão de Conformidade e Auditoria (Compliance)
*   **A Dor:** Auditorias são processos dolorosos, reativos e manuais. Descobrir quem alterou um dado crítico há 3 meses é quase impossível sem logs detalhados.
*   **A Solução OmniManager:** O módulo de **Auditoria (Audit Log)** rastreia cada ação no sistema (quem fez, o que fez, quando fez, qual era o valor antigo e o novo). Isso transforma a auditoria em um processo proativo e transparente.

### 3. Hierarquia Complexa (Grupos > Bandeiras > Unidades)
*   **A Dor:** A maioria dos sistemas "SaaS" assume uma estrutura plana (uma empresa, vários usuários). Eles falham em modelar conglomerados onde um Grupo Econômico detém várias Bandeiras (marcas), e cada Bandeira tem centenas de Unidades (lojas/filiais).
*   **A Solução OmniManager:** A arquitetura do banco de dados e da interface foi construída nativamente para essa hierarquia de 3 níveis, permitindo relatórios e permissões granulares baseadas nessa estrutura.

### 4. Gestão de Documentos Desorganizada
*   **A Dor:** Documentos vitais (contratos sociais, alvarás, certificações) vencem sem ninguém notar, gerando multas e riscos legais.
*   **A Solução OmniManager:** O **Centro de Documentos** centraliza uploads e versionamento, permitindo associar documentos a unidades específicas e acompanhar sua vigência (embora o foco atual seja armazenamento seguro e organização).

---

## 🚀 Funcionalidades Chave

### 📊 Dashboard Executivo (Visão Geral)
*   **KPIs em Tempo Real:** Contador de Grupos, Bandeiras, Unidades e Colaboradores.
*   **Atividade Recente:** Feed estilo "rede social" mostrando as últimas ações críticas no sistema (ex: "Roberto atualizou o Contrato Social").
*   **Deep Linking:** Navegação rápida para qualquer entidade.

### 🏢 Gestão Estrutural (CRUDs Avançados)
*   **Grupos Econômicos:** A holding ou corporação mãe.
*   **Bandeiras:** As marcas ou divisões de negócio abaixo do grupo.
*   **Unidades:** As lojas físicas ou escritórios operacionais.
*   **Colaboradores:** O capital humano alocado em cada unidade.

### 🛡️ Governança e Segurança
*   **Auditoria Completa:** Rastreabilidade total de eventos de criação, atualização e exclusão.
*   **Controle de Acesso (ACL):** Perfis de usuário (Admin, Gestor, Operador) com permissões distintas.
*   **Internacionalização (i18n):** Suporte nativo para múltiplos idiomas (Português, Inglês, Espanhol, etc.), permitindo operação em multinacionais.

---

## 🛠️ Tecnologias e Diferenciais Técnicos
*   **Stack Moderna:** Construído sobre o ecossistema TALL (Tailwind CSS, Alpine.js, Laravel, Livewire), oferecendo a robustez do PHP com a interatividade de uma SPA (Single Page Application).
*   **Performance:** Uso de `wire:navigate` para navegação ultrarrápida sem recarregamento de página.
*   **Design Premium:** Interface focada em UX/UI de alta fidelidade, com modo escuro (Dark Mode) nativo e componentes visuais refinados.

---

## 💡 Conclusão
O OmniManager não é apenas um "cadastro". É uma ferramenta de **Governança Corporativa**. Ele remove a opacidade da operação, traz os dados para a luz e permite que executivos tomem decisões baseadas em fatos, enquanto garante que a operação na ponta esteja agindo dentro das regras (compliance).
