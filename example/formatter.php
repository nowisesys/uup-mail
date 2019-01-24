<?php

/*
 * Copyright (C) 2014 Anders Lövgren (Nowise Systems/BMC-IT, Uppsala University).
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

use UUP\Mail\Compose\MessageComposer,
    UUP\Mail\Compose\MessageFormatter,
    UUP\Mail\Compose\MessageTemplate;

class ConfirmAccountRequest extends MessageComposer
{

        public function __construct()
        {
                parent::__construct("Confirm Account", "Your account has been created. Reply to this message in order to confirm the account request.");
                parent::addSection("Information");
                parent::addContent("Some text 1");
                parent::addContent("Some text 2");
                parent::addSection("Reject Account Request");
                parent::addContent("If you have not requested this account, then just ignore this message.");
        }

}

// 
// Using the template loading class:
// 
$formatter = new MessageFormatter(
    new MessageTemplate('../config/html.tpl'), new MessageTemplate('../config/text.tpl')
);
$message = new ConfirmAccountRequest();

printf("Text:\n'%s'\n\n", $formatter->getTextBody($message));
printf("HTML:\n'%s'\n\n", $formatter->getHtmlBody($message));

