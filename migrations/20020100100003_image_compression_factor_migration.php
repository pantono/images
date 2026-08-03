<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class ImageCompressionFactorMigration extends AbstractMigration
{
    public function change(): void
    {
        $this->table('image_size_type')
            ->addColumn('compression_factor', 'integer', ['null' => true])
            ->update();
    }
}