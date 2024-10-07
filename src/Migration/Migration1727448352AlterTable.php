<?php

declare(strict_types=1);

namespace Frosh\MailArchive\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1727448352AlterTable extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1727448352;
    }

    public function update(Connection $connection): void
    {
        $connection->executeStatement(
            'ALTER TABLE `frosh_mail_archive` CHANGE `source_mail_id` `parent_id` binary(16) NULL;'
        );

        $connection->executeStatement(
            'ALTER TABLE `frosh_mail_archive` ADD `history_group_id` BINARY(16) GENERATED ALWAYS AS (COALESCE(`parent_id`, `id`)) VIRTUAL;'
        );

        'UPDATE frosh_mail_archive SET history_group_id = COALESCE(`parent_id`, `id`)';
    }

    public function updateDestructive(Connection $connection): void
    {
    }
}
