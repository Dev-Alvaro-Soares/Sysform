<?php

use Phinx\Migration\AbstractMigration;

class UpdateVeiculosTableSchema extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('registro_veiculos');

        if (!$table->hasColumn('nome')) {
            $table->addColumn('nome', 'string', ['limit' => 150, 'null' => true]);
        }
        if (!$table->hasColumn('matricula')) {
            $table->addColumn('matricula', 'string', ['limit' => 50, 'null' => true]);
        }
        if (!$table->hasColumn('data_missao')) {
            $table->addColumn('data_missao', 'date', ['null' => true]);
        }
        if (!$table->hasColumn('modelo')) {
            $table->addColumn('modelo', 'string', ['limit' => 150, 'null' => true]);
        }
        if (!$table->hasColumn('quilometragem_inicial')) {
            $table->addColumn('quilometragem_inicial', 'integer', ['signed' => false, 'null' => true]);
        }
        if (!$table->hasColumn('quilometragem_final')) {
            $table->addColumn('quilometragem_final', 'integer', ['signed' => false, 'null' => true]);
        }
        if (!$table->hasColumn('retirada_at')) {
            $table->addColumn('retirada_at', 'time', ['null' => true]);
        }
        if (!$table->hasColumn('devolucao_at')) {
            $table->addColumn('devolucao_at', 'time', ['null' => true]);
        }
        if (!$table->hasColumn('observacao')) {
            $table->addColumn('observacao', 'text', ['null' => true]);
        }

        // remover colunas antigas se existirem
        if ($table->hasColumn('placa')) {
            $table->removeColumn('placa');
        }
        if ($table->hasColumn('ano')) {
            $table->removeColumn('ano');
        }
        if ($table->hasColumn('cor')) {
            $table->removeColumn('cor');
        }

        $table->save();
    }
}
