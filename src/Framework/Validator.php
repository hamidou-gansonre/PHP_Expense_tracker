<?php

declare(strict_types=1);

namespace Framework;

use Framework\Contracts\RuleInterface;
use Framework\Exceptions\ValidationException;

class Validator
{
    private array $rules = [];

    public function add(string $alias, RuleInterface $rule)
    {
        $this->rules[$alias] = $rule;
    }

    public function validate(array $formData, array $fields)
    {

        $errors = [];

        foreach ($fields as $fieldName => $rules) {
            foreach ($rules as $rule) {

                /**
                 * @RuleParams verify if its minimum Rule exp: min:18
                 * If the the Rule its minimun 18 , its validate
                 * exemple in the age rule in @ValidatorService
                 */
                $ruleParams = [];

                if (str_contains($rule, ':')) {
                    [$rule, $ruleParams] =  explode(':', $rule);
                    $ruleParams = explode(',', $ruleParams);
                }

                $ruleValidator = $this->rules[$rule];

                if ($ruleValidator->validate($formData, $fieldName, $ruleParams)) {
                    continue;
                }

                $errors[$fieldName][] = $ruleValidator->getMessage(
                    $formData,
                    $fieldName,
                    $ruleParams
                );
            }
        }

        if (count($errors)) {
            throw new ValidationException($errors);
        }
    }
}
