<?php

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
