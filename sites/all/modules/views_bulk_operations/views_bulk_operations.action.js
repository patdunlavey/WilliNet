// $Id: views_bulk_operations.action.js,v 1.1.2.6 2010/12/09 03:42:34 kratib Exp $
(function ($) {
// START jQuery

Drupal.vbo = Drupal.vbo || {};
Drupal.vbo.action = Drupal.vbo.action || {};

Drupal.vbo.action.updateOperations = function(vid, trigger) {
  var options = "";
  if (Drupal.settings.vbo.action.views_operations[vid] == undefined || Drupal.settings.vbo.action.views_operations[vid].length == 0) {
    options += "<option value=\"0\">" + Drupal.t("- No operation found in this view -") + "</option>";
  }
  else {
    options += "<option value=\"0\">" + Drupal.t("- Choose an operation -") + "</option>";
    $.each(Drupal.settings.vbo.action.views_operations[vid], function(value, text) {
      options += "<option value=\"" + value + "\">" + text + "</option>\n";
    });
  }
  operation = $("#edit-operation-key").val();
  $("#edit-operation-key").html(options).val(operation);
  if (trigger) {
    $("#edit-operation-key").trigger('change');
  }
}

Drupal.behaviors.vbo_action = function(context) {
  vid = $("#edit-view-vid").val();
  Drupal.vbo.action.updateOperations(vid, false);
}

// END jQuery
})(jQuery);

