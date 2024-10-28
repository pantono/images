<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Images extends AbstractMigration
{
    public function change(): void
    {
        $this->table('image_size_type')
            ->addColumn('name', 'string')
            ->addColumn('width', 'integer')
            ->addColumn('height', 'integer')
            ->create();

        $this->table('image')
            ->addColumn('file_id', 'integer')
            ->addForeignKey('file_id', 'stored_file', 'id')
            ->addColumn('date_created', 'datetime')
            ->addColumn('deleted', 'boolean')
            ->addColumn('mime_type', 'string')
            ->create();

        $this->table('image_history')
            ->addColumn('image_id', 'integer')
            ->addColumn('date', 'datetime')
            ->addColumn('user_id', 'integer')
            ->addColumn('entry', 'text')
            ->create();

        $this->table('image_size')
            ->addColumn('image_id', 'integer')
            ->addColumn('size_type_id', 'integer')
            ->addColumn('file_id', 'integer', ['null' => true])
            ->addColumn('date_created', 'datetime')
            ->addForeignKey('image_id', 'image', 'id')
            ->addForeignKey('size_type_id', 'image_size_type', 'id')
            ->addForeignKey('file_id', 'stored_file', 'id')
            ->create();
    }
}
