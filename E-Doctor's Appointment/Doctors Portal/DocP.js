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

// Approve / Decline actions (UI only)
document.querySelectorAll('.request').forEach(req => {
  const approve = req.querySelector('.approve');
  const decline = req.querySelector('.decline');
  approve.addEventListener('click', () => {
    req.style.opacity = .6;
    req.querySelector('.muted').textContent = 'Approved';
  });
  decline.addEventListener('click', () => {
    req.style.opacity = .6;
    req.querySelector('.muted').textContent = 'Declined';
  });
});
