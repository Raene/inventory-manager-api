<?php
    use Minishlink\WebPush\WebPush;

    function send_push_notification($subscription,$payload)
    {
        $auth = array(
            'VAPID' => array(
                'subject' => 'mailto:bob.salau@gmail.com',
                'publicKey' =>'BCxISN_UqEAhjud-1BMwiLPpluwxiH0O_e8jId13Nb78q6iWPa_Ml_7qbPf8zhy3lwP5tc4AYcQu
                mZvuR0uB-xE
                ', // don't forget that your public key also lives in app.js
                'privateKey' =>'EaRX9y3inyOVpWDDUlPxzVJgVLkJvWU8BErCJLPXsLw',
            ),
        );

        $webPush = new WebPush($auth);
        $webPush->sendNotification(
            $subscription,
            $payload
        );

        var_dump($webPush);

        foreach ($webPush->flush() as $report) {
            $endpoint = $report->getRequest()->getUri()->__toString();
        
            if ($report->isSuccess()) {
                return "[v] Message sent successfully for subscription {$endpoint}.";
            } else {
                return "[x] Message failed to sent for subscription {$endpoint}: {$report->getReason()}";
            }
        }
    }