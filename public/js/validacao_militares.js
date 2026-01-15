document.addEventListener('DOMContentLoaded', function () {
  console.log('Script de validação carregado');
  const form = document.getElementById('cadastroMilitarForm');
  console.log('Formulário encontrado:', form ? 'SIM' : 'NÃO');
  if (!form) {
    console.error('Formulário com ID "cadastroMilitarForm" não encontrado');
    return;
  }

  // Mapeamento de nomes para labels amigáveis
  const fieldLabels = {
    'nome_militar': 'Nome (Militar)',
    'nome_guerra': 'Nome de guerra',
    'patente': 'Patente',
    'lotacao': 'Lotação',
    'doc_militar_numero': 'Número do documento militar',
    'doc_militar': 'Documento de identificação militar (PDF)',
    'nome_civil': 'Nome civil',
    'nome_mae': 'Nome da mãe',
    'doc_civil_numero': 'Número do documento civil',
    'doc_civil': 'Documento de identificação civil (PDF)',
    'endereco_pessoal': 'Endereço pessoal',
    'bairro_pessoal': 'Bairro pessoal',
    'cidade_pessoal': 'Cidade pessoal',
    'estado_pessoal': 'Estado pessoal',
    'cep_pessoal': 'CEP pessoal',
    'endereco_funcional': 'Endereço funcional',
    'bairro_funcional': 'Bairro funcional',
    'cidade_funcional': 'Cidade funcional',
    'estado_funcional': 'Estado funcional',
    'cep_funcional': 'CEP funcional',
    'qualificacao': 'Qualificação',
    'indicado_por': 'Indicado por',
    'telefone': 'Telefone',
    'email': 'Email',
    'conjuge': 'Cônjuge',
    'numero_filhos': 'Número de filhos',
    'tipo_sanguineo': 'Tipo sanguíneo',
    'vinculo_mp': 'Vínculo com MP'
  };

  // Campos obrigatórios
  const requiredFields = [
    'nome_militar',
    'patente',
    'lotacao',
    'doc_militar_numero',
    'doc_militar',
    'nome_mae',
    'doc_civil_numero',
    'doc_civil',
    'telefone',
    'email',
    'tipo_sanguineo',
    'vinculo_mp'
  ];

  function createAlert(messages) {
    console.log('createAlert chamado com mensagens:', messages);
    
    // Prefer showing messages in the Bootstrap error modal if present
    const modalEl = document.getElementById('errorModal');
    console.log('Modal de erro encontrado:', modalEl ? 'SIM' : 'NÃO');
    
    if (modalEl) {
      const body = document.getElementById('errorModalBody');
      console.log('Body do modal encontrado:', body ? 'SIM' : 'NÃO');
      
      if (body) {
        body.innerHTML = '';
        const ul = document.createElement('ul');
        ul.style.listStyleType = 'disc';
        ul.style.paddingLeft = '20px';
        ul.style.marginBottom = '0';
        messages.forEach(m => {
          const li = document.createElement('li');
          li.textContent = m;
          ul.appendChild(li);
        });
        body.appendChild(ul);
        console.log('Conteúdo do modal atualizado');
      }
      
      try {
        const modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) {
          modal.show();
          console.log('Modal existente mostrado');
        } else {
          const newModal = new bootstrap.Modal(modalEl);
          newModal.show();
          console.log('Novo modal criado e mostrado');
        }
      } catch (e) {
        console.error('Erro ao mostrar modal:', e);
      }
      return;
    }

    // Fallback: inline alert
    console.log('Usando fallback de alerta inline');
    let existing = document.getElementById('validationAlert');
    if (existing) existing.remove();
    const div = document.createElement('div');
    div.id = 'validationAlert';
    div.className = 'alert alert-danger';
    const ul = document.createElement('ul');
    messages.forEach(m => {
      const li = document.createElement('li');
      li.textContent = m;
      ul.appendChild(li);
    });
    div.appendChild(ul);
    form.parentNode.insertBefore(div, form);
    div.scrollIntoView({ behavior: 'smooth', block: 'center' });
  }

  function isValidEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
  }

  function isValidPhone(phone) {
    // Aceita formato com parênteses, hífen, espaço
    const re = /^(\(\d{2}\)\s?)?\d{4,5}-\d{4}$|^\d{10,11}$/;
    return re.test(phone.replace(/[\s.-]/g, ''));
  }

  function isValidCEP(cep) {
    const re = /^\d{5}-?\d{3}$/;
    return re.test(cep);
  }

  function isValidFile(fileInput) {
    if (!fileInput.files || fileInput.files.length === 0) {
      return false;
    }
    const file = fileInput.files[0];
    // Validar extensão
    const validExtensions = ['pdf'];
    const fileExt = file.name.split('.').pop().toLowerCase();
    if (!validExtensions.includes(fileExt)) {
      return false;
    }
    // Validar tamanho (máximo 20MB)
    const maxSize = 20 * 1024 * 1024;
    if (file.size > maxSize) {
      return false;
    }
    return true;
  }

  form.addEventListener('submit', function (e) {
    console.log('Evento submit disparado');
    e.preventDefault();
    console.log('Prevenção padrão aplicada');
    
    const errors = [];

    // Validar campos obrigatórios
    requiredFields.forEach(fieldName => {
      const field = form.elements[fieldName];
      if (!field) {
        console.warn(`Campo ${fieldName} não encontrado`);
        return;
      }

      let value = '';

      if (field.type === 'file') {
        // Para campos de arquivo
        if (!field.files || field.files.length === 0) {
          errors.push(`${fieldLabels[fieldName]} é obrigatório.`);
        } else if (!isValidFile(field)) {
          const file = field.files[0];
          const fileExt = file.name.split('.').pop().toLowerCase();
          if (fileExt !== 'pdf') {
            errors.push(`${fieldLabels[fieldName]} deve ser um arquivo PDF.`);
          } else {
            errors.push(`${fieldLabels[fieldName]} excede o tamanho máximo permitido (20MB).`);
          }
        }
      } else if (field.type === 'radio') {
        // Para campos radio (como vinculo_mp)
        const checkedRadio = form.querySelector(`input[name="${fieldName}"]:checked`);
        if (!checkedRadio) {
          errors.push(`${fieldLabels[fieldName]} é obrigatório.`);
        }
      } else if (field.tagName === 'SELECT') {
        // Para select
        value = field.value || '';
        if (!value) {
          errors.push(`${fieldLabels[fieldName]} é obrigatório.`);
        }
      } else {
        // Para input text, email, tel, etc
        value = field.value.trim() || '';
        if (!value) {
          errors.push(`${fieldLabels[fieldName]} é obrigatório.`);
        }
      }
    });

    // Validações adicionais específicas
    const nomeMilitar = form.elements['nome_militar']?.value.trim() || '';
    console.log('Nome militar:', nomeMilitar, 'Tamanho:', nomeMilitar.length);
    if (nomeMilitar && nomeMilitar.length < 12) {
      console.log('ERRO: Nome muito curto');
      errors.push('Nome (Militar) deve ter ao menos 12 caracteres.');
    }

    const nomeMae = form.elements['nome_mae']?.value.trim() || '';
    if (nomeMae && nomeMae.length < 3) {
      errors.push('Nome da mãe deve ter ao menos 3 caracteres.');
    }

    const email = form.elements['email']?.value.trim() || '';
    if (email && !isValidEmail(email)) {
      errors.push('Email inválido. Use o formato: usuario@dominio.com');
    }

    const telefone = form.elements['telefone']?.value.trim() || '';
    if (telefone && !isValidPhone(telefone)) {
      errors.push('Telefone inválido. Use o formato: (XX) XXXXX-XXXX ou (XX) XXXX-XXXX ou números apenas.');
    }

    const numeroFilhos = form.elements['numero_filhos']?.value;
    if (numeroFilhos && (isNaN(numeroFilhos) || parseInt(numeroFilhos) < 0)) {
      errors.push('Número de filhos deve ser um número válido maior ou igual a 0.');
    }

    // Validar CEPs se preenchidos
    const cepPessoal = form.elements['cep_pessoal']?.value.trim() || '';
    if (cepPessoal && !isValidCEP(cepPessoal)) {
      errors.push('CEP pessoal inválido. Use o formato XXXXX-XXX ou XXXXXXXX.');
    }

    const cepFuncional = form.elements['cep_funcional']?.value.trim() || '';
    if (cepFuncional && !isValidCEP(cepFuncional)) {
      errors.push('CEP funcional inválido. Use o formato XXXXX-XXX ou XXXXXXXX.');
    }

    // Se há erros, exibe e retorna
    console.log('Total de erros:', errors.length);
    if (errors.length > 0) {
      console.log('Erros encontrados:', errors);
      createAlert(errors);
      return;
    }
    
    console.log('Nenhum erro encontrado, submetendo formulário...');

    // Esconde modal de erro se estiver aberto
    const errorModalEl = document.getElementById('errorModal');
    if (errorModalEl) {
      try {
        const inst = bootstrap.Modal.getInstance(errorModalEl) || new bootstrap.Modal(errorModalEl);
        inst.hide();
      } catch (e) {
        // ignore
      }
    }

    // Submit normal
    form.submit();
  });
});
