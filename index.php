<?php
/*
 * Validate mail from .csv
 */
include('MailValidate.php');
echo new MailValidate('csv',12,'new');