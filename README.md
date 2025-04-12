# 🔍 Search Filter Parser (PHP)

A lightweight and flexible PHP parser that transforms nested filter structures into clean SQL condition strings.  
Perfect for powering dynamic search forms, advanced filters, or building your own microservices.

## Features

- Supports AND/OR nesting
- Handles various operators (`=`, `!=`, `>`, `<`, `IN`, `BETWEEN`, etc.)
- Clean and readable SQL output
- No DB connection required — just parsing
- PSR-4 namespaced under `DevJoys\Parser`
- Includes visual filter builder UI for quick testing 🎨

## Installation

```bash
composer require mustafaculban/search-filter-parser
```

If you're installing locally from source, run:

```bash
composer dump-autoload
```

## Usage

```php
use DevJoys\Parser\SearchFilterParser;

$filters = [
    'operator' => 'or',
    'conditions' => [
        [
            'operator' => 'and',
            'conditions' => [
                ['field' => 'status', 'operator' => 'is', 'value' => 'active'],
                ['field' => 'age', 'operator' => 'is_greater_than', 'value' => 25],
            ]
        ],
        ['field' => 'role', 'operator' => 'is_not', 'value' => 'admin']
    ]
];

$parser = new SearchFilterParser();
$sql = $parser->parse($filters);

echo $sql;
// Output:
// (status = 'active' AND age > 25) OR role != 'admin'
```

## Example JSON Input

```json
{
  "operator": "or",
  "conditions": [
    {
      "operator": "and",
      "conditions": [
        { "field": "status", "operator": "is", "value": "active" },
        { "field": "age", "operator": "is_greater_than", "value": 25 }
      ]
    },
    { "field": "role", "operator": "is_not", "value": "admin" }
  ]
}
```

## Try It with Slim API + Visual UI

This package includes a working Slim API example and a browser-based visual filter builder!

### Start Local API

```bash
php -S localhost:8000 -t vendor/mustafaculban/search-filter-parser/api
```

### Open the Visual Builder

Open in your browser:

```
http://localhost:8000/visual-filter-builder.html
```

✅ Supports multiple groups  
✅ Choose AND/OR logic  
✅ Click "Get Generated SQL" to preview backend response live

## Supported Operators

| Operator Key               | SQL Equivalent |
|----------------------------|----------------|
| `is`                       | `=`            |
| `is_not`                   | `!=`           |
| `is_greater_than`          | `>`            |
| `is_greater_than_or_equal` | `>=`           |
| `is_less_than`             | `<`            |
| `is_less_than_or_equal`    | `<=`           |
| `like`                     | `LIKE`         |
| `in`                       | `IN`           |
| `between`                  | `BETWEEN`      |

## About

This package is part of the **DevJoys** tool series — developer-focused tools built with simplicity and reusability in mind.  
Stay tuned for follow-ups: API enhancements, visual editor improvements, and more.

## License

MIT — use it, modify it, enjoy it.