<?php

namespace App\Application\Common;

use App\Api\Form\Exception\FormException;
use Symfony\Component\Form\FormInterface;

class FormValidate
{
    public static function validate(FormInterface $form): void
    {
        if ($form->isValid()) {
            return;
        }

        $message = '';
        $errors = $form->getErrors(true);
        foreach ($errors as $error) {
            $origin = $error->getOrigin();
            if (null == $origin) {
                continue;
            }

            $originConfig = $origin?->getConfig();
            $originName = $originConfig?->getOption('label') ?: $origin->getName();
            $message .= ', ' . sprintf('%s: %s', $originName, $error->getMessage());
        }
        throw FormException::jsonRequestContentError($message);
    }
}
