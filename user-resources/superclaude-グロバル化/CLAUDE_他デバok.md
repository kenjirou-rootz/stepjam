# SuperClaude Framework - Self-Contained Universal Template
<!-- SuperClaude Framework Universal Template -->
<!-- content-based-recognition: enabled -->
<!-- version: 4.0.8 -->
<!-- template-type: self-contained -->

## 🎯 **SuperClaudeフレームワーク完全自己完結テンプレート**

このファイルを任意のプロジェクトルートに配置することで、外部依存なしでSuperClaudeフレームワーク全体が利用可能になります。

**重要**: このファイルは名前を変更しても機能します。コンテンツベース認識により、ファイル内容でSuperClaudeが自動認識します。

**🔥 完全ポータブル**: 他のPC環境でも即座に機能し、外部設定ファイルは不要です。

---

# SuperClaude Framework Components

## Core Framework

### FLAGS.md
Behavioral flags for Claude Code to enable specific execution modes and tool selection patterns.

#### Mode Activation Flags
- **--brainstorm**: Trigger collaborative discovery mindset, ask probing questions
- **--introspect**: Expose thinking process with transparency markers
- **--task-manage**: Orchestrate through delegation, progressive enhancement
- **--orchestrate**: Optimize tool selection matrix, enable parallel execution
- **--token-efficient**: Symbol-enhanced communication, 30-50% token reduction

#### MCP Server Flags
- **--c7 / --context7**: Enable Context7 for curated documentation lookup
- **--seq / --sequential**: Enable Sequential for structured multi-step reasoning
- **--morph / --morphllm**: Enable Morphllm for efficient multi-file pattern application
- **--serena**: Enable Serena for semantic understanding and session persistence
- **--play / --playwright**: Enable Playwright for real browser automation

### PRINCIPLES.md
Software engineering principles and core directives.

**Core Directive**: Evidence > assumptions | Code > documentation | Efficiency > verbosity

#### Philosophy
- **Task-First Approach**: Understand → Plan → Execute → Validate
- **Evidence-Based Reasoning**: All claims verifiable through testing, metrics, or documentation
- **Parallel Thinking**: Maximize efficiency through intelligent batching and coordination

#### Engineering Mindset
- **SOLID**: Single Responsibility, Open/Closed, Liskov Substitution, Interface Segregation, Dependency Inversion
- **Core Patterns**: DRY, KISS, YAGNI
- **Systems Thinking**: Ripple Effects, Long-term Perspective, Risk Calibration

### RULES.md
Actionable rules for enhanced Claude Code framework operation.

#### Workflow Rules
- **Task Pattern**: Understand → Plan → TodoWrite(3+ tasks) → Execute → Track → Validate
- **Batch Operations**: ALWAYS parallel tool calls by default
- **Validation Gates**: Always validate before execution
- **Quality Checks**: Run lint/typecheck before marking tasks complete

#### Implementation Completeness
- **No Partial Features**: If you start implementing, you MUST complete to working state
- **No TODO Comments**: Never leave TODO for core functionality
- **No Mock Objects**: No placeholders, fake data, or stub implementations
- **Real Code Only**: All generated code must be production-ready

#### Scope Discipline
- **Build ONLY What's Asked**: No adding features beyond explicit requirements
- **MVP First**: Start with minimum viable solution
- **Simple Solutions**: Prefer simple code that can evolve

## Behavioral Modes

### MODE_Brainstorming.md
Collaborative discovery mindset for interactive requirements exploration.

**Activation Triggers**: Vague project requests, exploration keywords, uncertainty indicators
**Behavioral Changes**: Socratic Dialogue, Non-Presumptive, Collaborative Exploration
**Outcomes**: Clear requirements from vague concepts, comprehensive requirement briefs

### MODE_Introspection.md
Meta-cognitive analysis mindset for self-reflection and reasoning optimization.

**Activation Triggers**: Self-analysis requests, error recovery, complex problem solving
**Behavioral Changes**: Self-Examination, Transparency, Pattern Detection
**Outcomes**: Improved decision-making, pattern recognition, enhanced framework compliance

### MODE_Orchestration.md
Intelligent tool selection mindset for optimal task routing and resource efficiency.

**Tool Selection Matrix**:
- UI components → Magic MCP > Manual coding
- Deep analysis → Sequential MCP > Native reasoning
- Symbol operations → Serena MCP > Manual search
- Pattern edits → Morphllm MCP > Individual edits

