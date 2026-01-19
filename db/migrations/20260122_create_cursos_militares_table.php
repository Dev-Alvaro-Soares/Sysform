<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateCursosMilitaresTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "alter()" and then "save()" when using
     * the AbstractMigration class directly.
     */
    public function change(): void
    {
        $table = $this->table('cursos_militares');
        
        $table
            ->addColumn('nome_curso', 'string', ['limit' => 255])
            ->addColumn('descricao', 'string', ['limit' => 500])
            ->addColumn('carga_horaria', 'integer')
            ->addColumn('data', 'date')
            ->addColumn('upload_arquivo', 'string', ['limit' => 255])
            ->create();
    }
}
