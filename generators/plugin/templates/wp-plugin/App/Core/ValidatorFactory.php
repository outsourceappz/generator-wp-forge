<?php
namespace <%- props.appName %>\Core;

use Illuminate\Validation\DatabasePresenceVerifier;
use Illuminate\Validation\Validator as EloquentValidator;
use Symfony\Component\Translation\Translator;

/**
 * Validator class for ORM models
 */
class ValidatorFactory
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function make($data, $rules, $customMessages = array())
    {
        $locale     = 'en';
        $translator = new Translator($locale);

        $validator = new EloquentValidator($translator, $data, $rules, $customMessages);

        $path    = $this->container['base'] . '/lang/' . $locale . '/validation.php';
        $message = include $path;

        $validator->setFallbackMessages($message);

        $translator->addLoader('array', new \Symfony\Component\Translation\Loader\ArrayLoader());
        $translator->addResource('array', $message, $locale, 'validation');

        $presence   = new DatabasePresenceVerifier($this->container['db_resolver']);
        $validator->setPresenceVerifier($presence);

        return $validator;
    }

    // /**
    //  * Over riding size messages as translation was failing.
    //  */
    // protected function getSizeMessage($attribute, $rule)
    // {
    //     $lowerRule = snake_case($rule);

    //     // There are three different types of size validations. The attribute may be
    //     // either a number, file, or string so we will check a few things to know
    //     // which type of value it is and return the correct line for that type.
    //     $type = $this->getAttributeType($attribute);

    //     $key = "{$lowerRule}.{$type}";

    //     return $this->translator->trans($key, array(), 'validation');
    // }
}
