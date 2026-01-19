<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateCadastroMilitarCursosTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Tabela intermediária para relacionar cadastro_militares com cursos_militares
     */
    public function change(): void
    {
        $table = $this->table('cadastro_militar_cursos');
        
        $table
            ->addColumn('id_cadastro_militar', 'integer', ['signed' => false])
            ->addColumn('id_curso_militar', 'integer', ['signed' => false])
            ->addForeignKey('id_cadastro_militar', 'cadastro_militares', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE'
            ])
            ->addForeignKey('id_curso_militar', 'cursos_militares', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE'
            ])
            ->addIndex(['id_cadastro_militar', 'id_curso_militar'], ['unique' => true])
            ->create();
    }
}
