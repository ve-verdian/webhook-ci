<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Message Log Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f8f9fa; }
    .table td, .table th { vertical-align: middle; }
    .incoming { background-color: #dbeafe; }
    .outgoing { background-color: #dcfce7; }
    .status-sent { color: blue; }
    .status-delivered { color: green; font-weight: bold; }
    .status-read { color: purple; font-weight: bold; }
    .status-failed { color: red; font-weight: bold; }
    .status-queued { color: orange; }
    .scroll-container {
      max-height: 500px;
      overflow-y: auto;
      border: 1px solid #dee2e6;
      background: white;
    }
    #searchInput {
      width: 250px;
      padding: 6px 10px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
  </style>
</head>
<body>
<div class="container mt-4">

  <!-- Judul & Jam -->
  <div class="mb-3 text-center">
    <h3 class="mb-1">📊 WhatsApp Message Log (Webhook Monitor)</h3>
    <div class="text-muted small" id="clock"></div>
  </div>

  <!-- Toolbar: Pencarian & Rows per halaman -->
  <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
    <div>
      <label for="searchInput" class="me-2 fw-semibold">🔍 Cari Nomor Telepon:</label>
      <input type="text" id="searchInput" placeholder="Masukkan nomor..." class="form-control d-inline-block" style="width:250px;">
    </div>
  </div>
  <!-- Scrollable Table -->
  <div class="scroll-container">
    <table class="table table-bordered table-striped align-middle text-center mb-0">
      <thead class="table-dark sticky-top">
        <tr>
          <th>ID</th>
          <th>Sender</th>
          <th>Message</th>
          <th>Type</th>
          <th>Status</th>
          <th>Created</th>
        </tr>
      </thead>
      <tbody id="messageTable">
        <?php foreach ($messages as $msg): ?>
        <tr class="<?= $msg['message_type'] == 'outgoing' ? 'outgoing' : 'incoming' ?>">
          <td><?= esc($msg['id']) ?></td>
          <td><?= esc($msg['sender']) ?></td>
          <td class="text-start"><?= nl2br(esc($msg['message'])) ?></td>
          <td><?= esc($msg['message_type']) ?></td>
          <td class="status-<?= esc($msg['status']) ?>"><?= esc($msg['status']) ?></td>
          <td><?= esc($msg['created_at']) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

<div class="mt-2 mt-sm-0">
      <label for="rowsPerPage" class="me-2 fw-semibold">Tampilkan:</label>
      <select id="rowsPerPage" class="form-select d-inline-block" style="width:90px;">
        <option value="10" selected>10</option>
        <option value="20">20</option>
        <option value="50">50</option>
      </select>
      <span class="ms-1">baris / halaman</span>
    </div>
  </div>

  <!-- Pagination -->
  <div class="d-flex justify-content-center mt-3">
    <button id="prevPage" class="btn btn-secondary btn-sm me-2">← Sebelumnya</button>
    <span id="pageInfo" class="align-self-center small text-muted"></span>
    <button id="nextPage" class="btn btn-secondary btn-sm ms-2">Selanjutnya →</button>
  </div>

  <div class="text-center mt-3 text-muted">
    Auto-refresh setiap 5 detik ⟳
  </div>
</div>

<script>
// === JAM REALTIME ===
function updateClock() {
  const now = new Date();
  const options = { 
    weekday: 'long', year: 'numeric', month: 'long',
    day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit'
  };
  document.getElementById('clock').textContent =
    now.toLocaleString('id-ID', options) + ' WIB';
}
setInterval(updateClock, 1000);
updateClock();

// === Variabel global ===
let currentPage = 1;
let rowsPerPage = parseInt(document.getElementById('rowsPerPage').value);

// === Fungsi filter & pagination ===
function applyFilterAndPaginate() {
  const filter = document.getElementById('searchInput').value.toLowerCase();
  const rows = Array.from(document.querySelectorAll('#messageTable tr'));
  const filtered = rows.filter(r =>
    r.children[1]?.textContent.toLowerCase().includes(filter)
  );
  const totalPages = Math.ceil(filtered.length / rowsPerPage);
  if (currentPage > totalPages) currentPage = totalPages || 1;

  rows.forEach(r => r.style.display = 'none');
  const start = (currentPage - 1) * rowsPerPage;
  const end = start + rowsPerPage;
  filtered.slice(start, end).forEach(r => r.style.display = '');

  document.getElementById('pageInfo').textContent =
    `Halaman ${currentPage} dari ${totalPages || 1}`;
  document.getElementById('prevPage').disabled = currentPage <= 1;
  document.getElementById('nextPage').disabled = currentPage >= totalPages;
}

// === Event handlers ===
document.getElementById('searchInput').addEventListener('keyup', () => {
  currentPage = 1;
  applyFilterAndPaginate();
});
document.getElementById('rowsPerPage').addEventListener('change', e => {
  rowsPerPage = parseInt(e.target.value);
  currentPage = 1;
  applyFilterAndPaginate();
});
document.getElementById('prevPage').addEventListener('click', () => {
  currentPage--;
  applyFilterAndPaginate();
});
document.getElementById('nextPage').addEventListener('click', () => {
  currentPage++;
  applyFilterAndPaginate();
});

// === Auto-refresh data ===
setInterval(() => {
  fetch('<?= base_url('messages') ?>')
    .then(response => response.text())
    .then(html => {
      const parser = new DOMParser();
      const doc = parser.parseFromString(html, 'text/html');
      const newRows = doc.querySelector('#messageTable').innerHTML;
      document.querySelector('#messageTable').innerHTML = newRows;
      applyFilterAndPaginate();
    })
    .catch(err => console.error('Error fetching messages:', err));
}, 5000);

// === Inisialisasi awal ===
applyFilterAndPaginate();
</script>
</body>
</html>
