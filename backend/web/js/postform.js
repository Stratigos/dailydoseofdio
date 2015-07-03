/*****************************************************************************
* Behavior and functionality associated with creating or updating a new Post
******************************************************************************/

// doc ready is used here for now as its the only doc ready call for the
//  backend app at this time. 
$(document).ready(function() {
  /**
   * Click a Tag button, and have it appear in the SelectizeTextInput widget
   *  as though it were typed in.
   * @todo Solution is brittle, and depends on SelectizeTextInput's HTML
   *  structure. It may more graceful, over time, to simply have a
   *  'view all' button that, on click, reveals all available Tags, and
   *  just have the user type the Tag names into the input field as is.
   * @see dosamigos\selectize\SelectizeTextInput
   */
  $('.post-form-tag-list-item').click(function(e) {
    // Stop button from submitting form.
    e.preventDefault();
    // Get Tag name, then check to see if Tag has already been added.
    var text   = $(this).text();
    var exists = $('div.selectize-input').find("[data-value='" + text + "']");
    if(!exists.length) {
      // Add new Tag to hidden input for selected PostTags.
      $('div.field-post-tags-selected>input#post-tags-selected').val(
        $('div.field-post-tags-selected>input#post-tags-selected').val() + ',' + text
      );
      // Add visual button in Select
      $('div.selectize-input').append(
        '<div class="item" data-value="' + text +'">'
        + text + 
        '<a class="remove" title="Remove" tabindex="-1" href="javascript:void(0)">×</a></div>'
      );
    }
  });
});