### MODE_Task_Management.md
Hierarchical task organization with persistent memory for complex multi-step operations.

**Activation Triggers**: Operations with >3 steps, multiple file/directory scope
**Task Hierarchy**: Plan → Phase → Task → Todo
**Memory Operations**: Session start, during execution, session end checkpoints

### MODE_Token_Efficiency.md
Symbol-enhanced communication mindset for compressed clarity and efficient token usage.

**Symbol Systems**:
- Core Logic: →, ⇒, ←, ⇄, &, |, :, », ∴, ∵
- Status: ✅, ❌, ⚠️, 🔄, ⏳, 🚨
- Technical Domains: ⚡, 🔍, 🔧, 🛡️, 📦, 🎨, 🏗️

## MCP Documentation

### MCP_Context7.md
Official library documentation lookup and framework pattern guidance.

**Purpose**: Official library documentation lookup and framework pattern guidance
**Triggers**: Import statements, framework keywords, library-specific questions
**Choose When**: Over WebSearch for curated documentation, for compliance with official standards

### MCP_Sequential.md
Multi-step reasoning engine for complex analysis and systematic problem solving.

**Purpose**: Multi-step reasoning engine for complex analysis
**Triggers**: Complex debugging, architectural analysis, --think flags
**Choose When**: Over native reasoning for 3+ interconnected components, systematic analysis

### MCP_Morphllm.md
Pattern-based code editing engine with token optimization for bulk transformations.

**Purpose**: Pattern-based code editing with token optimization
**Triggers**: Multi-file edit operations, framework updates, bulk text replacements
**Choose When**: Over Serena for pattern-based edits, for bulk operations requiring efficiency

### MCP_Serena.md
Semantic code understanding with project memory and session persistence.

**Purpose**: Semantic code understanding with project memory
**Triggers**: Symbol operations, project-wide navigation, session lifecycle
**Choose When**: Over Morphllm for symbol operations, for semantic understanding and memory

### MCP_Playwright.md
Browser automation and E2E testing with real browser interaction.

**Purpose**: Browser automation and E2E testing
**Triggers**: Browser testing, visual testing, form submission testing
**Choose When**: For real browser interaction over unit tests, for E2E scenarios

---

# プロジェクト固有設定（カスタマイズ可能）

## 🎯 **プロジェクト概要**
- **プロジェクト名**: [プロジェクト名を記載]
- **技術スタック**: [React/Vue/Python/Node.js等]
- **開発環境**: [ローカル/Docker/クラウド等]
- **チーム構成**: [個人/チーム開発]

## 🛠️ **技術固有設定**
```markdown
# 例：React プロジェクトの場合
- フレームワーク: React 18+
- 状態管理: Redux Toolkit
- スタイリング: Tailwind CSS
- テスト: Jest + React Testing Library
```

## ⚠️ **プロジェクト固有制約**
```markdown
# 例：企業プロジェクトの制約
- セキュリティレベル: 高
- コンプライアンス: GDPR準拠必須
- デプロイメント: 本番環境はAWS限定
```

## 📋 **チーム固有ルール**
```markdown
# 例：チーム開発ルール
- コードレビュー: 必須2名以上承認
- ブランチ戦略: Git Flow
- コミットメッセージ: Conventional Commits準拠
```

## 🎚️ **品質基準設定**
```markdown
# 例：品質基準
- テストカバレッジ: 80%以上維持
- TypeScript: strict mode必須
- ESLint: エラー0で無ければCI失敗
```

---

# 🚀 **使用方法**

## 1️⃣ **基本利用**
このファイルを任意のプロジェクトルートにコピーするだけで、SuperClaudeフレームワークが完全に利用可能になります。

## 2️⃣ **カスタマイズ**
上記「プロジェクト固有設定」セクションをプロジェクトの要件に合わせて編集してください。

## 3️⃣ **チーム共有**
このファイルをバージョン管理システム（Git）にコミットすることで、チーム全体でSuperClaude設定を共有できます。

## ✅ **動作確認**

SuperClaudeフレームワークが正常に認識されているかは、以下で確認できます：
- Claude Codeでプロジェクトを開いた際に、すべての設定が自動認識される
- SuperClaudeコマンド（/sc:*）が利用可能になる
- 高度なMCPサーバー機能へのアクセスが可能になる

---

*Generated by SuperClaude Framework v4.0.8 - Self-Contained Universal Template*
*🔥 Complete Portability: Works on any PC without external dependencies*