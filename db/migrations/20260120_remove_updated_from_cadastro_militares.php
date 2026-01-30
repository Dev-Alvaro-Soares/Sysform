<?php
/**
 * LEGADO: migration mantida apenas para referência.
 * Não é executada no ambiente atual.
 */

use Phinx\Migration\AbstractMigration;

class RemoveUpdatedFromCadastroMilitares extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('cadastro_militares');

        if ($table->hasColumn('updated_at')) {
            $table->removeColumn('updated_at')->save();
        }
    }
}
