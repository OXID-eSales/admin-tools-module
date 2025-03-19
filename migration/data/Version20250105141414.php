<?php

/**
 * All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\AdminTools\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250105141414 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->connection->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

        $this->addSql(
            "INSERT IGNORE INTO `oxgroups` (`oxid`,`oxactive`,`oxtitle`,`oxtitle_1`)
             VALUES ('gqladmintoolscache', '1', 'GraphQL Admintools', 'GraphQL Admintools Cache');"
        );
    }

    public function down(Schema $schema): void
    {
    }
}
