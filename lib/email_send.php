<?php
function email_send(array $message)
{
    $mandrill = new Mandrill(MANDRILL_KEY);
    $result = $mandrill->messages->send($message);
}
