<?php

use Phinx\Migration\AbstractMigration;

class ModifyRegistroVeiculosColumns extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('registro_veiculos');

        // Renomear colunas se existirem
        if ($table->hasColumn('retirada_at') && !$table->hasColumn('retirada')) {
            $table->renameColumn('retirada_at', 'retirada');
        }
        if ($table->hasColumn('devolucao_at') && !$table->hasColumn('devolucao')) {
            $table->renameColumn('devolucao_at', 'devolucao');
        }

        // Remover updated_at se existir
        if ($table->hasColumn('updated_at')) {
            $table->removeColumn('updated_at');
        }

        $table->save();
    }
}
