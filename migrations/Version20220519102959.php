<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220519102959 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD12469DE2 ON product (category_id)');
        $this->addSql('ALTER TABLE product_to_order DROP FOREIGN KEY FK_35A5C83FDE18E50B');
        $this->addSql('ALTER TABLE product_to_order DROP FOREIGN KEY FK_35A5C83FFCDAEAAA');
        $this->addSql('DROP INDEX IDX_35A5C83FDE18E50B ON product_to_order');
        $this->addSql('DROP INDEX IDX_35A5C83FFCDAEAAA ON product_to_order');
        $this->addSql('ALTER TABLE product_to_order ADD product_id INT NOT NULL, ADD order_id INT NOT NULL, DROP product, DROP `order`');
        $this->addSql('ALTER TABLE product_to_order ADD CONSTRAINT FK_35A5C83F4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product_to_order ADD CONSTRAINT FK_35A5C83F8D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_35A5C83F4584665A ON product_to_order (product_id)');
        $this->addSql('CREATE INDEX IDX_35A5C83F8D9F6D38 ON product_to_order (order_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('DROP INDEX IDX_D34A04AD12469DE2 ON product');
        $this->addSql('ALTER TABLE product_to_order DROP FOREIGN KEY FK_35A5C83F4584665A');
        $this->addSql('ALTER TABLE product_to_order DROP FOREIGN KEY FK_35A5C83F8D9F6D38');
        $this->addSql('DROP INDEX IDX_35A5C83F4584665A ON product_to_order');
        $this->addSql('DROP INDEX IDX_35A5C83F8D9F6D38 ON product_to_order');
        $this->addSql('ALTER TABLE product_to_order ADD product INT NOT NULL, ADD `order` INT NOT NULL, DROP product_id, DROP order_id');
        $this->addSql('ALTER TABLE product_to_order ADD CONSTRAINT FK_35A5C83FDE18E50B FOREIGN KEY (product) REFERENCES product (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE product_to_order ADD CONSTRAINT FK_35A5C83FFCDAEAAA FOREIGN KEY (`order`) REFERENCES `order` (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_35A5C83FDE18E50B ON product_to_order (product)');
        $this->addSql('CREATE INDEX IDX_35A5C83FFCDAEAAA ON product_to_order (`order`)');
    }
}
