// $Id: nodequeue_dragdrop.js,v 1.3.2.1 2010/12/11 20:13:12 ezrag Exp $

Drupal.behaviors.nodequeueDrag = function(context) {
  var tableDrag = Drupal.tableDrag['nodequeue-dragdrop'];

  tableDrag.onDrop = function() {
    $('td.position').each(function(i){
      $(this).html(i + 1);
    });
    
    nodequeueUpdateNodePositions();
  }
}

Drupal.behaviors.nodequeueReverse = function(context) {
  $('#edit-reverse').click(function(){
    // reverse table rows...
    $('tr.draggable').each(function(i){
      $('.nodequeue-dragdrop tbody').prepend(this);
    });

    nodequeueUpdateNodePositions();

    nodequeueInsertChangedWarning();
    nodequeueRestripeTable();

    return false;
  });
};

Drupal.behaviors.nodequeueShuffle = function(context) {
  $('#edit-shuffle').click(function(){
    // randomize table rows...
    var rows = $('table.nodequeue-dragdrop tbody tr:not(:hidden)').get();
    rows.sort(function(){return (Math.round(Math.random())-0.5);});
    $.each(rows, function(i, row) {
      $('.nodequeue-dragdrop tbody').prepend(this);
    });

    nodequeueUpdateNodePositions();

    nodequeueInsertChangedWarning();
    nodequeueRestripeTable();

    return false;
  });
};

Drupal.behaviors.nodequeueClear = function(context) {
  $('#edit-clear').click(function(){
    // mark nodes for removal
    $('.node-position').each(function(i){
      $(this).val('r');
    });

    // remove table rows...
    rows = $('table.nodequeue-dragdrop tbody tr:not(:hidden)').hide();

    nodequeuePrependEmptyMessage();
    nodequeueInsertChangedWarning();

    return false;
  });
};

Drupal.behaviors.nodequeueRemoveNode = function(context) {
  $('a.nodequeue-remove').css('display', 'block');
  $('a.nodequeue-remove').click(function() {
    a = $(this).attr('id');
    a = '#' + a.replace('nodequeue-remove-', 'edit-') + '-position';
    $(a).val('r');

    // hide the current row
    $(this).parent().parent().fadeOut('fast', function(){
      if ($('table.nodequeue-dragdrop tbody tr:not(:hidden)').size() == 0) {
        nodequeuePrependEmptyMessage();
      }
      else {
        nodequeueRestripeTable()
        nodequeueInsertChangedWarning();
      }
    });

    return false;
  });
}

Drupal.behaviors.nodequeueClearTitle = function(context) {
  $('#edit-add-nid').focus(function(){
    if (this.value == this.defaultValue) {
			this.value = '';
      $(this).css('color', '#000');
		}
  }).blur(function(){
    if (!this.value.length) {
      $(this).css('color', '#999');
			this.value = this.defaultValue;
		}
  });
}

/**
 * Updates node positions after nodequeue has been rearranged. It cares about the
 * reverse order and populates nodes the other way round.
 * @return
 */
function nodequeueUpdateNodePositions() {
   
  var reverse = Drupal.settings.nodequeue.reverse; //check if reverse option is set
  
  var size = reverse ? $('.node-position').size() : 1;
  $('.node-position').each(function(i){
    var val = $(this).val();
    $(this).val(size);
    reverse ? size-- : size++;
  });	
	
}

/**
 * Restripe the nodequeue table after removing an element or changing the
 * order of the elements.
 */
function nodequeueRestripeTable() {
  $('table.nodequeue-dragdrop tbody tr:not(:hidden)')
  .filter(':odd')
    .removeClass('odd').addClass('even')
      .end()
  .filter(':even')
    .removeClass('even').addClass('odd')
      .end();

  $('tr:visible td.position').each(function(i){
    $(this).html(i + 1);
  });
}

/**
 * Add a row to the nodequeue table explaining that the queue is empty.
 */
function nodequeuePrependEmptyMessage() {
  $('.nodequeue-dragdrop tbody').prepend('<tr class="odd"><td colspan="6">'+Drupal.t('No nodes in this queue.')+'</td></tr>');
}

/**
 * Display a warning reminding the user to save the nodequeue.
 */
function nodequeueInsertChangedWarning() {
  if (Drupal.tableDrag['nodequeue-dragdrop'].changed == false) {
    $(Drupal.theme('tableDragChangedWarning')).insertAfter('.nodequeue-dragdrop').hide().fadeIn('slow');
    Drupal.tableDrag['nodequeue-dragdrop'].changed = true;
  }
}
