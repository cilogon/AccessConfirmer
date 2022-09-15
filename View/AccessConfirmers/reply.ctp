<?php
  $params = array('title' => 'Confirm Your ACCESS Email Delivery Address');
  print $this->element("pageTitle", $params);
?>
<script type="text/javascript">

var baseURL = "<?php print Router::url(array('plugin' => null, 'controller' => 'co_invites'), true); ?>/";
var invitation = "<?php print $invite['CoInvite']['invitation'] ?>";

function confirm() {
  var url = baseURL + "confirm/" + invitation;
  window.location.replace(url);
}

function decline() {
  window.location.replace("https://identity.access-ci.org/declined-email-verification");
}

function js_local_onload() {
}

</script>

<div class="invitation">
  <span class="invitation-text">
    <?php print filter_var(generateCn($invitee['PrimaryName']),FILTER_SANITIZE_SPECIAL_CHARS); ?>, is
    <?php print $invite['CoInvite']['mail']; ?> the email you registered?
  </span>
<div>

<div id="div_access_confirmer_yes_no">
  <button id="access_confirmer_button_yes" class="btn btn-primary" type="button" onclick="confirm()">Yes</button>
  <div id="div_confirmer_between_buttons"></div>
  <button id="access_confirmer_button_no" class="btn btn-primary" type="button" onclick="decline()">No</button>
</div>
