<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class RemoveCadastroMilitarCursosTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Remove a tabela intermediária desnecessária
     */
    public function change(): void
    {
        $this->table('cadastro_militar_cursos')->drop()->save();
    }
}
