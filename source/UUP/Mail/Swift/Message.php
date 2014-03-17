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

namespace UUP\Mail\Swift;

use UUP\Mail\Compose\MessageComposer,
    UUP\Mail\Compose\MessageFormatter;

/**
 * Create a Swift Mailer Message.
 * 
 * The body (HTML and plain text) in the parent class is initialized from the
 * composer and formatter object passed to the constructor.
 *
 * @author Anders Lövgren (QNET/BMC CompDept)
 * @package UUP
 * @subpackage Mail
 */
class Message extends \Swift_Message
{

        /**
         * Constructor.
         * @param MessageComposer $composer
         * @param MessageFormatter $formatter
         */
        public function __construct($composer, $formatter)
        {
                $this->setBody($formatter->getHtmlBody($composer), 'text/html', 'UTF-8');
                $this->addPart($formatter->getTextBody($composer), 'text/plain', 'UTF-8');
        }

}
