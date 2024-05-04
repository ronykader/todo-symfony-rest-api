<?php

namespace App\Service\Task;

use App\Service\ValidationMessage;
use Symfony\Component\Validator\Validator\ValidatorInterface;
readonly class TaskValidatorService
{
    public function __construct(
        private ValidatorInterface $validator,
        private ValidationMessage  $validationMessage,
    )
    {
    }

    /**
     * @param $data
     * @return true[]
     */
    public function validatorsTaskData($data): array
    {

        $errors = $this->validator->validate($data);
        if (count($errors)) {
            return $this->validationMessage->messages($errors);
        }
        return [
            'status' => true,
        ];
    }
}
