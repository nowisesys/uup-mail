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

namespace UUP\Mail;

use UUP\Mail\Compose\MessageComposer;

/**
 * The message mailer interface.
 * 
 * @author Anders Lövgren (Nowise Systems/BMC-IT, Uppsala University)
 * @package UUP
 * @subpackage Mail
 */
interface MessageMailer
{

        /**
         * Create a native message.
         * 
         * @param MessageComposer $composer The composed mail message.
         * @param MessageFormatter $formatter The message formatter.
         * @return Message 
         */
        function create($composer, $formatter);

        /**
         * Send the mail message using the configured mail transport.
         * @param Message $message The mail message.
         */
        function send($message);
}
