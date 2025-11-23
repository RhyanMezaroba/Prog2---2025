<?php
// NÃO usar session_start() na view — já iniciado pelo controller.

// Recebe flash, old, errors
$flash = $_SESSION['flash'] ?? [];
$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];
unset($_SESSION['flash'], $_SESSION['errors'], $_SESSION['old']);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastrar Doação - DoaSys</title>
  <link rel="icon" type="image/x-icon" href="/static/favicon.ico">

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#3B82F6',
            secondary: '#10B981',
            accent: '#F59E0B'
          }
        }
      }
    }
  </script>

  <!-- Feather Icons -->
  <script src="https://unpkg.com/feather-icons"></script>

</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 to-green-50 font-sans">

  <!-- Navbar -->
  <custom-navbar></custom-navbar>

  <main class="max-w-3xl mx-auto p-6">
    <!-- Título -->
    <header class="text-center mb-10">
      <div class="flex justify-between items-center max-w-3xl mx-auto">
        <div class="flex items-center gap-4">
          <h1 class="text-3xl md:text-4xl font-bold text-gray-800 flex items-center gap-2 mb-0">
            <i data-feather="plus"></i> Cadastrar Nova Doação
          </h1>
          <a href="/DoaSys/app/migration/router.php?c=home&a=index" class="px-3 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Home</a>
        </div>
        <p class="text-gray-600">Preencha os dados da doação para registrar no sistema</p>
      </div>
    </header>

    <?php if (!empty($flash['success'])): ?>
      <div class="mb-6 p-4 rounded bg-green-100 text-green-800"><?php echo htmlspecialchars($flash['success']); ?></div>
    <?php endif; ?>
    <?php if (!empty($flash['error'])): ?>
      <div class="mb-6 p-4 rounded bg-red-100 text-red-800"><?php echo htmlspecialchars($flash['error']); ?></div>
    <?php endif; ?>

    <!-- Formulário -->
    <form id="doacaoForm" method="POST" action="/DoaSys/app/migration/router.php?c=donation&a=store" class="bg-white p-6 rounded-xl shadow-md space-y-8">

      <!-- DADOS DO DOADOR -->
      <section class="space-y-4">
        <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
          <i data-feather="user" class="text-primary"></i> Dados do Doador
        </h2>

        <div class="flex items-center gap-4">
          <label class="inline-flex items-center gap-2">
            <input type="checkbox" id="anonymousFlag" name="anonymous" value="1" class="form-checkbox h-5 w-5 text-primary" <?php echo (!empty($old['anonymous']) ? 'checked' : ''); ?>>
            <span class="text-gray-700">Cadastrar como anônimo</span>
          </label>
        </div>

        <div id="donorFields" class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <input type="text" name="nome_doador" placeholder="Nome do doador *" required class="px-3 py-2 border rounded w-full" value="<?php echo htmlspecialchars($old['nome_doador'] ?? ''); ?>">
          <?php if (!empty($errors['nome_doador'])): ?><div class="text-red-600 text-sm"><?php echo htmlspecialchars($errors['nome_doador']); ?></div><?php endif; ?>

          <input type="text" name="documento" placeholder="CPF ou CNPJ *" required class="px-3 py-2 border rounded w-full" value="<?php echo htmlspecialchars($old['documento'] ?? ''); ?>">
          <?php if (!empty($errors['documento'])): ?><div class="text-red-600 text-sm"><?php echo htmlspecialchars($errors['documento']); ?></div><?php endif; ?>

          <input type="email" name="email" placeholder="Email" class="px-3 py-2 border rounded w-full" value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>">
          <?php if (!empty($errors['email'])): ?><div class="text-red-600 text-sm"><?php echo htmlspecialchars($errors['email']); ?></div><?php endif; ?>

          <input type="tel" name="telefone" placeholder="Telefone *" required class="px-3 py-2 border rounded w-full" value="<?php echo htmlspecialchars($old['telefone'] ?? ''); ?>">
          <?php if (!empty($errors['telefone'])): ?><div class="text-red-600 text-sm"><?php echo htmlspecialchars($errors['telefone']); ?></div><?php endif; ?>
        </div>
      </section>

      <!-- DADOS DA DOAÇÃO -->
      <section class="space-y-4">
        <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
          <i data-feather="package" class="text-primary"></i> Dados da Doação
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <select name="categoria" required class="px-3 py-2 border rounded w-full">
            <option value="">Tipo de Doação *</option>
            <option value="alimentos" <?php echo (isset($old['categoria']) && $old['categoria'] === 'alimentos') ? 'selected' : ''; ?>>Alimentos</option>
            <option value="roupas" <?php echo (isset($old['categoria']) && $old['categoria'] === 'roupas') ? 'selected' : ''; ?>>Roupas</option>
            <option value="medicamentos" <?php echo (isset($old['categoria']) && $old['categoria'] === 'medicamentos') ? 'selected' : ''; ?>>Medicamentos</option>
            <option value="dinheiro" <?php echo (isset($old['categoria']) && $old['categoria'] === 'dinheiro') ? 'selected' : ''; ?>>Dinheiro</option>
            <option value="moveis" <?php echo (isset($old['categoria']) && $old['categoria'] === 'moveis') ? 'selected' : ''; ?>>Móveis</option>
            <option value="eletronicos" <?php echo (isset($old['categoria']) && $old['categoria'] === 'eletronicos') ? 'selected' : ''; ?>>Eletrônicos</option>
          </select>

          <!-- novo campo Título -->
          <input type="text" name="titulo" placeholder="Título da doação *" required class="px-3 py-2 border rounded w-full" value="<?php echo htmlspecialchars($old['titulo'] ?? ''); ?>">

          <input type="number" name="quantidade" placeholder="Quantidade *" required class="px-3 py-2 border rounded w-full" value="<?php echo htmlspecialchars($old['quantidade'] ?? ''); ?>">
          <textarea name="descricao" rows="3" placeholder="Descrição da doação" class="px-3 py-2 border rounded w-full md:col-span-2"><?php echo htmlspecialchars($old['descricao'] ?? ''); ?></textarea>
          <input type="number" step="0.01" name="valor" placeholder="Valor estimado (R$)" class="px-3 py-2 border rounded w-full" value="<?php echo htmlspecialchars($old['valor'] ?? ''); ?>">
          <input type="date" name="data_doacao" required class="px-3 py-2 border rounded w-full" value="<?php echo htmlspecialchars($old['data_doacao'] ?? ''); ?>">
        </div>
      </section>

      <!-- DADOS DO BENEFICIÁRIO -->
      <section class="space-y-4">
        <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
          <i data-feather="target" class="text-primary"></i> Dados do Beneficiário
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <input type="text" name="beneficiario_nome" placeholder="Nome *" required class="px-3 py-2 border rounded w-full" value="<?php echo htmlspecialchars($old['beneficiario_nome'] ?? ''); ?>">
          <input type="text" name="beneficiario_cpf" placeholder="CPF *" required class="px-3 py-2 border rounded w-full" value="<?php echo htmlspecialchars($old['beneficiario_cpf'] ?? ''); ?>">
          <input type="text" name="cep" placeholder="CEP *" required class="px-3 py-2 border rounded w-full" value="<?php echo htmlspecialchars($old['cep'] ?? ''); ?>">
          <input type="text" name="endereco" placeholder="Endereço *" required class="px-3 py-2 border rounded w-full" value="<?php echo htmlspecialchars($old['endereco'] ?? ''); ?>">
          <input type="text" name="bairro" placeholder="Bairro" class="px-3 py-2 border rounded w-full" value="<?php echo htmlspecialchars($old['bairro'] ?? ''); ?>">
          <input type="text" name="cidade" placeholder="Cidade *" required class="px-3 py-2 border rounded w-full" value="<?php echo htmlspecialchars($old['cidade'] ?? ''); ?>">
          <input type="text" name="estado" placeholder="Estado *" required class="px-3 py-2 border rounded w-full" value="<?php echo htmlspecialchars($old['estado'] ?? ''); ?>">
        </div>
      </section>

      <!-- Botões -->
      <div class="flex flex-col sm:flex-row gap-4 justify-end">
        <button type="button" onclick="window.location.href='/DoaSys/app/migration/router.php?c=donation&a=index'" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition flex items-center gap-2">
          <i data-feather="x"></i> Cancelar
        </button>
        <button type="submit" id="saveBtn" class="bg-primary hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold flex items-center gap-2 transition transform hover:scale-105">
          <i data-feather="save"></i> Salvar Doação
        </button>
      </div>
    </form>
  </main>

  <!-- Footer -->
  <custom-footer></custom-footer>

  <script src="components/navbar.js"></script>
  <script src="components/footer.js"></script>
  <script>
    feather.replace();

    // Helper: mantém somente dígitos
    const onlyDigits = s => (s || '').replace(/\D/g, '');

    // Máscaras (não mudadas)
    function maskCPF(v) {
      v = onlyDigits(v).slice(0,11);
      v = v.replace(/(\d{3})(\d)/, '$1.$2');
      v = v.replace(/(\d{3})(\d)/, '$1.$2');
      v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
      return v;
    }

    function maskCNPJ(v) {
      v = onlyDigits(v).slice(0,14);
      v = v.replace(/(\d{2})(\d)/, '$1.$2');
      v = v.replace(/(\d{3})(\d)/, '$1.$2');
      v = v.replace(/(\d{3})(\d)/, '$1/$2');
      v = v.replace(/(\d{4})(\d{1,2})$/, '$1-$2');
      return v;
    }

    function maskPhone(v) {
      v = onlyDigits(v);
      if (v.length <= 2) return v;
      const ddd = v.slice(0,2);
      const rest = v.slice(2);
      if (rest.length <= 4) return `${ddd} ${rest}`;
      if (rest.length <= 8) {
        return `${ddd} ${rest.slice(0,4)}-${rest.slice(4)}`;
      }
      return `${ddd} ${rest.slice(0,5)}-${rest.slice(5,9)}`;
    }

    function maskCEP(v) {
      v = onlyDigits(v).slice(0,8);
      v = v.replace(/(\d{5})(\d{1,3})$/, '$1-$2');
      return v;
    }

    function maskDocumentoAuto(v) {
      const digits = onlyDigits(v);
      if (digits.length > 11) {
        return maskCNPJ(digits);
      }
      return maskCPF(digits);
    }

    function attachMask(name, masker) {
      const el = document.querySelector(`[name="${name}"]`);
      if (!el) return;
      el.setAttribute('inputmode', 'numeric');
      el.addEventListener('input', () => {
        const pos = el.selectionStart;
        const oldLen = el.value.length;
        el.value = masker(el.value);
        const newLen = el.value.length;
        const diff = newLen - oldLen;
        el.setSelectionRange(Math.max(0, pos + diff), Math.max(0, pos + diff));
      });
      el.addEventListener('blur', () => {
        el.value = masker(el.value);
      });
    }

    attachMask('documento', maskDocumentoAuto);
    attachMask('beneficiario_cpf', maskCPF);
    attachMask('telefone', maskPhone);
    attachMask('cep', maskCEP);

    const anonymousCheckbox = document.getElementById('anonymousFlag');
    const donorFields = document.getElementById('donorFields');

    function applyAnonymousState() {
      const checked = anonymousCheckbox.checked;

      if (checked) {
        donorFields.classList.add('opacity-50', 'pointer-events-none');
        donorFields.setAttribute('aria-hidden', 'true');
      } else {
        donorFields.classList.remove('opacity-50', 'pointer-events-none');
        donorFields.removeAttribute('aria-hidden');
      }

      // Lidar com required/disabled dos inputs dentro de donorFields
      const inputs = donorFields.querySelectorAll('input, select, textarea');
      inputs.forEach(i => {
        if (checked) {
          // guarda estado required anterior
          if (i.required) i.dataset._required = '1';
          else i.dataset._required = '0';
          i.required = false;
          i.disabled = true;
          // NÃO apagamos os valores para não perder dados do usuário
        } else {
          i.disabled = false;
          i.required = i.dataset._required === '1';
          delete i.dataset._required;
        }
      });
    }

    anonymousCheckbox.addEventListener('change', applyAnonymousState);
    applyAnonymousState();

    // antes de submeter, remover máscaras (apenas os dígitos serão enviados)
    document.getElementById("doacaoForm").addEventListener("submit", function(e) {
      const docs = ['documento','beneficiario_cpf','telefone','cep'];
      docs.forEach(name => {
        const el = this.querySelector(`[name="${name}"]`);
        if (el && !el.disabled) el.value = onlyDigits(el.value);
      });
      // se anônimo, a checkbox já envia o valor '1'
    });

    // Notificação visual ao submeter (caso exista app)
    document.getElementById("doacaoForm").addEventListener("submit", function() {
      window.DoaSysApp?.showNotification?.("Salvando doação...", "info");
    });

  </script>

</body>
</html>
