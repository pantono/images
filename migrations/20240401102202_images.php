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
            ->addColumn('best_fit', 'boolean')
            ->create();

        $this->table('image')
            ->addColumn('file_id', 'integer', ['signed' => false])
            ->addColumn('date_created', 'datetime')
            ->addColumn('deleted', 'boolean')
            ->addColumn('mime_type', 'string', ['null' => true])
            ->addColumn('width', 'integer')
            ->addColumn('height', 'integer')
            ->addForeignKey('file_id', 'stored_file', 'id')
            ->create();

        $this->table('image_history')
            ->addColumn('image_id', 'integer', ['signed' => false])
            ->addColumn('date', 'datetime')
            ->addColumn('user_id', 'integer')
            ->addColumn('entry', 'text')
            ->addForeignKey('image_id', 'image', 'id')
            ->create();

        $this->table('image_size')
            ->addColumn('image_id', 'integer', ['signed' => false])
            ->addColumn('size_type_id', 'integer', ['signed' => false])
            ->addColumn('file_id', 'integer', ['null' => true, 'signed' => false])
            ->addColumn('date_created', 'datetime')
            ->addForeignKey('image_id', 'image', 'id')
            ->addForeignKey('size_type_id', 'image_size_type', 'id')
            ->addForeignKey('file_id', 'stored_file', 'id')
            ->create();
    }
}
