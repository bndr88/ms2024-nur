<?php

namespace PhpPact\Consumer\Matcher\Matchers;

use PhpPact\Consumer\Matcher\Model\Attributes;
use PhpPact\Consumer\Matcher\Model\Expression;
use PhpPact\Consumer\Matcher\Model\Matcher\ExpressionFormattableInterface;
use PhpPact\Consumer\Matcher\Model\Matcher\JsonFormattableInterface;
use PhpPact\Consumer\Matcher\Trait\ExpressionFormattableTrait;
use PhpPact\Consumer\Matcher\Trait\JsonFormattableTrait;

/**
 * This is the default matcher, and relies on the equals operator
 */
class Equality extends GeneratorAwareMatcher implements JsonFormattableInterface, ExpressionFormattableInterface
{
    use JsonFormattableTrait;
    use ExpressionFormattableTrait;

    public function __construct(private mixed $value)
    {
        parent::__construct();
    }

    public function formatJson(): Attributes
    {
        return $this->mergeJson(new Attributes([
            'pact:matcher:type' => 'equality',
            'value' => $this->value,
        ]));
    }

    public function formatExpression(): Expression
    {
        return $this->mergeExpression(new Expression('matching(equalTo, %value%)', ['value' => $this->value]));
    }
}
