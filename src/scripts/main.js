jQuery(document).ready(function() {
  /**
   * Limit characters in a comment
   *
   */
  function limitCharacters(evt) {
    var charLen = evt.target.value.length;

    if (charLen < charWarning) { return; }

    var charLimit = +window.commentMaxChar.max || 1500;
    var charWarning = +window.commentMaxChar.warn || charLimit - 50;
    var charsLeft = Math.max(charLimit - charLen, 0);
    var charsLeftStr = charsLeft + (charsLeft === 1 ? ' character' : ' characters');
    var validChars = evt.target.value.substr(0, charLimit);

    if (charLen > charWarning) {
      evt.target.classList.add('warning');
      if (! jQuery('#commentWarning').length) {
        jQuery('.comment-form-comment').append('<span id="commentWarning" class="comment-warning">You have <span>' + charsLeftStr + '</span> left</p>')
      } else {
        jQuery('#commentWarning span').text(charsLeftStr);
      }
    } else {
      evt.target.classList.remove('warning');
      jQuery('#commentWarning').remove();
    }

    if (charLen > charLimit) {
      evt.target.value = evt.target.value = validChars
    } 
  }

  jQuery('#comment').on('input', limitCharacters);
});
