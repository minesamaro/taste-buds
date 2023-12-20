<?php
require_once(__DIR__ . '/../database/message.class.php');

function messageForm($selectedPersonId) { ?>

 <!-- Form to write and send a message to the selected person -->
 <form id="message-write_message" action="../actions/actionSendMessage.php" method="post">

<input type="hidden" name="receiver_id" value="<?php echo $selectedPersonId; ?>">
<label for="message_content">Write a message:</label>
<textarea name="message_content" id="message-write_textarea" rows="3" required></textarea>
<br>
<button type="submit">Send</button>

</form> 

<?php } ?>