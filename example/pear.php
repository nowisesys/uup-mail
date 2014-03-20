<?php

/*
 * Copyright (C) 2014 Anders Lövgren (QNET/BMC CompDept).
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

require_once '../vendor/autoload.php';
require_once '../config/smtp.inc';

use UUP\Mail\Compose\MessageComposer,
    UUP\Mail\Compose\MessageFormatter,
    UUP\Mail\Compose\MessageTemplate,
    UUP\Mail\Pear\PearMessage,
    UUP\Mail\Pear\PearMailer;

// 
// Test driver for the PEAR Mail implementation.
// 

class ConfirmAccountRequest extends MessageComposer
{

        public function __construct()
        {
                parent::__construct("Confirm Account", "Your account has been created. Reply to this message in order to confirm the account request.");
                parent::addSection("Information");
                parent::addContent("Some text 1.");
                parent::addContent("Some text 2, see http://www.google.se also.");
                parent::addSection("Reject Account Request");
                parent::addContent("If you have not requested this account, then just ignore this message.");
        }

}

$formatter = new MessageFormatter(
    new MessageTemplate('../config/html.tpl'), new MessageTemplate('../config/text.tpl')
);

$message = new PearMessage(new ConfirmAccountRequest(), $formatter);
$message->setSubject('UUP Mail test (Pear)');
$message->setFrom($config['mail']['from']);
$message->addTo($config['mail']['to']);
$message->attachFile(__FILE__);

$mailer = new PearMailer('smtp', $config['smtp']);
$mailer->send($message);
