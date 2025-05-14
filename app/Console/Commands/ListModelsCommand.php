<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use ReflectionClass;
use ReflectionMethod;
use Illuminate\Database\Eloquent\Relations;

class ListModelsCommand extends Command
{
    protected $signature = 'model:list';
    protected $description = 'List all Eloquent models with fields and relationships';

    public function handle()
    {
        $models = collect(glob(app_path('Models/*.php')))
            ->map(fn($path) => 'App\\Models\\' . basename($path, '.php'))
            ->filter(fn($class) => class_exists($class) && is_subclass_of($class, 'Illuminate\\Database\\Eloquent\\Model'))
            ->mapWithKeys(fn($class) => [
                $class => [
                    'table' => (new $class)->getTable(),
                    'fillable' => $this->getModelFields($class, 'fillable'),
                    'casts' => $this->getModelFields($class, 'casts'),
                    'columns' => $this->getTableColumns((new $class)->getTable()),
                    'relationships' => $this->getModelRelationships($class),
                ]
            ]);

        $this->table(
            ['Model', 'Table', 'Fillable', 'Casts', 'Columns', 'Relationships'],
            $models->map(fn($data, $model) => [
                class_basename($model),
                $data['table'],
                implode(', ', $data['fillable']),
                json_encode($data['casts']),
                implode(', ', $data['columns']),
                $this->formatRelationships($data['relationships']),
            ])->toArray()
        );
    }

    protected function getModelRelationships($class)
    {
        $model = new $class;
        $reflection = new ReflectionClass($model);

        return collect($reflection->getMethods(ReflectionMethod::IS_PUBLIC))
            ->filter(fn($method) => !empty($method->getReturnType()) && str_contains(
                $method->getReturnType()?->getName() ?? '',
                'Illuminate\\Database\\Eloquent\\Relations\\'
            ))
            ->mapWithKeys(fn($method) => [
                $method->getName() => $this->getRelationshipDetails($model, $method)
            ])
            ->toArray();
    }

    protected function getRelationshipDetails($model, $method)
    {
        try {
            $return = $method->invoke($model);
            return get_class($return) . ' (' . $return->getRelated()::class . ')';
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    protected function formatRelationships($relationships)
    {
        return collect($relationships)
            ->map(fn($details, $name) => "$name: $details")
            ->implode("\n");
    }
    protected function getModelFields($class, $property)
    {
        try {
            $reflection = new ReflectionClass($class);
            $property = $reflection->getProperty($property);
            $property->setAccessible(true);
            return $property->getValue(new $class) ?: [];
        } catch (\ReflectionException $e) {
            return [];
        }
    }

    protected function getTableColumns($tableName)
    {
        try {
            return \DB::getSchemaBuilder()->getColumnListing($tableName);
            // O para más detalles:
            return collect(\DB::getDoctrineSchemaManager()->listTableColumns($tableName))
                ->map(fn($col) => $col->getName() . ' (' . $col->getType()->getName() . ')')
                ->toArray();
        } catch (\Exception $e) {
            return ['Error: ' . $e->getMessage()];
        }
    }
}
// Puedes ejecutar este comando con:
// php artisan model:list
// Esto mostrará una tabla con los modelos, sus tablas, campos, tipos de datos y relaciones.
