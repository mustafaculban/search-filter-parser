<?php
namespace DevJoys\Parser;

class SearchFilterParser
{
    protected array $operatorMap = [
        "is" => "=",
        "is_not" => "!=",
        "is_greater_than" => ">",
        "is_greater_than_or_equal" => ">=",
        "is_less_than" => "<",
        "is_less_than_or_equal" => "<=",
        "like" => "LIKE",
        "in" => "IN",
        "between" => "BETWEEN"
    ];

    public function parse(array $filters): string
    {
        if (!isset($filters['operator']) || !isset($filters['conditions'])) {
            return '';
        }

        return $this->parseConditions($filters);
    }

    private function parseConditions(array $filters): string
    {
        $operator = strtoupper($filters['operator']);
        $parts = [];

        foreach ($filters['conditions'] as $condition) {
            if (isset($condition['field'])) {
                $parts[] = $this->buildExpression($condition);
            } elseif (isset($condition['operator'], $condition['conditions'])) {
                $nested = $this->parseConditions($condition);
                if ($nested) {
                    $parts[] = "($nested)";
                }
            }
        }

        return implode(" $operator ", $parts);
    }

    private function buildExpression(array $condition): string
    {
        $field = $condition['field'];
        $operatorKey = $condition['operator'];
        $value = $condition['value'];

        $sqlOperator = $this->operatorMap[$operatorKey] ?? '=';

        switch ($sqlOperator) {
            case 'IN':
                $escaped = '(' . implode(',', array_map([$this, 'escapeValue'], $value)) . ')';
                break;

            case 'BETWEEN':
                $escaped = $this->escapeValue($value[0]) . ' AND ' . $this->escapeValue($value[1]);
                break;

            default:
                $escaped = $this->escapeValue($value);
        }

        return "$field $sqlOperator $escaped";
    }

    private function escapeValue(mixed $value): string
    {
        if (is_numeric($value)) {
            return (string) $value;
        }

        return "'" . addslashes((string) $value) . "'";
    }
}