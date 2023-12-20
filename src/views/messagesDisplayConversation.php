<?php
require_once(__DIR__ . '/../views/messageForm.php');
require_once(__DIR__ . '/../database/message.class.php');

function displayConversation($peopleWithMessages, $userId, $selectedPersonId, $selectedPerson_FullName, $conversation) { ?>



 <!-- Right side: Display messages for the selected person -->
 <div id="messages-conversation">
        <?php if ($selectedPersonId) { ?>
            <div id="messages-conversation-header">
                <a href="profile.php?user_id=<?php echo $selectedPersonId; ?>"><h3 id="messages-conversation_person_name"> <?php echo $selectedPerson_FullName; ?></h3> </a>
            </div>
       
            <?php if ($conversation) { ?>
                <div class="card" id="messages-conversation_content">
                    <?php 
                    $last_date = 0;
                    $last_message_sender = 0;
                    
                     ?>
                    <?php foreach ($conversation as $message) { ?>
                        <?php
                            $formattedDate = date("d-m-Y", strtotime($message->sending_date));
                            
                            if ($formattedDate != $last_date) {
                                $show_date = true;
                            }
                            else {
                                $show_date = false;
                            }

                            if ($message->sender_id != $last_message_sender) {
                                $show_sender = true;
                            } else {
                                $show_sender = false;
                            }

                            if($userId == $message->sender_id) {
                                $class = 'message-sent';
                            } else {
                                $class = 'message-received';
                            }

                            $formattedHour = date("H:i", strtotime($message->sending_date));
                            $sender = Person::getPersonById($message->sender_id);
                            $sender_FullName = $sender->first_name . " " . $sender->surname;
                        ?>
                        <div>
                        
                            <div class="<?php echo $class;?>">
                            
                            <?php if (($show_sender && $last_message_sender) || $message==$conversation[0]) { ?>
                                <small><?php echo $sender_FullName; ?></small>
                                <?php } $last_message_sender = $message->sender_id;?>
                            <br>
                                <div class="message-content_individual_message">
                                <?php echo $message->content; ?>
                                </div>
                            <br>
                            <small class="message-hours"><?php echo $formattedHour; ?></small>
                            </div>

                            <div id="message-date">
                            <?php if ($show_date && $last_date!=0) { ?>
                                <small><?php echo $last_date; ?></small>
                                <br>
                            <?php } $last_date=$formattedDate; ?>
                            </div>

                            
                        </div>
                        
                    <?php } ?>
                        <div id="message-date">
                            <small><?php echo $last_date; ?></small>
                            <br>             
                        </div>

                    <div style="clear: both;"></div> <!-- Clear the float -->
                </div>
            <?php } else { ?>
                <p>No messages with this person yet. Be the first to send a message.</p>
            <?php }

            messageForm($selectedPersonId); ?>

        <?php } elseif (!empty($peopleWithMessages)) { ?>
            <p>Select a person to display the conversation.</p> <!-- PODEMOS MUDAR ISTO DEPOIS --> 
        <?php } ?>

        </div>

</div>

</main>
</body>

<?php } ?>