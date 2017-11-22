<?php

namespace shop\services;

use shop\forms\ContactForm;
use Yii;

class ContactService
{
    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */
    public function send(ContactForm $form): void
    {

        $mail_body = 'Заявка от ' . $form->name .'(' . $form->email .') \n\n
            Тема письма: ' . $form->subject . '\n\n
            Текст письма: ' . $form->body . '\n\n\n\n
            Дата отправки: ' . date('Y-m-d H:i');


        $sent = Yii::$app->mailer->compose()
            ->setTo(Yii::$app->params['adminEmail'])
            //->setFrom([$this->email => $this->name])
            ->setSubject($form->subject)
            ->setTextBody($mail_body)
            ->send();

        if (!$sent) {
            throw new \RuntimeException('Sending error.');
        }

    }

}