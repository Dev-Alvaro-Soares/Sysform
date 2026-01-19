<?php
use Phinx\Migration\AbstractMigration;

final class CreateEquipeMilitarTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('equipe_militar');
        $table
            ->addColumn('patente', 'string', ['limit' => 100, 'null' => false])
            ->addColumn('nome', 'string', ['limit' => 150, 'null' => false])
            ->addColumn('funcao', 'string', ['limit' => 120, 'null' => false])
            ->addColumn('id_registro_escolta', 'integer', ['null' => false, 'signed' => false])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addForeignKey('id_registro_escolta', 'registro_escolta', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->create();
    }
}
