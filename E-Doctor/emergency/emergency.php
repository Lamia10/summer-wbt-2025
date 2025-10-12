<?php
// If it's a JSON POST request, handle as API
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_SERVER['CONTENT_TYPE']) &&
    strpos($_SERVER['CONTENT_TYPE'], 'application/json') === 0) {

    header('Content-Type: application/json; charset=utf-8');

    $authority_email = 'authority@example.com';

    $raw = file_get_contents('php://input');
    if (!$raw) {
        http_response_code(400);
        echo json_encode(['success'=>false,'error'=>'No data received']);
        exit;
    }

    $data = json_decode($raw, true);
    if (!$data) {
        http_response_code(400);
        echo json_encode(['success'=>false,'error'=>'Invalid JSON']);
        exit;
    }

    function clean($s) {
        return trim(strip_tags(htmlspecialchars($s, ENT_QUOTES, 'UTF-8')));
    }

    $name = clean($data['name'] ?? '');
    $phone = clean($data['phone'] ?? '');
    $email = clean($data['email'] ?? '');
    $message = clean($data['message'] ?? '');

    if (strlen($name) < 2 || strlen($phone) < 6 || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($message) < 8) {
        http_response_code(400);
        echo json_encode(['success'=>false,'error'=>'Validation failed']);
        exit;
    }

    // log to file
    $logLine = sprintf("[%s] %s | %s | %s\n", date('Y-m-d H:i:s'), $name, $phone, str_replace("\n", ' ', $message));
    file_put_contents(__DIR__ . '/requests.txt', $logLine, FILE_APPEND | LOCK_EX);

    // send email
    $subject = "Emergency Appointment Request from $name";
    $body = "An emergency appointment request has been submitted.\n\n"
          . "Name: $name\nPhone: $phone\nEmail: $email\n\nMessage:\n$message\n\nTime: " . date('Y-m-d H:i:s') . "\n";
    $headers = "From: noreply@".$_SERVER['SERVER_NAME']."\r\n";
    $headers .= "Reply-To: $email\r\n";

    $mailSent = false;
    if (function_exists('mail')) {
        $mailSent = @mail($authority_email, $subject, $body, $headers);
    }

    echo json_encode(['success'=>true, 'mail_sent'=>$mailSent]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>E-Doctor Appointment</title>
  <link rel="stylesheet" href="style.css" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
</head>
<body>
  <nav class="navbar">
    <div class="nav-left">
      <a href="../index.php">Home</a>
      <a href="../about us/aboutus.php">About Us</a>
      <a href="../emergency/emergency.php">Emergency Contact</a>
    </div>
    <div class="nav-right">
      <a href="../Login/login.php">Login</a>
    </div>
  </nav>
  <main class="card">
    <h1>Emergency</h1>

    <div class="quick-actions">
      <a class="action contact" href="tel:+880123456789">Call Emergency</a>
      <a class="action email" href="mailto:help@edoctor.example?subject=Emergency%20Contact">Email Emergency</a>
    </div>

    <form id="emergencyForm" autocomplete="off">
      <label>
        Your Name <span class="req">*</span>
        <input id="name" name="name" type="text" placeholder="Full name" required />
      </label>

      <label>
        Phone <span class="req">*</span>
        <input id="phone" name="phone" type="tel" placeholder="+8801XXXXXXXXX" required />
      </label>

      <label>
        Email <span class="req">*</span>
        <input id="email" name="email" type="email" placeholder="you@example.com" required />
      </label>

      <label>
        Short description of the emergency <span class="req">*</span>
        <textarea id="message" name="message" rows="4" placeholder="What happened? Where? Who needs help?" required></textarea>
      </label>

      <div class="btn-row">
        <button id="requestBtn" class="btn primary" type="button">Request Appointment</button>
        <button type="reset" class="btn neutral">Clear</button>
      </div>

      <p class="note">By clicking Request Appointment you consent that this request will be forwarded to the authority.</p>
    </form>

    <div id="status" class="status" aria-live="polite"></div>
  </main>

  <script>
    const form = document.getElementById('emergencyForm');
    const requestBtn = document.getElementById('requestBtn');
    const statusEl = document.getElementById('status');

    function validateInputs(name, phone, email, message) {
      if (!name || name.trim().length < 2) return "Enter a valid name.";
      const phoneRe = /^[0-9+\-\s]{8,20}$/;
      if (!phoneRe.test(phone)) return "Enter a valid phone number (digits, + or -).";
      const emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
      if (!emailRe.test(email)) return "Enter a valid email address.";
      if (!message || message.trim().length < 8) return "Please describe the emergency (8+ characters).";
      return null;
    }

    requestBtn.addEventListener('click', async () => {
      statusEl.style.color = '';
      statusEl.textContent = 'Processing...';

      const name = document.getElementById('name').value.trim();
      const phone = document.getElementById('phone').value.trim();
      const email = document.getElementById('email').value.trim();
      const message = document.getElementById('message').value.trim();

      const err = validateInputs(name, phone, email, message);
      if (err) {
        statusEl.style.color = 'var(--danger)';
        statusEl.textContent = err;
        return;
      }

      const payload = { name, phone, email, message };

      try {
        const resp = await fetch('emergency.php', {
          method: 'POST',
          headers: { 'Content-Type':'application/json' },
          body: JSON.stringify(payload)
        });

        if (!resp.ok) throw new Error('Server error');

        const data = await resp.json();
        if (data.success) {
          statusEl.style.color = 'green';
          statusEl.textContent = 'Request submitted. Authority notified.';
          form.reset();
        } else {
          statusEl.style.color = 'var(--danger)';
          statusEl.textContent = data.error || 'Failed to submit. Try again.';
        }
      } catch (e) {
        statusEl.style.color = 'var(--danger)';
        statusEl.textContent = 'Network or server error. Try again later.';
        console.error(e);
      }
    });
  </script>
</body>
<footer class="footer">
  <p>© 2025 E-Doctors Appointment | All Rights Reserved</p>
</footer>
</html>
