<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected array $columns = [
        'services' => ['name', 'short_description', 'description'],
        'research_projects' => ['title', 'summary', 'content'],
        'articles' => ['title', 'excerpt', 'content'],
        'categories' => ['name', 'description'],
    ];

    public function up(): void
    {
        foreach ($this->columns as $table => $fields) {
            foreach ($fields as $field) {
                $rows = DB::table($table)->select('id', $field)->get();

                Schema::table($table, function ($blueprint) use ($field) {
                    $blueprint->json($field.'__tmp')->nullable()->after($field);
                });

                foreach ($rows as $row) {
                    DB::table($table)->where('id', $row->id)->update([
                        $field.'__tmp' => json_encode(['id' => $row->{$field} ?? '', 'en' => $row->{$field} ?? '']),
                    ]);
                }

                Schema::table($table, function ($blueprint) use ($field) {
                    $blueprint->dropColumn($field);
                });

                Schema::table($table, function ($blueprint) use ($field) {
                    $blueprint->renameColumn($field.'__tmp', $field);
                });
            }
        }
    }

    public function down(): void
    {
        foreach ($this->columns as $table => $fields) {
            foreach ($fields as $field) {
                $rows = DB::table($table)->select('id', $field)->get();

                Schema::table($table, function ($blueprint) use ($field) {
                    $blueprint->text($field.'__tmp')->nullable()->after($field);
                });

                foreach ($rows as $row) {
                    $decoded = json_decode($row->{$field} ?? '{}', true);

                    DB::table($table)->where('id', $row->id)->update([
                        $field.'__tmp' => $decoded['id'] ?? null,
                    ]);
                }

                Schema::table($table, function ($blueprint) use ($field) {
                    $blueprint->dropColumn($field);
                });

                Schema::table($table, function ($blueprint) use ($field) {
                    $blueprint->renameColumn($field.'__tmp', $field);
                });
            }
        }
    }
};
