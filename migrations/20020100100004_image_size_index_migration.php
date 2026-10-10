<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class ImageSizeIndexMigration extends AbstractMigration
{
    public function up(): void
    {
        $this->query('CREATE INDEX image_size_image_id_size_type_idx
    ON image_size (image_id, size_type_id)
    INCLUDE (file_id)');
    }

    public function down(): void
    {
        $this->query('DROP INDEX "public"."image_size_image_id_size_type_idx"');
    }
}
