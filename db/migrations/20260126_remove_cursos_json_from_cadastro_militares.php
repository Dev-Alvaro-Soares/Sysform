<?php
/**
 * LEGADO: migration mantida apenas para referência.
 * Não é executada no ambiente atual.
 */
use Phinx\Migration\AbstractMigration;

final class RemoveCursosJsonFromCadastroMilitares extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('cadastro_militares');
        if ($table->hasColumn('cursos_json')) {
            $table->removeColumn('cursos_json')->update();
        }
    }
}
