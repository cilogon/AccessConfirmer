<?php

class AccessConfirmer extends AppModel {
  // Required by COmanage Plugins
  public $cmPluginType = "confirmer";
  
  // Document foreign keys
  public $cmPluginHasMany = array();
  
  public function cmPluginMenus() {
    return array();
  }
  
  public function willHandle($coId, $coInvite, $coPetition) {
    // Handle any confirmations for the Users CO with CO ID 2.

    if($coId == 2) {
      return true;
    } else {
      return false;
    }
  }
}
