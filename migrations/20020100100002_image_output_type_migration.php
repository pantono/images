<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class ImageOutputTypeMigration extends AbstractMigration
{
    public function change(): void
    {
        $this->table('image_size_type')
            ->addColumn('output_type', 'string', ['null' => true])
            ->update();
    }
}
