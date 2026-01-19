<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddIdCadastroMilitarToCursosMilitaresTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Adiciona chave estrangeira para relacionar cursos ao cadastro do militar
     */
    public function change(): void
    {
        $table = $this->table('cursos_militares');
        
        $table
            ->addColumn('id_cadastro_militar', 'integer', ['signed' => false, 'null' => true])
            ->addForeignKey('id_cadastro_militar', 'cadastro_militares', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE'
            ])
            ->save();
    }
}
