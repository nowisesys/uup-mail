## UUP-MAIL - Mail template and composing library for PHP

The uup-mail library provides a mail template and composer library for formatting
mail messages. Its main focus is on MIME message composition and layout using templates. 
The actual sending (transport) of the SMTP message is delegated to other libraries,
currently Swift Mailer, PEAR Mail or PHPMailer is supported.

### Design

This library was designed with inheritance in mind. Create your own mail message 
classes (one for each particular kind of message) derived from class MessageComposer:

```php
class ConfirmSubscriptionMessage extends MessageComposer
{
    public function __construct()
    {
        parent::__construct(_("Confirm Subscription", _("...")));
        // ... create additional section headers with content.
    }

    public function setSubscription($id) 
    {
        parent::setContent('Subscription', Subscription::get($id));
    }
}

$composer = new ConfirmSubscriptionMessage();
$message  = new SwiftMessage($composer, $formatter);
$mailer->send($message);
```

### Usage

The library can be used at three different levels:

1. Use UUP\Mail\Compose only. The library is used solely for message composition.

2. Use i.e. UUP\Mail\Swift. This is the intermediate level were you can take 
   advantage of the message composition and layout, while still have native 
   access to the Swift Mailer library too.

3. Use UUP\Mail and its interface. The programming at this level is done against
   the interfaces (Message and MessageMailer) using the MessageService as a proxy
   against your code and the native implementation, i.e. Swift Mailer.

A good example of real world usage can be found in example/realistic.php

### More

More information can be found on the [project page](https://nowise.se/oss/uup-mail)
