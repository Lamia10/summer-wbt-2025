// Sidebar toggle (mobile)
const toggle = document.getElementById('menuToggle');
const sidebar = document.getElementById('sidebar');
toggle.addEventListener('click', () => {
  sidebar.classList.toggle('open');
});

// Appointments quick search
const apptSearch = document.getElementById('apptSearch');
const apptTable = document.getElementById('apptTable');
apptSearch.addEventListener('input', () => {
  const q = apptSearch.value.toLowerCase();
  [...apptTable.rows].forEach(r => {
    const patient = r.cells[1]?.textContent.toLowerCase() || '';
    r.style.display = patient.includes(q) ? '' : 'none';
  });
});

// Toggle availability of slots
document.querySelectorAll('.slot').forEach(btn => {
  btn.addEventListener('click', () => btn.classList.toggle('active'));
});

// Approve / Decline actions (AJAX)
document.querySelectorAll('.request .approve, .request .decline').forEach(btn => {
  btn.addEventListener('click', () => {
    const requestDiv = btn.closest('.request');
    const id = requestDiv.dataset.id;
    const action = btn.classList.contains('approve') ? 'approve' : 'decline';

    fetch('updateAppointment.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `id=${encodeURIComponent(id)}&action=${encodeURIComponent(action)}`
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          requestDiv.querySelector('.muted').textContent = action === 'approve' ? 'Approved' : 'Declined';
          requestDiv.style.opacity = 0.6;
          requestDiv.querySelector('.actions').remove(); // Remove buttons
        } else {
          alert('Failed to update appointment.');
        }
      })
      .catch(err => console.error(err));
  });
});
