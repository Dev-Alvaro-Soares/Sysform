<?php

use Phinx\Migration\AbstractMigration;

class AdjustRegistroVeiculosColumnTypes extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('registro_veiculos');

        // nome: nome completo
        if ($table->hasColumn('nome')) {
            $table->changeColumn('nome', 'string', ['limit' => 255, 'null' => true]);
        } else {
            $table->addColumn('nome', 'string', ['limit' => 255, 'null' => true]);
        }

        // matricula: string numérica
        if ($table->hasColumn('matricula')) {
            $table->changeColumn('matricula', 'string', ['limit' => 50, 'null' => true]);
        } else {
            $table->addColumn('matricula', 'string', ['limit' => 50, 'null' => true]);
        }

        // data_missao: texto (ex.: dd.mm.aaaa) — armazenar como string para preservar formato
        if ($table->hasColumn('data_missao')) {
            $table->changeColumn('data_missao', 'string', ['limit' => 20, 'null' => true]);
        } else {
            $table->addColumn('data_missao', 'string', ['limit' => 20, 'null' => true]);
        }

        // quilometragem_inicial: inteiro não-negativo, NOT NULL
        if ($table->hasColumn('quilometragem_inicial')) {
            $table->changeColumn('quilometragem_inicial', 'integer', ['signed' => false, 'null' => false, 'default' => 0]);
        } else {
            $table->addColumn('quilometragem_inicial', 'integer', ['signed' => false, 'null' => false, 'default' => 0]);
        }

        // quilometragem_final: inteiro não-negativo, NULL enquanto não devolvido
        if ($table->hasColumn('quilometragem_final')) {
            $table->changeColumn('quilometragem_final', 'integer', ['signed' => false, 'null' => true]);
        } else {
            $table->addColumn('quilometragem_final', 'integer', ['signed' => false, 'null' => true]);
        }

        // retirada_at / devolucao_at: guardar como texto no formato hh:mm
        if ($table->hasColumn('retirada_at')) {
            $table->changeColumn('retirada_at', 'string', ['limit' => 5, 'null' => true]);
        } else {
            $table->addColumn('retirada_at', 'string', ['limit' => 5, 'null' => true]);
        }

        if ($table->hasColumn('devolucao_at')) {
            $table->changeColumn('devolucao_at', 'string', ['limit' => 5, 'null' => true]);
        } else {
            $table->addColumn('devolucao_at', 'string', ['limit' => 5, 'null' => true]);
        }

        // mantemos observacao como text

        $table->save();
    }
}
