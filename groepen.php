<?php
  $activePage = 'groepen';
  include 'header.php';
?>

<header>
    <h1>Groepen</h1>
</header>

<div id="groepenContainer" class="groepen-grid"></div>

<!-- Modal -->
<div id="groepModal" class="modal">
  <div class="modal-content">
    <span class="close-modal">&times;</span>
    <h2></h2>
    <div class="modal-content-body"></div>
  </div>
</div>

<script src="groepen.js"></script>

<?php include 'footer.php'; ?>