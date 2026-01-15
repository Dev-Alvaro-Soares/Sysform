document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('solicitacaoForm');
  if (!form) return;

  function createAlert(messages) {
    // Prefer showing messages in the Bootstrap error modal if present
    const modalEl = document.getElementById('errorModal');
    if (modalEl) {
      const body = document.getElementById('errorModalBody');
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
      }
      const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
      modal.show();
      return;
    }

    // Fallback: inline alert (kept for compatibility)
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

  function isValidTimeHM(value) {
    if (!value) return false; // required now
    const m = value.match(/^([0-1][0-9]|2[0-3]):([0-5][0-9])$/);
    return !!m;
  }

  function normalizeDateDMY(value) {
    // remove non-digits
    const digits = (value || '').toString().replace(/\D/g, '');
    if (digits.length === 8) {
      const d = digits.slice(0, 2);
      const mo = digits.slice(2, 4);
      const y = digits.slice(4, 8);
      return `${d}.${mo}.${y}`;
    }
    if (digits.length === 6) {
      // ddmmyy -> expand year to 20yy
      const d = digits.slice(0, 2);
      const mo = digits.slice(2, 4);
      const yy = digits.slice(4, 6);
      const y = `20${yy}`;
      return `${d}.${mo}.${y}`;
    }
    // if already in format dd.mm.yyyy validate
    const m = (value || '').match(/^(\d{2})\.(\d{2})\.(\d{4})$/);
    if (m) return value;
    return null; // cannot normalize
  }

  function isValidDateDMY(value) {
    if (!value) return false; // required now
    const m = value.match(/^(\d{2})\.(\d{2})\.(\d{4})$/);
    if (!m) return false;
    const d = parseInt(m[1], 10), mo = parseInt(m[2], 10), y = parseInt(m[3], 10);
    if (mo < 1 || mo > 12) return false;
    const days = new Date(y, mo, 0).getDate();
    return d >= 1 && d <= days;
  }

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    const errors = [];

    const nome = form.elements['nome']?.value.trim() || '';
    const matricula = form.elements['matricula']?.value.trim() || '';
    const data_missao = form.elements['data_missao']?.value.trim() || '';
    const modelo = form.elements['modelo']?.value || '';
    const qiRaw = form.elements['quilometragem_inicial']?.value;
    const qfRaw = form.elements['quilometragem_final']?.value;
    let retirada = form.elements['retirada']?.value.trim() || '';
    let devolucao = form.elements['devolucao']?.value.trim() || '';

    // required checks
    if (nome.length < 12) errors.push('Nome deve ter ao menos 12 caracteres.');
    if (!matricula) errors.push('Matrícula é obrigatória.');
    else if (!/^\d+$/.test(matricula)) errors.push('Matrícula deve conter apenas dígitos.');

    if (!data_missao) errors.push('Data da missão é obrigatória.');
    if (!modelo) errors.push('Escolha um modelo de veículo.');

    const qi = qiRaw === undefined || qiRaw === '' ? NaN : Number(qiRaw);
    const qf = qfRaw === undefined || qfRaw === '' ? NaN : Number(qfRaw);
    if (qiRaw === undefined || qiRaw === '') errors.push('Quilometragem inicial é obrigatória.');
    else if (!Number.isInteger(qi) || qi < 0) errors.push('Quilometragem inicial inválida (inteiro ≥ 0).');
    if (qfRaw === undefined || qfRaw === '') errors.push('Quilometragem final é obrigatória.');
    else if (!Number.isInteger(qf) || qf < 0) errors.push('Quilometragem final inválida (inteiro ≥ 0).');
    if (!isNaN(qi) && !isNaN(qf) && qf < qi) errors.push('Quilometragem final não pode ser menor que a inicial.');

    // Normalize date_missao if possible
    const normalizedDate = normalizeDateDMY(data_missao);
    if (normalizedDate) {
      form.elements['data_missao'].value = normalizedDate;
    }
    if (!isValidDateDMY(form.elements['data_missao'].value)) errors.push('Data da missão inválida. Use o formato dd.mm.aaaa. (dia.mês.ano)');

    // Normalize times: accept digits and convert
    function normalizeTimeHM(val) {
      const digits = (val || '').toString().replace(/\D/g, '');
      // Reject immediately if more than 4 digits
      if (digits.length > 4) return null;

      let hh = '';
      let mm = '';

      if (digits.length === 4) {
        hh = digits.slice(0, 2);
        mm = digits.slice(2, 4);
      } else if (digits.length === 3) {
        // HMM -> 0H:MM
        hh = digits.slice(0, 1).padStart(2, '0');
        mm = digits.slice(1, 3);
      } else if (digits.length === 2) {
        // HH -> HH:00
        hh = digits.padStart(2, '0');
        mm = '00';
      } else if (digits.length === 1) {
        // H -> 0H:00
        hh = digits.padStart(2, '0');
        mm = '00';
      } else {
        // no digits — maybe already formatted as HH:MM
        const m = (val || '').match(/^([0-1]?\d|2[0-3]):([0-5]\d)$/);
        if (m) return m[1].padStart(2, '0') + ':' + m[2].padStart(2, '0');
        return null;
      }

      const hhNum = parseInt(hh, 10);
      const mmNum = parseInt(mm, 10);
      if (Number.isNaN(hhNum) || Number.isNaN(mmNum)) return null;
      if (hhNum < 0 || hhNum > 23 || mmNum < 0 || mmNum > 59) return null;
      return `${hh.padStart(2, '0')}:${mm.padStart(2, '0')}`;
    }

    const normRet = normalizeTimeHM(retirada);
    const normDev = normalizeTimeHM(devolucao);
    if (normRet) form.elements['retirada'].value = normRet;
    if (normDev) form.elements['devolucao'].value = normDev;

    retirada = form.elements['retirada']?.value.trim() || '';
    devolucao = form.elements['devolucao']?.value.trim() || '';

    if (!isValidTimeHM(retirada)) errors.push('Horário de retirada inválido. Use até 4 dígitos no formato HH:MM (HH - Hora com valores entre 00-23, MM - Minutos com valores entre 00-59).');
    if (!isValidTimeHM(devolucao)) errors.push('Horário de devolução inválido. Use até 4 dígitos no formato HH:MM (HH - Hora com valores entre 00-23, MM - Minutos com valores entre 00-59).');

    if (errors.length > 0) {
      createAlert(errors);
      return;
    }


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

    // submit normal
    form.submit();
  });
});
