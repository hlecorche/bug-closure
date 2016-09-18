<?php

namespace AppBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class Contact
{
    private $firstName;

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload)
    {
        //It's OK !

        $fakeNames = array('fake-name');

        if (in_array($this->getFirstName(), $fakeNames)) {
            $context->buildViolation('This name sounds totally fake!')
                ->atPath('firstName')
                ->addViolation();
        }
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        //Exception is thrown !!!!

        /*
         * Uncaught PHP Exception Exception: "Serialization of 'Closure' is not allowed" at
         * /path/vendor/doctrine/cache/lib/Doctrine/Common/Cache/ApcCache.php line 57 {"exception":"[object]
         * (Exception(code: 0): Serialization of 'Closure' is not allowed
         */

        $callback = function ($object, ExecutionContextInterface $context, $payload) {
            // ...
        };

        $metadata->addConstraint(new Assert\Callback($callback));
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     * @return Contact
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }
}