<?php

App::uses("StandardController", "Controller");

class AccessConfirmersController extends StandardController {
  // Class name, used by Cake
  public $name = "AccessConfirmers";

  public $uses = array(
                   'AccessConfirmer.AccessConfirmer',
                   'CoEnrollmentFlow',
                   'CoInvite'
                 );

  function beforeFilter() {
    // Since we're overriding, we need to call the parent to run the authz check
    parent::beforeFilter();
    
    // Allow invite handling to process without a login page
    $this->Auth->allow('reply');
  }

  function isAuthorized() {
    $roles = $this->Role->calculateCMRoles();
    
    // Construct the permission set for this user, which will also be passed to the view.
    $p = array();
    
    // Determine what operations this user can perform
    
    // Reply to an invitation?
    $p['reply'] = true;
    
    $this->set('permissions', $p);
    return($p[$this->action]);
  }

  function reply($inviteid) {
    $args = array();
    $args['conditions']['CoInvite.invitation'] = $inviteid;
    $args['contain'] = array('CoPetition', 'EmailAddress');
    
    $invite = $this->CoInvite->find('first', $args);

    $this->set('invite', $invite);
    
    $args = array();
    $args['conditions']['CoPerson.id'] = $invite['CoInvite']['co_person_id'];
    $args['contain'] = array('Co', 'PrimaryName');
    
    $invitee = $this->CoInvite->CoPerson->find('first', $args);
    
    $this->set('invitee', $invitee);

    // Do not display the LOGIN button.
    $this->set('noLoginLogout', true);
    
    if(!empty($invite['CoPetition']['co_enrollment_flow_id'])) {
      $args = array();
      $args['conditions']['CoEnrollmentFlow.id'] = $invite['CoPetition']['co_enrollment_flow_id'];
      $args['contain'][] = 'CoEnrollmentAttribute';
      
      $enrollmentFlow = $this->CoEnrollmentFlow->find('first', $args);
      
      $this->set('co_enrollment_flow', $enrollmentFlow);
    }
  }
}
